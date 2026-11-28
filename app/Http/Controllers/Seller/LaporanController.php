<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    private function getLaporanData(Request $request)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $tanggalMulai = $request->input('tanggal_mulai', Carbon::now()->startOfMonth()->toDateString());
        $tanggalSelesai = $request->input('tanggal_selesai', Carbon::now()->toDateString());

        $start = Carbon::parse($tanggalMulai)->startOfDay();
        $end = Carbon::parse($tanggalSelesai)->endOfDay();

        $baseQuery = Pesanan::with(['user', 'pembayaran', 'detailPesanan.produk'])
            ->where('toko_id', $toko->id)
            ->where('status', '!=', 'dibatalkan')
            ->whereHas('pembayaran', function ($q) {
                $q->where('status', 'paid');
            })
            ->whereBetween('created_at', [$start, $end]);

        $transaksi = (clone $baseQuery)->orderByDesc('created_at')->get();

        $totalPendapatan = $transaksi->sum('total_harga');
        $jumlahTransaksi = $transaksi->count();
        $rataRataTransaksi = $jumlahTransaksi > 0 ? ($totalPendapatan / $jumlahTransaksi) : 0;

        $menuTerlaris = DetailPesanan::select(
                'produk_id',
                DB::raw('SUM(jumlah) as total_terjual'),
                DB::raw('SUM(total_harga) as total_omzet')
            )
            ->with('produk')
            ->whereHas('pesanan', function ($q) use ($toko, $start, $end) {
                $q->where('toko_id', $toko->id)
                  ->where('status', '!=', 'dibatalkan')
                  ->whereBetween('created_at', [$start, $end])
                  ->whereHas('pembayaran', function ($qp) {
                      $qp->where('status', 'paid');
                  });
            })
            ->groupBy('produk_id')
            ->orderByDesc('total_terjual')
            ->get();

        return compact(
            'toko',
            'tanggalMulai',
            'tanggalSelesai',
            'transaksi',
            'totalPendapatan',
            'jumlahTransaksi',
            'rataRataTransaksi',
            'menuTerlaris'
        );
    }

    public function index(Request $request)
    {
        return view('seller.laporan.index', $this->getLaporanData($request));
    }

    public function cetak(Request $request)
    {
        return view('seller.laporan.cetak', $this->getLaporanData($request));
    }
}
