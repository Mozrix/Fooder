<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $toko = $user?->toko;

        $pesananAktifQuery = $toko ? $toko->pesanan()
            ->whereNotIn('status', ['selesai', 'dibatalkan'])
            ->whereHas('pembayaran', fn ($q) => $q->where('status', 'paid')) : null;
        $countActive = $pesananAktifQuery ? (clone $pesananAktifQuery)->count() : 0;
        $countKonfirmasi = $pesananAktifQuery ? (clone $pesananAktifQuery)->where('status', 'menunggu konfirmasi')->count() : 0;
        $countDimasak = $pesananAktifQuery ? (clone $pesananAktifQuery)->whereIn('status', ['diproses', 'diprosses'])->count() : 0;
        $countSiapAmbil = $pesananAktifQuery ? (clone $pesananAktifQuery)->where('status', 'siap diambil')->count() : 0;

        $revenueToday = $toko ? (float) $toko->pesanan()
            ->where('status', 'selesai')
            ->whereDate('created_at', today())
            ->sum('total_harga') : 0;

        $notaCount = $toko ? $toko->pesanan()
            ->where('status', 'selesai')
            ->whereDate('created_at', today())
            ->count() : 0;

        $revenueYesterday = $toko ? (float) $toko->pesanan()
            ->where('status', 'selesai')
            ->whereDate('created_at', today()->subDay())
            ->sum('total_harga') : 0;

        $diffPercentage = null;
        if ($revenueYesterday > 0) {
            $diffPercentage = round((($revenueToday - $revenueYesterday) / $revenueYesterday) * 100, 1);
        }

        $stokMenipisCount = $toko ? $toko->produk()
            ->where('stok', '<=', 5)
            ->whereNotin('stok', [0])
            ->count() : 0;

        $stockHabisCount = $toko ? $toko->produk()
            ->where('stok', '=', 0)
            ->count() : 0;
    

        $recentOrders = $toko ? $toko->pesanan()
            ->with(['user', 'detailPesanan.produk', 'antrian'])
            ->whereNotIn('status', ['selesai', 'dibatalkan'])
            ->whereHas('pembayaran', fn ($q) => $q->where('status', 'paid'))
            ->latest()
            ->take(6)
            ->get() : collect();

        $bestSellers = collect();
        if ($toko) {
            $bestSellers = DetailPesanan::query()
                ->whereHas('pesanan', function ($q) use ($toko) {
                    $q->where('toko_id', $toko->id)
                      ->where('status', 'selesai');
                })
                ->with('produk')
                ->selectRaw('produk_id, SUM(jumlah) as total_terjual, SUM(total_harga) as total_pendapatan')
                ->groupBy('produk_id')
                ->orderByDesc('total_terjual')
                ->take(5)
                ->get();
        }

        $dailyRevenue = collect();
        $hasAnyRevenue = false;

        if ($toko) {
            $daysNames = [
                0 => 'Minggu',
                1 => 'Senin',
                2 => 'Selasa',
                3 => 'Rabu',
                4 => 'Kamis',
                5 => 'Jumat',
                6 => 'Sabtu',
            ];

            for ($i = 0; $i < 7; $i++) {
                $targetDate = today()->subDays($i);
                $dayOfWeek = (int) $targetDate->format('w');
                $dayName = $daysNames[$dayOfWeek] ?? $targetDate->format('l');

                $ordersOnDay = $toko->pesanan()
                    ->where('status', 'selesai')
                    ->whereDate('created_at', $targetDate);

                $ordersCount = (clone $ordersOnDay)->count();
                $totalOnDay = (float) (clone $ordersOnDay)->sum('total_harga');

                if ($totalOnDay > 0) {
                    $hasAnyRevenue = true;
                }

                $dailyRevenue->push([
                    'is_today' => ($i === 0),
                    'day_label' => ($i === 0) ? "Hari Ini ({$dayName})" : $dayName,
                    'date_sub' => $targetDate->format('d M Y') . ' · ' . ($i === 0 ? 'Sedang Berjalan' : $ordersCount . ' pesanan'),
                    'orders_count' => $ordersCount,
                    'total' => $totalOnDay,
                ]);
            }
        }

        return view('seller.dashboard', compact(
            'toko',
            'countActive',
            'countKonfirmasi',
            'countDimasak',
            'countSiapAmbil',
            'revenueToday',
            'notaCount',
            'revenueYesterday',
            'diffPercentage',
            'recentOrders',
            'bestSellers',
            'dailyRevenue',
            'hasAnyRevenue',
            'stokMenipisCount',
            'stockHabisCount'
        ));
    }
}
