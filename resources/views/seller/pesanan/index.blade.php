@extends('layouts.sellerSidebar')

@section('title', 'Queue Pesanan')
@section('main_class', 'main-content-orange')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menuSeller.css') }}">
@endpush

@section('content')
<div class="seller-orange-container">

    <div class="dashboard-header-card">
        <h1 class="dashboard-header-title">Queue &amp; Antrian Pesanan</h1>
    </div>

    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-top"><span class="kpi-label">Menunggu Konfirmasi</span><span class="kpi-icon-circle kpi-icon-red"><i class="fa-solid fa-bell"></i></span></div>
            <div class="kpi-value-main kpi-value-red">{{ $countMenunggu ?? 0 }} Pesanan</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-top"><span class="kpi-label">Sedang Diproses</span><span class="kpi-icon-circle kpi-icon-blue"><i class="fa-solid fa-kitchen-set"></i></span></div>
            <div class="kpi-value-main">{{ $countDiproses ?? 0 }} Pesanan</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-top"><span class="kpi-label">Siap Diserahkan</span><span class="kpi-icon-circle kpi-icon-green"><i class="fa-solid fa-check"></i></span></div>
            <div class="kpi-value-main kpi-value-green">{{ $countSiap ?? 0 }} Pesanan</div>
        </div>
    </div>

    <div class="search-filter-card">
        <form method="get" action="{{ route('seller.pesanan') }}">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="search-bar-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input class="search-bar-input" id="search" name="search" type="search" value="{{ request('search') }}" placeholder="Cari kode pesanan atau nama pelanggan..." onchange="this.form.submit()">
            </div>
        </form>
        <div class="filter-pills-row">
            <a class="filter-pill {{ !request('status') ? 'active' : '' }}" href="{{ route('seller.pesanan') }}">Semua ({{ $countSemua ?? 0 }})</a>
            <a class="filter-pill {{ request('status') === 'menunggu konfirmasi' ? 'active' : '' }}" href="{{ route('seller.pesanan', ['status' => 'menunggu konfirmasi']) }}">Menunggu ({{ $countMenunggu ?? 0 }})</a>
            <a class="filter-pill {{ in_array(request('status'), ['diproses', 'diprosses']) ? 'active' : '' }}" href="{{ route('seller.pesanan', ['status' => 'diproses']) }}">Diproses ({{ $countDiproses ?? 0 }})</a>
            <a class="filter-pill {{ request('status') === 'siap diambil' ? 'active' : '' }}" href="{{ route('seller.pesanan', ['status' => 'siap diambil']) }}">Siap Diambil ({{ $countSiap ?? 0 }})</a>
        </div>
    </div>

    <div class="queue-section-card">
        <div class="queue-section-header">
            <div class="queue-title-block">
                <div class="queue-icon-badge"><i class="fa-solid fa-list-ol"></i></div>
                <h2 class="queue-title-text">Daftar Pesanan Aktif</h2>
            </div>
        </div>
        <div class="queue-table-container">
            <table class="queue-table">
                <thead>
                    <tr>
                        <th>Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Menu</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $item)
                        @php $status = strtolower($item->status); @endphp
                        <tr>
                            <td>
                                <div class="queue-order-id">{{ $item->kode_pesanan }}</div>
                                <div class="queue-customer-name">{{ $item->tipe_pesanan }} &bull; {{ $item->antrian?->nomor_antrian ? 'Antrian #' . $item->antrian->nomor_antrian : '-' }}</div>
                            </td>
                            <td>{{ $item->user->nama ?? '-' }}<div class="queue-customer-name">{{ $item->created_at->format('d M Y H:i') }}</div></td>
                            <td>
                                @foreach($item->detailPesanan as $detail)
                                    <div class="queue-item-name">{{ $detail->jumlah }}x {{ $detail->produk->nama_produk ?? 'Menu' }}</div>
                                @endforeach
                            </td>
                            <td><strong>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</strong></td>
                            <td>
                                @if($status === 'menunggu konfirmasi')
                                    <span class="status-pill-table status-pill-menunggu">Menunggu</span>
                                @elseif(in_array($status, ['diproses', 'diprosses']))
                                    <span class="status-pill-table status-pill-dimasak">Diproses</span>
                                @else
                                    <span class="status-pill-table status-pill-siap">Siap Diambil</span>
                                @endif
                            </td>
                            <td>
                                @if($status === 'menunggu konfirmasi')
                                    <form method="post" action="{{ route('seller.pesanan.updateStatus', $item) }}" style="display:inline">
                                        @csrf @method('PATCH') <input type="hidden" name="status" value="diprosses">
                                        <button class="btn-action-confirm" type="submit">Proses</button>
                                    </form>
                                    <form method="post" action="{{ route('seller.pesanan.updateStatus', $item) }}" style="display:inline" onsubmit="return confirm('Tolak pesanan ini?')">
                                        @csrf @method('PATCH') <input type="hidden" name="status" value="dibatalkan">
                                        <button class="btn-action-ready" type="submit">Tolak</button>
                                    </form>
                                @elseif(in_array($status, ['diproses', 'diprosses']))
                                    <form method="post" action="{{ route('seller.pesanan.updateStatus', $item) }}">
                                        @csrf @method('PATCH') <input type="hidden" name="status" value="siap diambil">
                                        <button class="btn-action-ready" type="submit">Siap Diambil</button>
                                    </form>
                                @else
                                    <form method="post" action="{{ route('seller.pesanan.updateStatus', $item) }}" onsubmit="return confirm('Selesaikan pesanan ini?')">
                                        @csrf @method('PATCH') <input type="hidden" name="status" value="selesai">
                                        <button class="btn-action-handover" type="submit"><i class="fa-solid fa-check"></i> Selesaikan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;padding:40px;color:#94a3b8">Tidak ada pesanan aktif.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pesanan->hasPages())
            <div style="margin-top:18px">{{ $pesanan->links() }}</div>
        @endif
    </div>

</div>
@endsection
