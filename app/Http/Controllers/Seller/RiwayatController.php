<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\HistoriStok;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $status = $request->get('status', 'semua');
        $query = Pesanan::where('toko_id', $toko->id)
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->with(['user', 'detailPesanan.produk', 'antrian', 'pembayaran']);

        if ($status === 'selesai' || $status === 'sukses') {
            $query->where('status', 'selesai');
        } elseif ($status === 'dibatalkan' || $status === 'batal') {
            $query->where('status', 'dibatalkan');
        }

        if ($request->filled('date_from') || $request->filled('date_to') || $request->filled('date')) {
            $parseDate = function ($dateStr) {
                if (!$dateStr) return null;
                $bulanMap = [
                    'Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr',
                    'Mei' => 'May', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Agu' => 'Aug',
                    'Ags' => 'Aug', 'Sep' => 'Sep', 'Okt' => 'Oct', 'Nov' => 'Nov', 'Des' => 'Dec'
                ];
                $englishDate = strtr($dateStr, $bulanMap);
                $time = strtotime($englishDate);
                return $time ? date('Y-m-d', $time) : null;
            };

            $from = $parseDate($request->date_from);
            $to = $parseDate($request->date_to);

            if ($from && $to) {
                $query->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
            } elseif ($from) {
                $query->where('created_at', '>=', $from . ' 00:00:00');
            } elseif ($to) {
                $query->where('created_at', '<=', $to . ' 23:59:59');
            } elseif ($request->filled('date')) {
                $query->whereDate('created_at', $request->date);
            }
        }

        if ($request->filled('metode')) {
            $metode = Str::lower($request->metode);
            $query->whereHas('pembayaran', function ($p) use ($metode) {
                $p->where('metode_pembayaran', 'like', "%{$metode}%");
            });
        }

        if ($request->filled('search')) {
            $search = Str::lower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(kode_pesanan) LIKE ?', ["%{$search}%"])
                  ->orWhereHas('user', fn ($u) => $u->whereRaw('LOWER(nama) LIKE ?', ["%{$search}%"]));
                $q->orWhereHas('detailPesanan.produk', fn ($p) => $p->whereRaw('LOWER(nama_produk) LIKE ?', ["%{$search}%"]));
            });
        }

        $riwayatPesanan = $query->latest()->paginate(10)->withQueryString();
        $base = $toko->pesanan()->whereIn('status', ['selesai', 'dibatalkan']);
        $countSelesai = (clone $base)->where('status', 'selesai')->count();
        $countBatal = (clone $base)->where('status', 'dibatalkan')->count();
        $countDitolak = 0;
        $countSemua = (clone $base)->count();
        $totalPendapatan = (clone $base)->where('status', 'selesai')->sum('total_harga');
        $successRate = $countSemua > 0 ? round(($countSelesai / $countSemua) * 100, 1) : 100;
        $statusFilter = $status;

        return view('seller.transaksi.riwayat', compact(
            'riwayatPesanan',
            'countSelesai',
            'countBatal',
            'countDitolak',
            'countSemua',
            'totalPendapatan',
            'successRate',
            'statusFilter'
        ));
    }

    public function show(Request $request, $id)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $pesanan = $toko->pesanan()->findOrFail($id);

        return view('seller.riwayat-detail', compact('pesanan'));
    }

    public function stokIndex(Request $request)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $riwayatStok = HistoriStok::query()
            ->whereHas('produk', fn ($query) => $query->where('toko_id', $toko->id))
            ->with(['produk', 'user'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('seller.stok.riwayat-stok', compact('riwayatStok'));
    }

    public function stok(Request $request, $id)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $produk = $toko->produk()->findOrFail($id);
        $riwayatStok = $produk->historiStok()
            ->with('user')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('seller.stok.riwayat-stok', compact('produk', 'riwayatStok'));
    }
}
