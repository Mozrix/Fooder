<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\HistoriStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $query = $toko->produk()->with('kategori');

        if ($request->filled('search')) {
            $search = Str::lower($request->search);
            $query->whereRaw('LOWER(nama_produk) LIKE ?', ["%{$search}%"]);
        }

        if ($request->status === 'tersedia') {
            $query->where('stok', '>', 0);
        } elseif ($request->status === 'hampir_habis') {
            $query->where('stok', '>', 0)->where('stok', '<', 5);
        } elseif ($request->status === 'habis') {
            $query->where('stok', '<=', 0);
        }

        $produk = $query->latest()
            ->paginate(10)
            ->withQueryString();

        $totalMenu = $toko->produk()->count();
        $stokAman = $toko->produk()->where('stok', '>=', 5)->count();
        $stokMenipis = $toko->produk()->where('stok', '<', 5)->count();
        $stokTersedia = $toko->produk()->where('stok', '>', 0)->count();
        $stokHampirHabis = $toko->produk()->where('stok', '>', 0)->where('stok', '<', 5)->count();
        $stokHabis = $toko->produk()->where('stok', '<=', 0)->count();

        return view('seller.stok.index', compact(
            'produk',
            'totalMenu',
            'stokAman',
            'stokMenipis',
            'stokTersedia',
            'stokHampirHabis',
            'stokHabis'
        ));
    }

    public function update(Request $request, $id)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $data = $request->validate([
            'jenis'      => ['required', Rule::in(['restock', 'koreksi'])],
            'jumlah'     => ['required', 'integer', 'min:0'],
            'keterangan' => ['required_if:jenis,koreksi', 'nullable', 'string', 'max:255'],
        ]);

        $jumlah = (int) $data['jumlah'];

        $keterangan = $data['jenis'] === 'restock' ? 'restock' : trim($data['keterangan']);

        if ($data['jenis'] === 'restock' && $jumlah < 1) {
            return back()
                ->withErrors(['jumlah' => 'Jumlah restock harus lebih besar dari 0.'])
                ->withInput();
        }

        DB::transaction(function () use ($toko, $id, $data, $jumlah, $request, $keterangan) {
            $produk = $toko->produk()->lockForUpdate()->findOrFail($id);

            $sebelum = (int) $produk->stok;
            $sesudah = $data['jenis'] === 'restock'
                ? $sebelum + $jumlah
                : $jumlah;

            $produk->update([
                'stok' => $sesudah,
                'in_stock' => ($sesudah > 0),
            ]);

            HistoriStok::create([
                'produk_id'        => $produk->id,
                'user_id'          => $request->user()->id,
                'tipe'             => 'manual',
                'jumlah_sebelum'   => $sebelum,
                'jumlah_perubahan' => $sesudah - $sebelum,
                'jumlah_setelah'   => $sesudah,
                'keterangan'       => $keterangan,
            ]);
        });

        return redirect()
            ->route('seller.stok')
            ->with('success', 'Stok berhasil diperbarui.');
    }

    public function RiwayatStokIndex(Request $request, $id){
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $pesanan = $toko->pesanan()->findOrFail($id);
        $query = HistoriStok::where('pesanan_id', $pesanan->id)->with('produk');

        return view('seller.riwayat-stok', compact('pesanan', 'query'));
    }
}
