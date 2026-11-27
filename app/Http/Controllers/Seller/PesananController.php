<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\HistoriStok;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $query = Pesanan::where('toko_id', $toko->id)
            ->whereNotIn('status', ['selesai', 'dibatalkan'])
            ->with(['user', 'detailPesanan.produk', 'antrian', 'pembayaran']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = Str::lower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(kode_pesanan) LIKE ?', ["%{$search}%"])
                  ->orWhereHas('user', fn ($u) => $u->whereRaw('LOWER(nama) LIKE ?', ["%{$search}%"]));
            });
        }

        $pesanan = $query->latest()->paginate(10)->withQueryString();
        $base = $toko->pesanan()->whereNotIn('status', ['selesai', 'dibatalkan']);
        $countSemua = (clone $base)->count();
        $countMenunggu = (clone $base)->where('status', 'menunggu konfirmasi')->count();
        $countDiproses = (clone $base)->whereIn('status', ['diprosses'])->count();
        $countSiap = (clone $base)->where('status', 'siap diambil')->count();

        return view('seller.pesanan.index', compact('pesanan', 'countSemua', 'countMenunggu', 'countDiproses', 'countSiap'));
    }

    public function show(Request $request, $id)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $pesanan = $toko->pesanan()->findOrFail($id);

        return view('seller.pesanan.show', compact('pesanan'));
    }

    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko || $pesanan->toko_id !== $toko->id, 403);

        $data = $request->validate([
            'status' => ['required', Rule::in(['diprosses', 'siap diambil', 'selesai', 'dibatalkan'])],
        ]);

        if ($data['status'] === 'selesai') {
            $this->selesaikanPesanan($pesanan, $request);

            return back()->with('ok', 'Pesanan telah selesai dan stok diperbarui.');
        }

        $pesanan->update(['status' => $data['status']]);

        return back()->with('ok', 'Status pesanan berhasil diperbarui.');
    }

        private function selesaikanPesanan(Pesanan $pesanan, Request $request): void
    {
        DB::transaction(function () use ($pesanan, $request) {
            $pesanan = Pesanan::whereKey($pesanan->id)->lockForUpdate()->firstOrFail();

            if ($pesanan->status === 'selesai') {
                return;
            }

            $details = $pesanan->detailPesanan()->get();
            $jumlahPerProduk = $details->groupBy('produk_id')
                ->map(fn ($items) => (int) $items->sum('jumlah'));
            $produkById = Produk::whereIn('id', $jumlahPerProduk->keys()->sort()->values())
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($jumlahPerProduk as $produkId => $jumlah) {
                $produk = $produkById->get($produkId);
                if (!$produk || (int) $produk->stok < $jumlah) {
                    throw ValidationException::withMessages([
                        'stok' => 'Stok produk tidak mencukupi untuk menyelesaikan pesanan.',
                    ]);
                }

                $stokSebelum = (int) $produk->stok;
                $stokSesudah = $stokSebelum - $jumlah;

                $produk->update([
                    'stok' => $stokSesudah,
                    'in_stock' => $stokSesudah > 0,
                ]);

                HistoriStok::create([
                    'produk_id' => $produk->id,
                    'user_id' => $request->user()->id,
                    'tipe' => 'otomatis',
                    'jumlah_sebelum' => $stokSebelum,
                    'jumlah_perubahan' => -$jumlah,
                    'jumlah_setelah' => $stokSesudah,
                    'keterangan' => 'Pesanan ' . $pesanan->kode_pesanan . ' selesai',
                ]);
            }

            $pesanan->update(['status' => 'selesai']);
        });
    }
}
