@extends('layouts.sellerSidebar')

@section('title', 'Riwayat Pesanan')
@section('main_class', 'main-content-riwayat')
@section('main_class', 'main-content-orange')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menuSeller.css') }}">
@endpush

@section('content')
<div class="riwayat-orange-container">

    <div class="riwayat-header-banner">
        <div class="blur-overlay"></div>
        <div class="riwayat-header-left">
            <h1 class="riwayat-header-title">Riwayat Pesanan</h1>
        </div>
        <div>
            <button type="button" class="btn-cetak-rekap" onclick="window.print()">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Rekap Laporan</span>
            </button>
        </div>
    </div>

    <div class="riwayat-metric-grid">
        <div class="riwayat-metric-card">
            <div class="bottom-bar metric-bar-green"></div>
            <div class="metric-content">
                <div class="metric-label">TOTAL PESANAN SELESAI</div>
                <div class="metric-val-row">
                    <span class="metric-val-large">{{ $countSelesai ?? 0 }}</span>
                    <span class="metric-val-sub">Transaksi</span>
                </div>
            </div>
            <div class="metric-icon-box">
                <i class="fa-solid fa-check"></i>
            </div>
        </div>

        <!-- Metric 2: Net Revenue -->
        <div class="riwayat-metric-card">
            <div class="bottom-bar metric-bar-orange"></div>
            <div class="metric-content">
                <div class="metric-label">PENDAPATAN BERSIH</div>
                <div class="metric-val-row">
                    <span class="metric-val-large orange">
                        {{ $totalPendapatan > 0 ? ('Rp ' . number_format($totalPendapatan ?? 0, 0, ',', '.')) : 'Rp 0' }}
                    </span>
                </div>
            </div>
            <div class="metric-icon-box">
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>

        <!-- Metric 3: Success Rate -->
        <div class="riwayat-metric-card">
            <div class="bottom-bar metric-bar-mint"></div>
            <div class="metric-content">
                <div class="metric-label">TINGKAT KEBERHASILAN</div>
                <div class="metric-val-row">
                    <span class="metric-val-large green">{{ $countSemua > 0 ? $successRate : '0' }}%</span>
                    <span class="metric-val-sub green">Tinggi</span>
                </div>
            </div>
            <div class="metric-ring-box">
                <svg class="metric-ring-svg" viewBox="0 0 56 56">
                    <circle class="metric-ring-bg" cx="28" cy="28" r="21"></circle>
                    <circle class="metric-ring-fill" cx="28" cy="28" r="21"
                        stroke-dasharray="131.95"
                        stroke-dashoffset="{{ 131.95 - (131.95 * ($countSemua > 0 ? $successRate : 0) / 100) }}">
                    </circle>
                </svg>
                <span class="metric-ring-text">{{ round($countSemua > 0 ? $successRate : 0) }}%</span>
            </div>
        </div>
    </div>

    {{-- Filter & Search Toolbar Card --}}
    <div class="riwayat-filter-toolbar">
        <form method="get" action="{{ route('seller.riwayat') }}" id="formRiwayatFilter" style="display:flex; flex-direction:column; gap:16px; margin:0; width:100%;">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <!-- Top Row: Date Range & Quick Search -->
            <div class="filter-top-row">
                <div class="date-range-container">
                    <div class="date-picker-box">
                        <i class="fa-regular fa-calendar"></i>
                        <span class="date-picker-label">Dari:</span>
                        <input type="text" name="date_from"
                               value="{{ request('date_from', '01 Okt 2024') }}"
                               class="date-picker-input">
                    </div>

                    <span class="date-separator">—</span>

                    <div class="date-picker-box">
                        <i class="fa-regular fa-calendar"></i>
                        <span class="date-picker-label">Sampai:</span>
                        <input type="text" name="date_to"
                               value="{{ request('date_to', '31 Okt 2024') }}"
                               class="date-picker-input">
                    </div>

                    <button type="submit" class="btn-terapkan-action">Terapkan</button>
                </div>

                <div class="quick-search-wrapper">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari ID transaksi, nama pembeli, atau menu..."
                           class="quick-search-input"
                           onchange="document.getElementById('formRiwayatFilter').submit()">
                </div>
            </div>

            <!-- Bottom Row: Status Buttons & Payment Method -->
            <div class="filter-bottom-row">
                <div class="status-buttons-group">
                    <span class="status-group-label">Status:</span>
                    <a href="{{ route('seller.riwayat', array_merge(request()->except(['status', 'page']), ['status' => 'semua'])) }}"
                       class="filter-pill {{ (!request('status') || request('status') === 'semua') ? 'active' : '' }}">
                        Semua ({{ $countSemua ?? 0 }})
                    </a>
                    <a href="{{ route('seller.riwayat', array_merge(request()->except(['status', 'page']), ['status' => 'selesai'])) }}"
                       class="filter-pill {{ request('status') === 'selesai' ? 'active' : '' }}">
                        Selesai  ({{ $countSelesai ?? 0 }})
                    </a>
                    <a href="{{ route('seller.riwayat', array_merge(request()->except(['status', 'page']), ['status' => 'dibatalkan'])) }}"
                       class="filter-pill {{ request('status') === 'dibatalkan' ? 'active' : '' }}">
                        Dibatalkan  ({{ $countDibatalkan ?? 0 }})
                    </a>
                </div>

                <div class="payment-dropdown-filter">
                    <span class="payment-filter-label">Metode Bayar:</span>
                    <select name="metode" class="payment-filter-select" onchange="document.getElementById('formRiwayatFilter').submit()">
                        <option value="">Semua Metode</option>
                        <option value="qris" {{ strtolower(request('metode')) === 'qris' ? 'selected' : '' }}>QRIS</option>
                        <option value="gopay" {{ strtolower(request('metode')) === 'gopay' ? 'selected' : '' }}>GoPay</option>
                        <option value="tunai" {{ strtolower(request('metode')) === 'tunai' ? 'selected' : '' }}>Tunai (COD)</option>
                        <option value="ovo" {{ strtolower(request('metode')) === 'ovo' ? 'selected' : '' }}>OVO</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    {{-- Main Table Section --}}
    <div class="riwayat-main-table-card">
        <div style="overflow-x:auto;">
            <table class="riwayat-figma-table">
                <thead>
                    <tr>
                        <th style="width:12%;">TRANSAKSI</th>
                        <th style="width:11%;">TANGGAL & WAKTU</th>
                        <th style="width:14%;">PELANGGAN</th>
                        <th style="width:28%;">RINGKASAN PESANAN</th>
                        <th style="width:11%;">METODE BAYAR</th>
                        <th style="width:10%;">TOTAL TAGIHAN</th>
                        <th style="width:10%;">STATUS</th>
                        <th style="width:4%;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatPesanan as $item)
                        @php
                            $status = strtolower($item->status);
                            $isCancelled = in_array($status, ['dibatalkan', 'ditolak_toko', 'ditolak']);
                            $userName = $item->user->nama ?? 'Pelanggan';
                            $words = explode(' ', trim($userName));
                            $initials = strtoupper(substr($words[0] ?? 'P', 0, 1) . substr($words[1] ?? '', 0, 1));
                            $metode = strtolower($item->pembayaran?->metode_pembayaran ?? 'tunai');
                            
                            $avatarPalette = [
                                ['bg' => '#5BB8FE', 'color' => '#00476E'],
                                ['bg' => '#FFDBCE', 'color' => '#370E00'],
                                ['bg' => '#6FFBBE', 'color' => '#002113'],
                                ['bg' => '#FFDAD6', 'color' => '#BA1A1A'],
                                ['bg' => '#93CCFF', 'color' => '#001D31'],
                            ];
                            $avatar = $avatarPalette[$item->id % count($avatarPalette)];
                        @endphp
                        <tr class="{{ $isCancelled ? 'row-cancelled' : '' }}">
                            <td>
                                <span class="cell-transaksi {{ $isCancelled ? 'cancelled' : '' }}">
                                    {{ $item->kode_pesanan }}
                                </span>
                            </td>
                            <td>
                                <div class="cell-date-wrap">
                                    <span class="cell-date-main">{{ $item->created_at->format('d M Y') }}</span>
                                    <span class="cell-date-sub">{{ $item->created_at->format('H:i') }} WIB</span>
                                </div>
                            </td>
                            <td>
                                <div class="cell-pelanggan-wrap">
                                    <div class="pelanggan-avatar" style="background:{{ $avatar['bg'] }}; color:{{ $avatar['color'] }};">
                                        {{ $initials }}
                                    </div>
                                    <div class="pelanggan-info">
                                        <span class="pelanggan-nama">{{ $userName }}</span>
                                        <span class="pelanggan-telp">{{ $item->user->telepon ?? '0812-xxxx-xxxx' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-pesanan-wrap">
                                    <span class="pesanan-menu-text {{ $isCancelled ? 'strike' : '' }}">
                                        @foreach($item->detailPesanan as $idx => $detail)
                                            {{ $detail->jumlah }}x {{ $detail->produk->nama_produk ?? 'Menu' }}@if(!$loop->last), @endif
                                        @endforeach
                                    </span>
                                    @if($item->catatan)
                                        <span class="{{ $isCancelled ? 'pesanan-alasan-text' : 'pesanan-catatan-text' }}">
                                            {{ $isCancelled ? 'Alasan: ' . $item->catatan : 'Catatan: ' . $item->catatan }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if(str_contains($metode, 'qris'))
                                    <span class="metode-tag" style="background:#CCE5FF; color:#001D31;">
                                        <i class="fa-solid fa-qrcode"></i> QRIS
                                    </span>
                                @elseif(str_contains($metode, 'gopay'))
                                    <span class="metode-tag" style="background:#D3E4FE; color:#00476E;">
                                        <i class="fa-solid fa-wallet"></i> GoPay
                                    </span>
                                @elseif(str_contains($metode, 'ovo'))
                                    <span class="metode-tag" style="background:#D3E4FE; color:#00476E;">
                                        <i class="fa-solid fa-mobile-screen"></i> OVO
                                    </span>
                                @else
                                    <span class="metode-tag" style="background:#E5EEFF; color:#0B1C30;">
                                        <i class="fa-solid fa-money-bill-wave"></i> Tunai (COD)
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="cell-total-wrap">
                                    <span class="total-amount {{ $isCancelled ? 'strike' : '' }}">
                                        Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                    </span>
                                    @if($status === 'selesai')
                                        <span class="total-status-lunas">Lunas</span>
                                    @else
                                        <span class="total-status-refund">Refund / Batal</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($status === 'selesai')
                                    <span class="status-badge-overlay status-selesai">
                                        <span class="dot"></span> Selesai
                                    </span>
                                @elseif($status === 'ditolak_toko')
                                    <span class="status-badge-overlay status-ditolak">
                                        <span class="dot"></span> Ditolak Toko
                                    </span>
                                @else
                                    <span class="status-badge-overlay status-dibatalkan">
                                        <span class="dot"></span> Dibatalkan
                                    </span>
                                @endif
                            </td>
                            <td style="text-align:right;">
                                <div class="action-buttons-wrap">
                                    <a href="{{ route('seller.riwayat', $item->id) }}" class="btn-table-action-icon" title="Detail">
                                        <i class="fa-regular fa-file-lines"></i>
                                    </a>
                                    <button type="button" class="btn-table-action-icon" onclick="window.print()" title="Print">
                                        <i class="fa-solid fa-print"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr><td colspan="6" style="text-align:center;padding:40px;color:#94a3b8">Tidak ada pesanan aktif.</td></tr>
                    @endforelse                        
                </tbody>
            </table>
        </div>

        {{-- Pagination Footer Sesuai Figma --}}
        <div class="figma-pagination-footer">
            <div>
                Menampilkan <strong>{{ $riwayatPesanan->count() > 0 ? ($riwayatPesanan->firstItem()) : 0 }} - {{ $riwayatPesanan->count() > 0 ? ($riwayatPesanan->lastItem()) : 0 }}</strong> dari <strong>{{ $riwayatPesanan->count() }}</strong> data transaksi
            </div>

            <div class="figma-pagination-controls">
                @if($riwayatPesanan->count() > 0 && $riwayatPesanan->hasPages())
                    {{-- Real Laravel Pagination --}}
                    @if ($riwayatPesanan->onFirstPage())
                        <span class="figma-page-btn disabled">&lt;</span>
                    @else
                        <a href="{{ $riwayatPesanan->previousPageUrl() }}" class="figma-page-btn">&lt;</a>
                    @endif

                    @foreach ($riwayatPesanan->getUrlRange(1, $riwayatPesanan->lastPage()) as $page => $url)
                        @if ($page == $riwayatPesanan->currentPage())
                            <span class="figma-page-btn active">{{ $page }}</span>
                        @elseif ($page <= 3 || $page == $riwayatPesanan->lastPage() || abs($page - $riwayatPesanan->currentPage()) <= 1)
                            <a href="{{ $url }}" class="figma-page-btn">{{ $page }}</a>
                        @elseif ($page == 4 && $riwayatPesanan->currentPage() > 3)
                            <span style="padding:0 4px; color:#5A4138; font-weight:700;">...</span>
                        @endif
                    @endforeach

                    @if ($riwayatPesanan->hasMorePages())
                        <a href="{{ $riwayatPesanan->nextPageUrl() }}" class="figma-page-btn">&gt;</a>
                    @else
                        <span class="figma-page-btn disabled">&gt;</span>
                    @endif
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
