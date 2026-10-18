<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Fooder</title>
</head>
<body>
    <nav>
        <a href="{{ route('customer.pesanan.index') }}">← Kembali ke Riwayat</a>
        <a href="{{ url('/home') }}">Beranda</a>
    </nav>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Keluar / Logout</button>
    </form>

    @if ($pesanan)
        <h1>Detail Pesanan</h1>

        <table>
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
                <td>{{ $pesanan->status }}</td>
            </tr>
            <tr>
                <th>Total Harga</th>
                <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
            </tr>
        </table>

        <h2>Item Pesanan</h2>
        <table>
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
                        <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    @endif
</body>
</html>
