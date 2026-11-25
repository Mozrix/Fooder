@extends('layouts.sellerSidebar')

@section('title', 'Dashboard')
@section('main_class', 'main-content-orange')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menuSeller.css') }}">
@endpush

@section('content')
<div class="seller-orange-container">

    <div class="dashboard-header-card">
        <h1 class="dashboard-header-title">Ringkasan Operasional Hari Ini</h1>
    </div>

    <div class="kpi-grid">
        <div class="kpi-card">
            <div>
                <div class="kpi-top">
                    <span class="kpi-label">PESANAN AKTIF HARI INI</span>
                    <span class="kpi-icon-circle kpi-icon-blue">
                        <i class="fa-solid fa-kitchen-set"></i>
                    </span>
                </div>
                @if($countActive > 0)
                    <div class="kpi-value-main">{{ $countActive }} Pesanan</div>
                    <div class="kpi-subtext">Sedang aktif dalam alur resto</div>
                @else
                    <div class="kpi-value-main" style="font-size: 20px; color: #94a3b8;">Tidak tersedia</div>
                    <div class="kpi-subtext">Belum ada pesanan aktif</div>
                @endif
            </div>
            <div class="kpi-pills-row">
                @if($countActive > 0)
                    <span class="kpi-pill-badge kpi-pill-red">{{ $countKonfirmasi }} Konfirmasi</span>
                    <span class="kpi-pill-badge kpi-pill-blue">{{ $countDimasak }} Dimasak</span>
                    <span class="kpi-pill-badge kpi-pill-green">{{ $countSiapAmbil }} Siap Ambil</span>
                @else
                    <span class="kpi-pill-badge" style="background: #f1f5f9; color: #94a3b8;">Tidak tersedia</span>
                @endif
            </div>
        </div>

        <div class="kpi-card">
            <div>
                <div class="kpi-top">
                    <span class="kpi-label">PENDAPATAN HARI INI</span>
                    <span class="kpi-icon-circle kpi-icon-green">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </span>
                </div>
                @if($revenueToday > 0)
                    <div class="kpi-value-main">Rp {{ number_format($revenueToday, 0, ',', '.') }}</div>
                    @if(!is_null($diffPercentage))
                        <div class="kpi-diff-green">
                            <i class="fa-solid fa-arrow-trend-up"></i>
                            <span>{{ $diffPercentage >= 0 ? '+' : '' }}{{ $diffPercentage }}%</span>
                            <span class="text-muted-diff">vs kemarin (Rp {{ number_format($revenueYesterday, 0, ',', '.') }})</span>
                        </div>
                    @else
                        <div class="kpi-subtext">Belum ada pembanding kemarin</div>
                    @endif
                @else
                    <div class="kpi-value-main" style="font-size: 20px; color: #94a3b8;">Tidak tersedia</div>
                    <div class="kpi-subtext">Belum ada pendapatan hari ini</div>
                @endif
            </div>
            <div class="kpi-footer-row">
                <span class="kpi-footer-left">Transaksi Sukses</span>
                @if($notaCount > 0)
                    <span class="kpi-footer-right">{{ $notaCount }} Nota Pembayaran</span>
                @else
                    <span class="kpi-footer-right" style="color: #94a3b8;">Tidak tersedia</span>
                @endif
            </div>
        </div>
        <div class="kpi-card" onclick="window.location.href='{{ route('seller.stok') }}'">
            <div>
                <div class="kpi-top">
                    <span class="kpi-label">Peringatan Stock</span>
                    <span class="kpi-icon-circle kpi-icon-orange">
                        <i class="fa-regular fa-star"></i>
                    </span>
                </div>
                @if($stokMenipisCount > 0)
                    <div class="kpi-value-main">{{ $stokMenipisCount }} Produk</div>
                    <div class="kpi-subtext">Stok menipis, segera restock!</div>
                @else
                    <div class="kpi-value-main" style="font-size: 20px; color: #94a3b8;">Tidak tersedia</div>
                    <div class="kpi-subtext">Semua produk aman</div>
                @endif
            </div>
            <div class="kpi-footer-row">
                <span class="kpi-footer-left">Stok habis</span>
                @if($stockHabisCount > 0)
                    <span class="kpi-footer-right">{{ $stockHabisCount }} Produk</span>
                @else
                    <span class="kpi-footer-right" style="color: #94a3b8;">Tidak tersedia</span>
                @endif
            </div>
        </div>
    </div>
    <div class="queue-section-card">
        <div class="queue-section-header">
            <div class="queue-title-block">
                <div class="queue-icon-badge">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <h2 class="queue-title-text">Queue Antrean & Pesanan Aktif</h2>
            </div>
            <div class="queue-meta-block">
                @if($countActive > 0)
                    <span class="queue-pill-meta queue-pill-total">
                        Total Antrean: <strong>{{ $countActive }}</strong>
                    </span>
                    <span class="queue-pill-meta queue-pill-menunggu">• {{ $countKonfirmasi }} Menunggu</span>
                    <span class="queue-pill-meta queue-pill-dimasak">• {{ $countDimasak }} Dimasak</span>
                    <span class="queue-pill-meta queue-pill-siap">• {{ $countSiapAmbil }} Siap Ambil</span>
                @else
                    <span class="queue-pill-meta queue-pill-total">
                        Total Antrean: <strong>0</strong>
                    </span>
                    <span class="queue-pill-meta" style="background: #f1f5f9; color: #94a3b8;">Tidak tersedia</span>
                @endif
                <a href="{{ route('seller.pesanan') }}" class="btn-manage-queue">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>Kelola Antrean di Queue →</span>
                </a>
            </div>
        </div>

        <div class="queue-table-container">
            <table class="queue-table">
                <thead>
                    <tr>
                        <th style="width: 170px;">ID & PEMESAN</th>
                        <th>ITEM PESANAN & CATATAN</th>
                        <th style="width: 180px;">STATUS ANTREAN</th>
                        <th style="width: 170px;">ESTIMASI SELESAI</th>
                        <th style="width: 150px; text-align: right;">AKSI CEPAT</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $item)
                        @php
                            $st = strtolower($item->status);
                        @endphp
                        <tr>
                            <td>
                                <div class="queue-order-id">{{ $item->kode_pesanan }}</div>
                                <div class="queue-customer-name">{{ $item->user->nama ?? 'Walk-in' }}</div>
                            </td>
                            <td>
                                <div class="queue-item-name">
                                    @if($item->detailPesanan->isNotEmpty())
                                        @foreach($item->detailPesanan->take(1) as $d)
                                            {{ $d->jumlah }}x {{ $d->produk->nama_produk ?? 'Menu' }}
                                        @endforeach
                                        @if($item->detailPesanan->count() > 1)
                                            <span style="color: #64748b; font-weight: normal;">+ {{ $item->detailPesanan->count() - 1 }} lainnya</span>
                                        @endif
                                    @else
                                        <span style="color: #94a3b8;">Tidak tersedia</span>
                                    @endif
                                </div>
                                <div class="queue-item-note">
                                    {{ $item->tipe_pesanan === 'online' ? 'Pesanan Online' : 'Walk-in' }}
                                    @if($item->antrian)
                                        · No Antrean #{{ $item->antrian->nomor_antrian }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($st === 'menunggu konfirmasi')
                                    <span class="status-pill-table status-pill-menunggu">Menunggu Konfirmasi</span>
                                @elseif(in_array($st, ['diproses', 'diprosses']))
                                    <span class="status-pill-table status-pill-dimasak">Sedang Dimasak</span>
                                @elseif($st === 'siap diambil')
                                    <span class="status-pill-table status-pill-siap">Siap Diambil</span>
                                @else
                                    <span class="status-pill-table status-pill-dimasak">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <span style="color: #64748b; font-size: 12.5px;">{{ $item->created_at->diffForHumans() }}</span>
                            </td>
                            <td style="text-align: right;">
                                @if($st === 'menunggu konfirmasi')
                                    <form method="post" action="{{ route('seller.pesanan.updateStatus', $item->id) }}" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="diproses">
                                        <button type="submit" class="btn-action-confirm">Konfirmasi</button>
                                    </form>
                                @elseif(in_array($st, ['diproses', 'diprosses']))
                                    <form method="post" action="{{ route('seller.pesanan.updateStatus', $item->id) }}" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="siap diambil">
                                        <button type="submit" class="btn-action-ready">Siap Ambil</button>
                                    </form>
                                @elseif($st === 'siap diambil')
                                    <form method="post" action="{{ route('seller.pesanan.updateStatus', $item->id) }}" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="selesai">
                                        <button type="submit" class="btn-action-handover"><i class="fa-solid fa-check"></i> Serahkan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px 16px; color: #64748b;">
                                <div style="font-size: 15px; font-weight: 700; color: #334155;">Tidak tersedia</div>
                                <div style="font-size: 12.5px; color: #94a3b8; margin-top: 4px;">Belum ada data antrean atau pesanan aktif di toko Anda saat ini.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bottom-grid">
        <div class="bottom-card">
            <div class="bottom-card-header">
                <div class="bottom-card-title-group">
                    <span class="bottom-card-icon-circle icon-circle-orange">
                        <i class="fa-solid fa-award"></i>
                    </span>
                    <div>
                        <h3 class="bottom-card-title">Best Seller Produk</h3>
                        <div class="bottom-card-sub">Top menu paling digemari minggu ini</div>
                    </div>
                </div>
                <a href="{{ route('seller.produk') }}" class="bottom-card-link">Semua Menu</a>
            </div>

            @if($bestSellers->isNotEmpty())
                <div class="bestseller-list">
                    @foreach($bestSellers as $item)
                        <div class="bestseller-item">
                            <div class="bestseller-left">
                                <span class="bestseller-rank-tag">#{{ $loop->iteration }}</span>
                                <div class="bestseller-thumb" style="display:flex; align-items:center; justify-content:center; background:#ffedd5; color:#ea580c; font-size:16px;">
                                    <i class="fa-solid fa-utensils"></i>
                                </div>
                                <div class="bestseller-info-text">
                                    <div class="bestseller-product-name">
                                        <span>{{ $item->produk->nama_produk ?? 'Menu' }}</span>
                                    </div>
                                    <div class="bestseller-qty-sold">{{ $item->total_terjual }} porsi terjual</div>
                                </div>
                            </div>
                            <div class="bestseller-right">
                                <div class="bestseller-total-amount">Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</div>
                                <div class="bestseller-trend-green">Terlaris</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 48px 16px; color: #64748b;">
                    <div style="font-size: 15px; font-weight: 700; color: #334155;">Tidak tersedia</div>
                    <div style="font-size: 12.5px; color: #94a3b8; margin-top: 4px;">Belum ada data penjualan produk best seller.</div>
                </div>
            @endif
        </div>

        <div class="bottom-card">
            <div class="bottom-card-header">
                <div class="bottom-card-title-group">
                    <span class="bottom-card-icon-circle icon-circle-green">
                        <i class="fa-solid fa-chart-simple"></i>
                    </span>
                    <div>
                        <h3 class="bottom-card-title">Pendapatan Harian (7 Hari)</h3>
                    </div>
                </div>
            </div>

            @if($hasAnyRevenue)
                <div class="daily-revenue-list">
                    @foreach($dailyRevenue as $day)
                        <div class="daily-revenue-item {{ $day['is_today'] ? 'active-today' : '' }}">
                            <div class="daily-left-info">
                                <span class="daily-day-label">{{ $day['day_label'] }}</span>
                                @if($day['is_today'])
                                    <span class="daily-dot-green"></span>
                                @endif
                                <span class="daily-date-sub">· {{ $day['date_sub'] }}</span>
                            </div>
                            <div class="daily-right-info">
                                @if($day['total'] > 0)
                                    <div class="{{ $day['is_today'] ? 'daily-amount-green' : 'daily-amount-bold' }}">
                                        Rp {{ number_format($day['total'], 0, ',', '.') }}
                                    </div>
                                    <div class="daily-tag-green">{{ $day['is_today'] ? 'Hari Ini' : $day['orders_count'] . ' transaksi' }}</div>
                                @else
                                    <div style="font-size: 12.5px; font-weight: 600; color: #94a3b8;">Tidak tersedia</div>
                                    <div class="daily-tag-gray">Rp 0</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 48px 16px; color: #64748b;">
                    <div style="font-size: 15px; font-weight: 700; color: #334155;">Tidak tersedia</div>
                    <div style="font-size: 12.5px; color: #94a3b8; margin-top: 4px;">Belum ada transaksi pendapatan dalam 7 hari terakhir.</div>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
