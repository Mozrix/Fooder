<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Fooder</title>
</head>
<body>
    <nav>
        <a href="{{ url('/home') }}">← Kembali ke Beranda</a>
    </nav>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Keluar / Logout</button>
    </form>

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <h1>Riwayat Pesanan</h1>

    @if ($pesanan->isEmpty())
        <p>Belum ada pesanan.</p>
    @else
        <table>
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
                    <tr>
                        <td>{{ $p->kode_pesanan }}</td>
                        <td>{{ $p->detailPesanan->first()->produk->toko->nama_toko ?? '-' }}</td>
                        <td>{{ $p->created_at->format('d M Y, H:i') }}</td>
                        <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                        <td>{{ $p->status }}</td>
                        <td>
                            <a href="{{ route('customer.pesanan.show', $p->id) }}">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div>
            {{ $pesanan->links() }}
        </div>
    @endif
</body>
</html>
