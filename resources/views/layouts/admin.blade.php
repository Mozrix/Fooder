<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Statistik' }} — FoodOrder Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #f97316;
            --primary-hover: #ea580c;
            --primary-light: #fff7ed;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --radius: 12px;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--bg-page);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
        }
        .layout {
            display: flex;
            min-height: 100vh;
        }
        .side {
            width: 250px;
            background: #ffffff;
            border-right: 1px solid var(--border-color);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            z-index: 10;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: 800;
            color: var(--primary);
            padding: 0 12px 24px 12px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }
        .nav {
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: var(--radius);
            text-decoration: none;
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.15s ease;
        }
        .nav a:hover {
            background: var(--primary-light);
            color: var(--primary);
        }
        .nav a.active {
            background: var(--primary);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.25);
        }
        .nav-icon {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }
        .side-footer {
            border-top: 1px solid var(--border-color);
            padding-top: 16px;
            margin-top: auto;
        }
        .main {
            margin-left: 250px;
            flex: 1;
            padding: 32px 40px;
            max-width: 1440px;
        }
        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }
        .top h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #0f172a;
        }
        .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }
        .user-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--primary);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
        }
        .card {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.02);
            margin-bottom: 24px;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 18px;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.05);
        }
        .stat small {
            display: block;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 500;
        }
        .stat strong {
            display: block;
            font-size: 26px;
            font-weight: 800;
            margin-top: 6px;
            color: #0f172a;
        }
        .grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 13.5px;
        }
        .table th {
            text-align: left;
            padding: 12px 14px;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-color);
            background: #f8fafc;
        }
        .table td {
            text-align: left;
            padding: 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }
        .table tr:last-child td {
            border-bottom: none;
        }
        .table tbody tr:hover td {
            background: #f8fafc;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 99px;
            font-size: 12px;
            line-height: 1;
        }
        .btn {
            background: var(--primary);
            color: #ffffff;
            border: 0;
            border-radius: 10px;
            padding: 9px 16px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .btn:hover {
            background: var(--primary-hover);
        }
        .btn-secondary {
            background: #f1f5f9;
            color: #334155;
        }
        .btn-secondary:hover {
            background: #e2e8f0;
        }
        .input {
            padding: 9px 13px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-family: inherit;
            font-size: 13.5px;
            color: var(--text-main);
            background: #ffffff;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        .input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);
        }
        .flash {
            padding: 14px 18px;
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-weight: 500;
            font-size: 14px;
        }
        .danger {
            color: #dc2626;
            background: #fee2e2;
            border: 0;
            cursor: pointer;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 8px;
            transition: background 0.15s ease;
        }
        .danger:hover {
            background: #fecaca;
        }
        @media(max-width: 900px) {
            .side {
                position: static;
                width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
            }
            .layout { flex-direction: column; }
            .main { margin-left: 0; padding: 20px; }
            .grid { grid-template-columns: 1fr; }
            .nav { flex-direction: row; overflow-x: auto; padding-bottom: 8px; }
            .nav a { white-space: nowrap; }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="side">
        <div class="brand">
            FoodOrder
        </div>
        <nav class="nav">
            @php
                $menus = [
                    'dashboard' => ['label' => 'Dashboard', 'icon' => ''],
                    'users' => ['label' => 'Pengguna', 'icon' => ''],
                    'categories' => ['label' => 'Kategori', 'icon' => ''],
                    'stores' => ['label' => 'Toko / Resto', 'icon' => ''],
                    'orders' => ['label' => 'Monitoring Pesanan', 'icon' => ''],
                    'payments' => ['label' => 'Monitoring Pembayaran', 'icon' => ''],
                ];
            @endphp
            @foreach($menus as $route => $item)
                <a class="{{ request()->routeIs('admin.'.$route.'*') ? 'active' : '' }}" href="{{ route('admin.'.$route) }}">
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

    <main class="main">
        <div class="top">
            <div>
                <h1>{{ $title ?? 'Statistik Admin' }}</h1>
            </div>
            <div class="user-pill">
                <span class="user-avatar">{{ substr(auth()->user()?->nama ?? 'A', 0, 1) }}</span>
                <span>{{ auth()->user()?->nama ?? 'Administrator' }}</span>
                <span class="badge" style="background:#fee2e2; color:#b91c1c; font-size:11px; font-weight:700;">ADMIN</span>
            </div>
        </div>

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
