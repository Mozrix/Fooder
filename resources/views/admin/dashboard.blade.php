@extends('layouts.admin')

@section('content')
<form method="get" style="display:flex; gap:10px; align-items:end; margin-bottom:18px; flex-wrap:wrap;">
    <label style="font-size:12px; color:var(--m);">Dari<input class="input" type="date" name="from" value="{{ $from }}" style="display:block; margin:4px 0 0;"></label>
    <label style="font-size:12px; color:var(--m);">Sampai<input class="input" type="date" name="to" value="{{ $to }}" style="display:block; margin:4px 0 0;"></label>
    <button class="btn" type="submit">Terapkan</button>
    @if($from || $to)<a href="{{ route('admin.dashboard') }}" style="color:var(--m); font-size:13px;">Reset</a>@endif
</form>
<div class="grid" style="margin-bottom:24px;">
    @php
        $cards = [
            ['title' => 'Total Pengguna', 'value' => $users, 'color' => '#3b82f6', 'route' => 'admin.users'],
            ['title' => 'Toko Aktif', 'value' => $stores, 'color' => '#10b981', 'route' => 'admin.stores'],
            ['title' => 'Kategori Menu', 'value' => $categories, 'color' => '#8b5cf6', 'route' => 'admin.categories'],
            ['title' => 'Total Produk', 'value' => $products, 'color' => '#f59e0b', 'route' => 'admin.products'],
            ['title' => 'Pesanan Masuk', 'value' => $orders, 'color' => '#ec4899', 'route' => 'admin.orders'],
            ['title' => 'Pembayaran Lunas', 'value' => $paid, 'color' => '#06b6d4', 'route' => 'admin.payments'],
        ];
    @endphp

    <div class="card">
        <h3 style="margin:0 0 18px; font-size:16px;">Ringkasan Data</h3>
        @php $max = max(1, max(array_column($cards, 'value'))); @endphp
        @foreach($cards as $c)
            <div style="margin-bottom:13px;">
                <div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:5px;">
                    <span>{{ $c['title'] }}</span><strong>{{ number_format($c['value']) }}</strong>
                </div>
                <div style="height:9px; background:#eef2f7; border-radius:99px; overflow:hidden;">
                    <div style="height:100%; width:{{ ($c['value'] / $max) * 100 }}%; background:{{ $c['color'] }}; border-radius:99px;"></div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="card">
        <h3 style="margin:0 0 18px; font-size:16px;">Status Pesanan</h3>
        @php $maxOrders = max(1, $orderStats->max() ?? 0); @endphp
        @forelse($orderStats as $status => $total)
            <div style="margin-bottom:13px;">
                <div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:5px;"><span style="text-transform:capitalize;">{{ $status }}</span><strong>{{ $total }}</strong></div>
                <div style="height:9px; background:#eef2f7; border-radius:99px; overflow:hidden;"><div style="height:100%; width:{{ ($total / $maxOrders) * 100 }}%; background:#ec4899; border-radius:99px;"></div></div>
            </div>
        @empty
            <p style="color:var(--m); font-size:13px;">Belum ada data pesanan.</p>
        @endforelse
        <h3 style="margin:22px 0 14px; font-size:16px;">Status Pembayaran</h3>
        @php $maxPayments = max(1, $paymentStats->max() ?? 0); @endphp
        @forelse($paymentStats as $status => $total)
            <div style="margin-bottom:10px;"><div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:5px;"><span>{{ $status }}</span><strong>{{ $total }}</strong></div><div style="height:8px; background:#eef2f7; border-radius:99px; overflow:hidden;"><div style="height:100%; width:{{ ($total / $maxPayments) * 100 }}%; background:#06b6d4; border-radius:99px;"></div></div></div>
        @empty
            <p style="color:var(--m); font-size:13px;">Belum ada data pembayaran.</p>
        @endforelse
    </div>
</div>

<div class="grid">
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 style="margin:0; font-size:16px; font-weight:700;">Pesanan Terbaru</h3>
            <a href="{{ route('admin.orders') }}" style="font-size:13px; color:var(--primary); text-decoration:none; font-weight:600;">Semua Pesanan →</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Customer</th>
                    <th>Toko</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent as $o)
                    <tr>
                        <td><code style="background:#f1f5f9; padding:3px 7px; border-radius:6px; font-weight:600;">{{ $o->kode_pesanan }}</code></td>
                        <td>{{ $o->user->nama ?? '-' }}</td>
                        <td>{{ $o->toko->nama_toko ?? '-' }}</td>
                        <td style="font-weight:700; color:var(--primary);">Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $statusColors = [
                                    'selesai' => 'background:#dcfce7; color:#15803d',
                                    'diproses' => 'background:#fef3c7; color:#b45309',
                                    'menunggu' => 'background:#f1f5f9; color:#475569',
                                    'dibatalkan' => 'background:#fee2e2; color:#b91c1c'
                                ];
                                $color = $statusColors[strtolower($o->status)] ?? 'background:#edf4ff; color:#1e40af';
                            @endphp
                            <span class="badge" style="{{ $color }}; font-weight:600; text-transform:capitalize;">
                                {{ $o->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:30px; color:var(--text-muted);">
                            Belum ada pesanan yang masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3 style="margin:0 0 16px 0; font-size:16px; font-weight:700;">Aksi Cepat</h3>
        <div style="display:flex; flex-direction:column; gap:10px;">
            <a href="{{ route('admin.users.create') }}" class="btn" style="justify-content:center;">
                + Tambah Pengguna Baru
            </a>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-secondary" style="justify-content:center;">
                + Tambah Kategori Menu
            </a>
            <a href="{{ route('admin.stores') }}" class="btn btn-secondary" style="justify-content:center;">
                Kelola Toko & Restoran
            </a>
            <a href="{{ route('admin.payments') }}" class="btn btn-secondary" style="justify-content:center;">
                Pantau Pembayaran
            </a>
        </div>

        <div style="margin-top:24px; padding-top:16px; border-top:1px solid var(--border-color);">
            <div style="font-size:12px; color:var(--text-muted); line-height:1.6;">
            </div>
        </div>
    </div>
</div>
@endsection
