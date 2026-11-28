@extends('customer.layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
    @if ($pesanan)
        <div class="cust-card">
            <table class="cust-table">
                <tr>
                    <th>Kode Pesanan</th>
                    <td>{{ $pesanan->kode_pesanan }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ $pesanan->created_at->format('d M Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Toko</th>
                    <td>{{ $pesanan->toko->nama_toko ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tipe Pesanan</th>
                    <td>{{ ucfirst($pesanan->tipe_pesanan) }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @php
                            $badge = match (true) {
                                in_array((string) $pesanan->status, ['menunggu konfirmasi', 'menunggu'], true) => 'red',
                                in_array((string) $pesanan->status, ['diproses', 'diprosses', 'sedang diproses'], true) => 'blue',
                                in_array((string) $pesanan->status, ['siap diambil'], true) => 'green',
                                in_array((string) $pesanan->status, ['selesai'], true) => 'green',
                                in_array((string) $pesanan->status, ['dibatalkan', 'ditolak', 'ditolak_toko'], true) => 'gray',
                                default => 'amber',
                            };
                        @endphp
                        <span class="cust-badge cust-badge-{{ $badge }}">{{ $pesanan->status }}</span>
                    </td>
                </tr>
                <tr>
                    <th>Status Pembayaran</th>
                    <td>
                        @php
                            $statusBayar = $pesanan->pembayaran->status ?? 'pending';
                            $badgeBayar = match ($statusBayar) {
                                'paid' => 'green',
                                'failed' => 'red',
                                default => 'amber',
                            };
                        @endphp
                        <span class="cust-badge cust-badge-{{ $badgeBayar }}">
                            {{ strtoupper($statusBayar) }} ({{ strtoupper($pesanan->pembayaran->metode_pembayaran ?? 'QRIS') }})
                        </span>

                        @if ($statusBayar === 'pending' && $pesanan->status !== 'dibatalkan')
                            <a href="{{ route('customer.pesanan.pembayaran', $pesanan->id) }}" class="market-button market-button-small" style="margin-left: 0.5rem;">
                                Lanjutkan Pembayaran QRIS
                            </a>
                        @endif
                    </td>
                </tr>
                @if ($pesanan->antrian)
                    <tr>
                        <th>Nomor Antrian</th>
                        <td><strong>#{{ $pesanan->antrian->nomor_antrian }}</strong> ({{ ucfirst($pesanan->antrian->status) }})</td>
                    </tr>
                @endif
                <tr>
                    <th>Total Harga</th>
                    <td class="cust-price">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="cust-card">
            <h2>Item Pesanan</h2>
            <div class="cust-table-wrap">
                <table class="cust-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesanan->detailPesanan as $detail)
                            <tr>
                                <td>{{ $detail->produk->nama_produk ?? '-' }}</td>
                                <td>{{ $detail->jumlah }}</td>
                                <td class="cust-price">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td class="cust-price">Rp {{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <td class="cust-price">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif
@endsection