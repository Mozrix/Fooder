@extends('customer.layouts.app')

@section('title', '')

@section('content')
    @if ($pesanan->isEmpty())
        <p class="cust-muted">Belum ada pesanan.</p>
    @else
        <div class="cust-table-wrap">
            <table class="cust-table">
                <thead>
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Toko</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesanan as $p)
                        @php
                            $status = (string) $p->status;
                            $badge = match (true) {
                                in_array($status, ['menunggu konfirmasi', 'menunggu'], true) => 'red',
                                in_array($status, ['diproses', 'diprosses', 'sedang diproses'], true) => 'blue',
                                in_array($status, ['siap diambil'], true) => 'green',
                                in_array($status, ['selesai'], true) => 'green',
                                in_array($status, ['dibatalkan', 'ditolak', 'ditolak_toko'], true) => 'gray',
                                default => 'amber',
                            };
                        @endphp
                        <tr>
                            <td>{{ $p->kode_pesanan }}</td>
                            <td>{{ $p->detailPesanan->first()->produk->toko->nama_toko ?? '-' }}</td>
                            <td>{{ $p->created_at->format('d M Y, H:i') }}</td>
                            <td class="cust-price">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                            <td><span class="cust-badge cust-badge-{{ $badge }}">{{ $p->status }}</span></td>
                            <td>
                                <a href="{{ route('customer.pesanan.show', $p->id) }}">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="cust-page-nav">
            {{ $pesanan->links() }}
        </div>
    @endif
@endsection
