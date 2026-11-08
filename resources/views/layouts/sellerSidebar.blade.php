<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> </title>
</head>
<body>
    <div class="Layout">
        <aside class="Sidebar">
            <div class="brand">
                Fooder
            </div>
            <nav class="side-nav">
                <?php
                $menuItems = [
                    ['label' => 'Dashboard',        'icon' => '', 'route' => 'seller.dashboard',          'pattern' => 'seller.dashboard'],
                    ['label' => 'Produk',           'icon' => '', 'route' => 'seller.produk',       'pattern' => 'seller.produk.*'],
                    ['label' => 'Stok Produk',      'icon' => '', 'route' => 'seller.stok',           'pattern' => 'seller.stok.*'],
                    ['label' => 'Profil Toko',      'icon' => '', 'route' => 'seller.toko.edit',          'pattern' => 'seller.toko.*'],
                ];
                ?>
                @foreach($menuItems as $item)
                    <a class="{{ request()->routeIs($item['pattern']) ? 'active' : '' }}" href="{{ route($item['route']) }}">
                        @if($item['icon'])<span class="nav-icon">{{ $item['icon'] }}</span>@endif
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>
            <div class="side-footer">
            <form method="post" action="{{ route('logout') }}">
                @csrf
                <button class="danger" style="width:100%; text-align:center;">Keluar</button>
            </form>
            </div>
        </aside>
        <main class="MainContent">
            @if(session('ok'))
                <div class="flash">{{ session('ok') }}</div>
            @endif
            @if($errors->any())
                <div class="flash" style="background:#fef2f2; color:#b91c1c; border-color:#fecaca;">{{ $errors->first() }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>