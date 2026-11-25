<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'FoodOrder Seller Center') — Fooder</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebarSeller.css') }}">
    @stack('styles')
</head>
<body>
    <div class="Layout">
        <aside class="Sidebar">
            <div class="sidebar-top">
                <a href="{{ route('seller.dashboard') }}" class="brand">
                    <span class="brand-logo-text">FOODER</span>
                    <div class="brand-details">
                        <span class="brand-title-sub">FoodOrder</span>
                        <span class="brand-subtitle-sub">SELLER CENTER</span>
                    </div>
                </a>

                <div class="menu-section-label">MENU TOKO</div>

                <nav class="side-nav">
                    @php
                    $activeCount = 0;
                    if (auth()->check() && auth()->user()->toko) {
                        try {
                            $activeCount = auth()->user()->toko->pesanan()
                                ->whereNotIn('status', ['selesai', 'dibatalkan'])
                                ->count();
                        } catch (\Throwable $e) {
                            $activeCount = 0;
                        }
                    }

                    $produkGroupActive = request()->routeIs('seller.produk*', 'seller.stok*');
                    $riwayatGroupActive = request()->routeIs('seller.riwayat*');

                    $menuItems = [
                        ['label' => 'Dashboard', 'icon' => 'fa-solid fa-shapes', 'route' => 'seller.dashboard', 'pattern' => 'seller.dashboard', 'badge' => null],
                        ['label' => 'Queue', 'icon' => 'fa-regular fa-clock', 'route' => 'seller.pesanan', 'pattern' => 'seller.pesanan*', 'badge' => $activeCount . ' Aktif'],                    ];
                    @endphp

                    @foreach($menuItems as $item)
                        <a class="{{ request()->routeIs($item['pattern']) ? 'active' : '' }}" href="{{ route($item['route']) }}">
                            <div class="side-nav-content">
                                <span class="side-nav-icon"><i class="{{ $item['icon'] }}"></i></span>
                                <span>{{ $item['label'] }}</span>
                            </div>
                            @if(!empty($item['badge']))
                                <span class="nav-badge-pill">{{ $item['badge'] }}</span>
                            @endif
                        </a>
                    @endforeach

                    <div class="side-nav-group {{ $produkGroupActive ? 'open' : '' }}">
                        <button type="button" class="side-nav-group-toggle {{ $produkGroupActive ? 'active' : '' }}" aria-expanded="{{ $produkGroupActive ? 'true' : 'false' }}" aria-controls="seller-product-links">
                            <span class="side-nav-content">
                                <span class="side-nav-icon"><i class="fa-solid fa-boxes-stacked"></i></span>
                                <span>Manajemen Produk</span>
                            </span>
                            <i class="fa-solid fa-chevron-down side-nav-group-chevron" aria-hidden="true"></i>
                        </button>
                        <div class="side-nav-submenu" id="seller-product-links" {{ $produkGroupActive ? '' : 'hidden' }}>
                            <a class="side-nav-subitem {{ request()->routeIs('seller.produk*') ? 'active' : '' }}" href="{{ route('seller.produk') }}" {{ request()->routeIs('seller.produk*') ? 'aria-current=page' : '' }}>
                                <i class="fa-solid fa-utensils" aria-hidden="true"></i>
                                <span>Menu</span>
                            </a>
                            <a class="side-nav-subitem {{ request()->routeIs('seller.stok*') ? 'active' : '' }}" href="{{ route('seller.stok') }}" {{ request()->routeIs('seller.stok*') ? 'aria-current=page' : '' }}>
                                <i class="fa-solid fa-box-archive" aria-hidden="true"></i>
                                <span>Stok</span>
                            </a>
                        </div>
                    </div>

                    <div class="side-nav-group {{ $riwayatGroupActive ? 'open' : '' }}">
                        <button type="button" class="side-nav-group-toggle {{ $riwayatGroupActive ? 'active' : '' }}" aria-expanded="{{ $riwayatGroupActive ? 'true' : 'false' }}" aria-controls="seller-history-links">
                            <span class="side-nav-content">
                                <span class="side-nav-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
                                <span>Riwayat</span>
                            </span>
                            <i class="fa-solid fa-chevron-down side-nav-group-chevron" aria-hidden="true"></i>
                        </button>
                        <div class="side-nav-submenu" id="seller-history-links" {{ $riwayatGroupActive ? '' : 'hidden' }}>
                            <a class="side-nav-subitem {{ request()->routeIs('seller.riwayat', 'seller.riwayat.show') ? 'active' : '' }}" href="{{ route('seller.riwayat') }}" {{ request()->routeIs('seller.riwayat', 'seller.riwayat.show') ? 'aria-current=page' : '' }}>
                                <i class="fa-solid fa-file-invoice" aria-hidden="true"></i>
                                <span>Riwayat Pesanan</span>
                            </a>
                            <a class="side-nav-subitem {{ request()->routeIs('seller.riwayat.stok*') ? 'active' : '' }}" href="{{ route('seller.riwayat.stok.index') }}" {{ request()->routeIs('seller.riwayat.stok*') ? 'aria-current=page' : '' }}>
                                <i class="fa-solid fa-boxes-stacked" aria-hidden="true"></i>
                                <span>Riwayat Stok</span>
                            </a>
                        </div>
                    </div>
        
                        <a class="{{ request()->routeIs('seller.toko*') ? 'active' : '' }}" href="{{ route('seller.toko') }}">
                            <div class="side-nav-content">
                            <span class="side-nav-icon"><i class="fa-solid fa-store"></i></span>
                            <span>Profile Toko</span>
                            </div>
                        </a>
                </nav>
            </div>

            <div class="side-footer">
                <div class="store-status-card">
                    <div class="status-info">
                        <span class="status-dot-green"></span>
                        <div>
                            <div class="status-title">Status Toko</div>
                            <div class="status-state">Buka</div>
                        </div>
                    </div>
                    <label class="switch-toggle" title="Toko Sedang Buka">
                        <input type="checkbox" checked disabled>
                        <span class="slider-round"></span>
                    </label>
                </div>

                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-sidebar-logout">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="MainWrapper">
            <header class="topbar">
                <div class="topbar-left">
                    <span class="topbar-merchant-title">Mitra Merchant</span>
                    <span class="badge-store-open">
                        <span class="status-dot-green" style="width:7px; height:7px;"></span>
                        <span>Toko Sedang Buka</span>
                    </span>
                </div>

                <div class="topbar-right">
                    <button class="btn-notification" type="button" aria-label="Notifikasi">
                        <i class="fa-regular fa-bell"></i>
                        <span class="notification-dot"></span>
                    </button>
                    <div style="width:1px;height:32px;background:#DCE9FF;"></div>
                    <div class="user-profile-pill">
                        <div class="user-avatar-circle">
                            @if(auth()->user()?->toko?->gambar)
                                <img src="{{ asset('storage/' . auth()->user()->toko->gambar) }}" alt="Foto toko" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
                            @else
                                <i class="fa-solid fa-user-tie"></i>
                            @endif
                        </div>
                        <div class="user-meta-info">
                            <span class="user-store-name">
                                {{ auth()->user()?->toko?->nama_toko ?? 'Warung Makan Barokah' }}
                            </span>
                            <span class="user-role-tag">SELLER</span>
                        </div>
                    </div>
                </div>
            </header>

            <main class="MainContent @yield('main_class')">
                @if(session('ok'))
                    <div class="flash">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('ok') }}</span>
                    </div>
                @endif
                @if(session('success'))
                    <div class="flash">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(isset($errors) && $errors->any())
                    <div class="flash" style="background:#fef2f2; color:#b91c1c; border-color:#fecaca;">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    <script>
        document.querySelectorAll('.side-nav-group-toggle').forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                const expanded = toggle.getAttribute('aria-expanded') === 'true';
                const submenu = document.getElementById(toggle.getAttribute('aria-controls'));
                toggle.setAttribute('aria-expanded', String(!expanded));
                toggle.closest('.side-nav-group').classList.toggle('open', !expanded);
                submenu.hidden = expanded;
            });
        });
    </script>
</body>
</html>
