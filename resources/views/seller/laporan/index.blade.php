@extends('layouts.sellerSidebar')

@section('title', 'Laporan Pendapatan')
@section('main_class', 'main-content-orange')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menuSeller.css') }}">
    <link rel="stylesheet" href="{{ asset('css/seller-laporan.css') }}">
@endpush

@section('content')
<div class="seller-orange-container">

    <div class="dashboard-header-card">
        <h1 class="dashboard-header-title">Laporan Pendapatan Transaksi Online</h1>
    </div>

    <div class="queue-section-card">
        {{-- Filter Tanggal & Tombol Unduh PDF --}}
        <form method="GET" action="{{ route('seller.laporan.index') }}" class="report-filter-bar">
            <div class="report-filter-group">
                <label class="form-label-modal" for="tanggal_mulai">Dari Tanggal</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-input-modal" value="{{ $tanggalMulai }}">
            </div>

            <div class="report-filter-group">
                <label class="form-label-modal" for="tanggal_selesai">Sampai Tanggal</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-input-modal" value="{{ $tanggalSelesai }}">
            </div>

            <button type="submit" class="btn-modal-submit">
                <i class="fa-solid fa-filter" style="margin-right:6px"></i>Tampilkan
            </button>

            <a href="{{ route('seller.laporan.cetak', ['tanggal_mulai' => $tanggalMulai, 'tanggal_selesai' => $tanggalSelesai]) }}" class="btn-modal-cancel" style="text-decoration:none;display:inline-flex;align-items:center">
                <i class="fa-solid fa-file-pdf" style="margin-right:6px;color:#dc2626"></i>Unduh / Cetak PDF
            </a>
        </form>

        <div class="report-note">
            <i class="fa-solid fa-circle-info" style="margin-right:6px"></i>
            <strong>Catatan:</strong> Laporan ini merekap pendapatan dari <strong>transaksi online</strong> di aplikasi Fooder dengan status pembayaran <strong>PAID</strong> (tidak mencakup penjualan tunai/offline langsung di stan).
        </div>

        {{-- Kartu Ringkasan --}}
        <div class="report-kpi-grid">
            <div class="report-kpi-card">
                <div class="report-kpi-label">Total Pendapatan Online</div>
                <div class="report-kpi-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>
            <div class="report-kpi-card">
                <div class="report-kpi-label">Transaksi Berhasil (Paid)</div>
                <div class="report-kpi-value">{{ $jumlahTransaksi }} Pesanan</div>
            </div>
            <div class="report-kpi-card">
                <div class="report-kpi-label">Rata-rata Nilai Pesanan</div>
                <div class="report-kpi-value">Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</div>
            </div>
        </div>

        {{-- Tabel Rekap Penjualan Per Menu --}}
        <h3 style="margin: 0 0 12px; font-size: 16px;">Rekap Penjualan per Menu</h3>
        <div class="report-table-wrap" style="margin-bottom: 26px;">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Menu</th>
                        <th class="report-text-center">Terjual</th>
                        <th class="report-text-right">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menuTerlaris as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->produk->nama_produk ?? 'Produk Dihapus' }}</td>
                            <td class="report-text-center">{{ $item->total_terjual }} porsi</td>
                            <td class="report-text-right">Rp {{ number_format($item->total_omzet, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="report-text-center" style="color:#64748b">Belum ada menu terjual pada rentang tanggal ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tabel Rincian Transaksi Online --}}
        <h3 style="margin: 0 0 12px; font-size: 16px;">Rincian Transaksi Online</h3>
        <div class="report-table-wrap">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kode Pesanan</th>
                        <th>Customer</th>
                        <th>Metode</th>
                        <th class="report-text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksi as $row)
                        <tr>
                            <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                            <td><strong>{{ $row->kode_pesanan }}</strong></td>
                            <td>{{ $row->user->name ?? '-' }}</td>
                            <td>{{ strtoupper($row->pembayaran->metode_pembayaran ?? 'QRIS') }}</td>
                            <td class="report-text-right">Rp {{ number_format($row->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="report-text-center" style="color:#64748b">Tidak ada transaksi online pada rentang tanggal ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection