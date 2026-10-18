<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda Customer</title>
</head>
<body>
    <nav>
        <a href="{{ route('customer.menu.index') }}">Daftar Menu</a>
        <a href="{{ route('customer.pesanan.index') }}">Riwayat Pesanan</a>
        <a href="{{ route('customer.pesanan.checkout') }}">Checkout</a>
    </nav>

    <h1>Halaman Utama Customer</h1>
    @auth
        <p>Selamat datang, {{ Auth::user()->name }}!</p>
    @endauth

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Keluar / Logout</button>
    </form>
</body>
</html>
