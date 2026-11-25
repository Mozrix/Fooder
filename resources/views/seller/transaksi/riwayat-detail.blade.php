@extends('layouts.sellerSidebar')

@section('title', 'Detail Riwayat')

@section('content')
    <p><a href="{{ route('seller.riwayat') }}">Kembali ke riwayat</a></p>

    <h1>Detail Riwayat Pesanan {{ $pesanan->kode_pesanan }}</h1>

    <dl>
        <dt>Kode Pesanan</dt>
        <dd>{{ $pesanan->kode_pesanan }}</dd>

        <dt>Pelanggan</dt>
        <dd>{{ $pesanan->user->nama ?? '-' }}</dd>

        <dt>Tipe Pesanan</dt>
        <dd>{{ ucfirst($pesanan->tipe_pesanan) }}</dd>

        <dt>Nomor Antrian</dt>
        <dd>{{ $pesanan->antrian ? $pesanan->antrian->nomor_antrian : '-' }}</dd>

        <dt>Status</dt>
        <dd>{{ ucfirst($pesanan->status) }}</dd>

        <dt>Metode Pembayaran</dt>
        <dd>{{ ucfirst($pesanan->pembayaran?->metode_pembayaran ?? 'Cash') }} ({{ ucfirst($pesanan->pembayaran?->status ?? 'Lunas') }})</dd>

        <dt>Waktu Selesai</dt>
        <dd>{{ $pesanan->updated_at->format('d/m/Y H:i') }}</dd>
    </dl>

    <h3>Daftar Item</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan->detailPesanan as $detail)
                <tr>
                    <td>{{ $detail->produk->nama_produk ?? 'Menu' }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" align="right">Total</th>
                <th>Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
@endsection

