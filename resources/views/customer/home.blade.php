@extends('customer.layouts.app')

@section('title', '')

@php
    $riwayat = collect();
    if (auth()->check()) {
        $riwayat = auth()->user()->pesanan()
            ->with(['detailPesanan.produk.toko'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();
    }
@endphp

@section('content')
    @auth
        <div class="cust-card">
            <p class="cust-muted">Selamat datang, {{ Auth::user()->name }}!</p>
        </div>
    @endauth

    <div class="cust-histori">
        <div class="cust-histori-title-row">
            <span class="cust-histori-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
            <h2 class="cust-histori-title">Riwayat Pesanan</h2>
        </div>

        <div class="cust-card">
            @if ($riwayat->isEmpty())
                <div class="cust-histori-empty">
                    <span class="cust-empty-icon"><i class="fa-solid fa-file-invoice"></i></span>
                    <p>Belum ada riwayat pesanan</p>
                </div>
            @else
                <div class="cust-histori-list">
                    @foreach ($riwayat as $rp)
                        @php
                            $badge = match (true) {
                                in_array((string) $rp->status, ['menunggu konfirmasi', 'menunggu'], true) => 'red',
                                in_array((string) $rp->status, ['diproses', 'diprosses', 'sedang diproses'], true) => 'blue',
                                in_array((string) $rp->status, ['siap diambil', 'selesai'], true) => 'green',
                                in_array((string) $rp->status, ['dibatalkan', 'ditolak', 'ditolak_toko'], true) => 'gray',
                                default => 'amber',
                            };
                            $tokoName = $rp->detailPesanan->first()?->produk?->toko?->nama_toko ?? $rp->toko?->nama_toko ?? '-';
                            $produkList = $rp->detailPesanan->pluck('produk.nama_produk')->filter()->take(3);
                        @endphp
                        <div class="cust-histori-item">
                            <div class="cust-histori-item-head">
                                <div class="cust-histori-item-name">{{ $rp->kode_pesanan }}</div>
                                <div class="cust-histori-item-meta">{{ $rp->created_at->format('d M Y, H:i') }} · {{ $tokoName }}</div>
                                @if ($produkList->isNotEmpty())
                                    <div class="cust-histori-item-meta">{{ $produkList->implode(', ') }}</div>
                                @endif
                            </div>
                            <div class="cust-histori-item-toko">
                                Rp {{ number_format($rp->total_harga, 0, ',', '.') }}
                                <span class="cust-badge cust-badge-{{ $badge }}">{{ $rp->status }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
