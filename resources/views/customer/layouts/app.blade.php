<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
    @stack('styles')
</head>
<body class="cust-page">
<div class="cust-shell">
    <!-- HEADER PUTIH FULL WIDTH (mirror .topbar di sidebarSeller.css) -->
    <header class="cust-header-top">
        <a class="cust-header-brand" href="{{ route('customer.home') }}">
            <span class="cust-header-brand-icon"><i class="fa-solid fa-utensils"></i></span>
            <span class="cust-header-brand-text">Fooder</span>
            <span class="cust-header-brand-sub">CUSTOMER</span>
        </a>

        <h1 class="cust-header-title">@yield('title', 'Customer')</h1>

        <div class="cust-header-right">
            <div class="cust-user-pill">
                <span class="cust-user-avatar">{{ substr(auth()->user()?->name ?? 'C', 0, 1) }}</span>
                <span class="cust-user-name">{{ auth()->user()?->name ?? 'Customer' }}</span>
                <span class="cust-user-tag">CUSTOMER</span>
            </div>
        </div>
    </header>

    <div class="cust-body">
        <!-- SIDEBAR PUTIH — hanya menu navigasi -->
        <aside class="cust-sidebar">
            <div class="cust-sidebar-top">
                <nav class="cust-nav">
                    <a class="{{ request()->routeIs('customer.home') ? 'active' : '' }}" href="{{ route('customer.home') }}">
                        <span class="cust-nav-icon"><i class="fa-solid fa-house"></i></span>
                        <span>Dashboard</span>
                    </a>
                    <a class="{{ request()->routeIs('customer.menu.index') ? 'active' : '' }}" href="{{ route('customer.menu.index') }}">
                        <span class="cust-nav-icon"><i class="fa-solid fa-utensils"></i></span>
                        <span>Daftar Menu</span>
                    </a>
                    <a class="{{ request()->routeIs('customer.pesanan.checkout') ? 'active' : '' }}" href="{{ route('customer.pesanan.checkout') }}">
                        <span class="cust-nav-icon"><i class="fa-solid fa-cart-shopping"></i></span>
                        <span>Keranjang</span>
                    </a>
                    <a class="{{ request()->routeIs('customer.pesanan.index') ? 'active' : '' }}" href="{{ route('customer.pesanan.index') }}">
                        <span class="cust-nav-icon"><i class="fa-solid fa-file-invoice"></i></span>
                        <span>Pesanan Saya</span>
                    </a>
                    <a href="{{ route('customer.home') }}">
                        <span class="cust-nav-icon"><i class="fa-solid fa-user"></i></span>
                        <span>Profil</span>
                    </a>
                </nav>
            </div>

            <div class="cust-sidebar-footer">
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="cust-btn-logout-sb">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN (background orange) -->
        <main class="cust-main">
            <div class="cust-content">
                @yield('content')
            </div>
        </main>
    </div>
</div>
</body>
</html>
