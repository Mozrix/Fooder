<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fooder')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer-marketplace.css') }}">
    @stack('styles')
</head>
<body class="cust-page marketplace-page">
@php
    $cartCount = collect(session('customer_cart.items', []))->sum();
@endphp
<div class="cust-shell">
    <header class="market-header">
        <div class="market-header-inner">
            <a class="market-brand" href="{{ route('customer.home') }}" aria-label="Fooder, beranda">
                <span class="market-brand-icon"><i class="fa-solid fa-utensils"></i></span>
                <span>Fooder</span>
            </a>

            <form class="market-search" action="{{ route('customer.menu.index') }}" method="GET" role="search">
                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari menu atau toko..." aria-label="Cari menu atau toko">
                <button type="submit">Cari</button>
            </form>

            <div class="market-header-actions">
                <a class="market-cart-link" href="{{ route('customer.pesanan.checkout') }}" aria-label="Keranjang, {{ $cartCount }} item">
                    <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
                    <span>Keranjang</span>
                    @if ($cartCount > 0)
                        <b>{{ $cartCount }}</b>
                    @endif
                </a>
                @auth
                    <span class="market-account">
                        <span class="market-avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                        <span class="market-account-name">{{ auth()->user()->name }}</span>
                    </span>
                @else
                    <a class="market-login" href="{{ route('login') }}">Masuk</a>
                @endauth
            </div>
        </div>

        <nav class="market-nav" aria-label="Navigasi utama">
            <div class="market-nav-inner">
                <a class="{{ request()->routeIs('customer.home') ? 'active' : '' }}" href="{{ route('customer.home') }}">Beranda</a>
                <a href="{{ route('customer.home') }}#toko">Toko &amp; Kantin</a>
                <a class="{{ request()->routeIs('customer.menu.*') ? 'active' : '' }}" href="{{ route('customer.menu.index') }}">Menu Pilihan</a>
                @auth
                    <a class="{{ request()->routeIs('customer.pesanan.index') ? 'active' : '' }}" href="{{ route('customer.pesanan.index') }}">Pesanan Saya</a>
                    <form class="market-logout" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Keluar</button>
                    </form>
                @endauth
            </div>
        </nav>
    </header>

    <main class="cust-main market-main">
        <div class="cust-content market-content">
            @if (session('ok'))
                <div class="flash cust-flash market-flash" role="status" aria-live="polite">
                    <span class="flash-content">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        <span>{{ session('ok') }}</span>
                    </span>
                    <button type="button" class="flash-close" aria-label="Tutup notifikasi">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
            @if (session('success'))
                <div class="flash cust-flash market-flash" role="status" aria-live="polite">
                    <span class="flash-content">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        <span>{{ session('success') }}</span>
                    </span>
                    <button type="button" class="flash-close" aria-label="Tutup notifikasi">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="flash flash-error market-error" role="alert" aria-live="assertive">
                    <span class="flash-content">
                        <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                        <span>{{ session('error') }}</span>
                    </span>
                    <button type="button" class="flash-close" aria-label="Tutup notifikasi">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
            @if ($errors->any())
                <div class="flash flash-error market-error" role="alert" aria-live="assertive">
                    <span class="flash-content">
                        <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </span>
                    <button type="button" class="flash-close" aria-label="Tutup notifikasi">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

    <footer class="market-footer">
        <div class="market-footer-inner">
            <div>
                <a class="market-brand" href="{{ route('customer.home') }}">
                    <span class="market-brand-icon"><i class="fa-solid fa-utensils"></i></span>
                    <span>Fooder</span>
                </a>
                <p>Temukan menu dan toko favoritmu dengan mudah.</p>
            </div>
            <div>
                <strong>Jelajahi</strong>
                <a href="{{ route('customer.home') }}#toko">Toko &amp; Kantin</a>
                <a href="{{ route('customer.menu.index') }}">Menu Pilihan</a>
            </div>
            <div>
                <strong>Akun</strong>
                @auth
                    <a href="{{ route('customer.pesanan.index') }}">Pesanan Saya</a>
                @else
                    <a href="{{ route('login') }}">Masuk</a>
                    <a href="{{ route('register') }}">Daftar</a>
                @endauth
            </div>
        </div>
        <div class="market-footer-bottom">© {{ date('Y') }} Fooder. Pilihan kuliner untuk setiap hari.</div>
    </footer>
</div>

@stack('scripts')
<script>
    (function () {
        function dismissFlash(alert) {
            if (!alert || alert.classList.contains('flash-dismissed')) return;
            alert.classList.add('flash-dismissed');
            window.setTimeout(function () {
                alert.remove();
            }, 220);
        }

        document.querySelectorAll('.flash, .cust-flash, .market-flash').forEach(function (alert) {
            var closeBtn = alert.querySelector('.flash-close');
            var timer = window.setTimeout(function () {
                dismissFlash(alert);
            }, 3000);

            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    window.clearTimeout(timer);
                    dismissFlash(alert);
                });
            }
        });
    })();
</script>
</body>
</html>
