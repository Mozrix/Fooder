<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\HistoriStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $produk = $toko->produk()
            ->when($request->search, function ($query, $search) {
                $query->where('nama_produk', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('seller.produk.stok', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $data = $request->validate([
            'jenis'      => ['required', Rule::in(['restock', 'koreksi'])],
            'jumlah'     => ['required', 'integer', 'min:0'],
            'keterangan' => [
                Rule::requiredIf($request->jenis === 'koreksi'),
                'nullable', 'string', 'max:255',
            ],
        ]);

        $jumlah = (int) $data['jumlah'];

         $keterangan = $data['jenis'] === 'restock'
            ? 'Restock Produk'
            : (filled($data['keterangan'] ?? null) ? $data['keterangan'] : 'Koreksi stok');


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

            if ($sesudah === $sebelum) {
                throw ValidationException::withMessages([
                    'jumlah' => 'Stok tidak berubah.',
                ]);
            }

            $produk->update(['stok' => $sesudah]);

            HistoriStok::create([
                'produk_id'        => $produk->id,
                'user_id'          => $request->user()->id,
                'jenis'            => $data['jenis'],
                'jumlah_sebelum'   => $sebelum,
                'jumlah_perubahan' => $sesudah - $sebelum,   // atau 'jumlah', sesuai migration
                'jumlah_setelah'   => $sesudah,
                'keterangan'       => $keterangan,
            ]);
        });

        return redirect()
            ->route('seller.produk.stok')
            ->with('success', 'Stok berhasil diperbarui.');
    }
}