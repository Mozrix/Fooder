<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Fooder</title>
</head>
<body>
    <nav>
        <a href="{{ route('customer.menu.index') }}">← Kembali ke Menu</a>
        <a href="{{ url('/home') }}">Beranda</a>
    </nav>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Keluar / Logout</button>
    </form>

    <h1>Checkout</h1>

    @if (empty($items))
        <p>Belum ada item yang dipesan.</p>
        <a href="{{ route('customer.menu.index') }}">Pilih menu</a>
    @else
        <form action="{{ route('customer.pesanan.store') }}" method="POST">
            @csrf

            <input type="hidden" name="toko_id" value="{{ $toko_id }}">
            <input type="hidden" name="tipe_pesanan" value="online">

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
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item['nama_produk'] }}</td>
                            <td>
                                <input type="hidden" name="items[{{ $item['produk_id'] }}][produk_id]" value="{{ $item['produk_id'] }}">
                                <input type="number" name="items[{{ $item['produk_id'] }}][jumlah]" min="1" value="{{ $item['jumlah'] }}">
                            </td>
                            <td>Rp {{ number_format($item['harga_satuan'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <td>Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <label for="catatan">Catatan Pesanan:</label>
            <textarea id="catatan" name="catatan" rows="3"></textarea>

            <button type="submit">Konfirmasi Pesanan</button>
        </form>
    @endif
</body>
</html>
