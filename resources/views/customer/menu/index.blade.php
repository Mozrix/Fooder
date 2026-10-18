<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Menu - Fooder</title>
</head>
<body>
    <nav>
        <a href="{{ url('/home') }}">Beranda</a>
    </nav>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Keluar / Logout</button>
    </form>

    <h1>Daftar Menu</h1>

    @if ($produk->isEmpty())
        <p>Belum ada menu yang tersedia.</p>
    @else
        @foreach ($produk as $p)
            <section>
                <h2>{{ $p->nama_produk }}</h2>
                <p>{{ $p->deskripsi }}</p>
                <p>Harga: Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                <p>Stok: {{ $p->stok }}</p>
                <p>Toko: {{ $p->toko->nama_toko ?? '-' }}</p>
                @if (isset($p->kategori))
                    <p>Kategori: {{ $p->kategori->nama_kategori ?? '-' }}</p>
                @endif
                <form action="{{ route('customer.pesanan.checkout') }}" method="GET">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $p->id }}">
                    <label for="jumlah_{{ $p->id }}">Jumlah:</label>
                    <input type="number" id="jumlah_{{ $p->id }}" name="jumlah" min="1" value="1">
                    <button type="submit">Pilih</button>
                </form>
            </section>
        @endforeach
    @endif
</body>
</html>
