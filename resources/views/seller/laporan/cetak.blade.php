<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan Online - {{ $toko->nama_toko }}</title>
    <link rel="stylesheet" href="{{ asset('css/seller-laporan.css') }}">
</head>
<body class="pdf-report-body">

    <div class="pdf-action-bar">
        <a href="{{ route('seller.laporan.index', ['tanggal_mulai' => $tanggalMulai, 'tanggal_selesai' => $tanggalSelesai]) }}" class="pdf-btn">
            ← Kembali
        </a>
        <button type="button" onclick="window.print()" class="pdf-btn pdf-btn-primary">
            Simpan PDF / Cetak Laporan
        </button>
    </div>

    <div class="pdf-sheet">
        <div class="pdf-header">
            <div>
                <h1 class="pdf-title">Laporan Pendapatan Transaksi Online</h1>
                <div class="pdf-subtitle"><strong>{{ $toko->nama_toko }}</strong></div>
                @if (!empty($toko->alamat))
                    <div class="pdf-subtitle">{{ $toko->alamat }}</div>
                @endif
            </div>
            <div style="text-align: right;">
                <div class="pdf-subtitle"><strong>Periode Laporan:</strong></div>
                <div class="pdf-subtitle">{{ \Carbon\Carbon::parse($tanggalMulai)->format('d M Y') }} – {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d M Y') }}</div>
                <div class="pdf-subtitle">Dicetak: {{ now()->format('d/m/Y H:i') }} WIB</div>
            </div>
        </div>

        <div class="pdf-summary-grid">
            <div class="pdf-summary-box">
                <span>Total Pendapatan Online</span>
                <strong>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong>
            </div>
            <div class="pdf-summary-box">
                <span>Jumlah Transaksi Lunas</span>
                <strong>{{ $jumlahTransaksi }} Pesanan</strong>
            </div>
            <div class="pdf-summary-box">
                <span>Rata-rata per Transaksi</span>
                <strong>Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</strong>
            </div>
        </div>

        <div class="pdf-section-title">1. Rekap Penjualan per Menu</div>
        <table class="pdf-table">
            <thead>
                <tr>
                    <th style="width: 8%;">No</th>
                    <th>Nama Menu</th>
                    <th class="report-text-center" style="width: 18%;">Terjual</th>
                    <th class="report-text-right" style="width: 26%;">Total Pendapatan</th>
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
                        <td colspan="4" class="report-text-center">Tidak ada data penjualan pada periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pdf-section-title">2. Rincian Transaksi Online</div>
        <table class="pdf-table">
            <thead>
                <tr>
                    <th style="width: 20%;">Waktu</th>
                    <th style="width: 22%;">Kode Pesanan</th>
                    <th>Customer</th>
                    <th style="width: 14%;">Metode</th>
                    <th class="report-text-right" style="width: 22%;">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $row)
                    <tr>
                        <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $row->kode_pesanan }}</td>
                        <td>{{ $row->user->name ?? '-' }}</td>
                        <td>{{ strtoupper($row->pembayaran->metode_pembayaran ?? 'QRIS') }}</td>
                        <td class="report-text-right">Rp {{ number_format($row->total_harga, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="report-text-center">Tidak ada transaksi online pada periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
            @if ($transaksi->isNotEmpty())
                <tfoot>
                    <tr>
                        <th colspan="4" class="report-text-right">TOTAL PENDAPATAN ONLINE</th>
                        <th class="report-text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            @endif
        </table>

        <div class="pdf-footer-note">
            * Catatan: Dokumen ini dihasilkan otomatis oleh sistem Fooder dan hanya mencatat pendapatan dari transaksi pemesanan online yang berstatus PAID (tidak mencakup transaksi tunai/offline di luar sistem).
        </div>
    </div>

</body>
</html>