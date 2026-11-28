@extends('customer.layouts.app')

@section('title', 'Pembayaran QRIS')

@section('content')
    <nav class="market-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('customer.home') }}">Beranda</a>
        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        <a href="{{ route('customer.pesanan.index') }}">Pesanan</a>
        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        <span>Pembayaran QRIS</span>
    </nav>

    <section class="market-page-heading">
        <div>
            <span class="market-section-kicker">Simulasi Pembayaran</span>
            <h1>Pembayaran QRIS</h1>
            <p>Selesaikan simulasi pembayaran agar pesanan segera diteruskan ke <strong>{{ $pesanan->toko->nama_toko ?? 'Penjual' }}</strong>.</p>
        </div>
    </section>

    <div class="cust-card qris-card">
        <div class="qris-header">
            <span class="cust-badge cust-badge-amber">Menunggu Pembayaran (Pending)</span>
            <h2 class="qris-store-title">{{ $pesanan->toko->nama_toko ?? 'Fooder Merchant' }}</h2>
            <p class="qris-order-code">Kode Pesanan: <strong>{{ $pesanan->kode_pesanan }}</strong></p>
        </div>

        <div class="qris-body">
            <p class="qris-label">QRIS SIMULASI</p>

            <div class="qris-box">
                <svg width="190" height="190" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg" shape-rendering="crispEdges" aria-label="QR Code Simulasi">
                    <rect width="21" height="21" fill="#ffffff"/>
                    <path fill="#111827" d="M0,0h7v7h-7zM1,1v5h5v-5zM2,2h3v3h-3z M14,0h7v7h-7zM15,1v5h5v-5zM16,2h3v3h-3z M0,14h7v7h-7zM1,15v5h5v-5zM2,16h3v3h-3z"/>
                    <path fill="#111827" d="M8,1h2v1h-2zM11,1h2v2h-2zM9,3h1v2h-1zM12,4h1v2h-1zM8,6h3v1h-3zM1,8h2v1h-2zM4,8h3v2h-3zM9,8h2v2h-2zM13,8h2v1h-2zM17,8h3v1h-3zM2,10h2v2h-2zM6,11h3v1h-3zM11,10h2v3h-2zM15,10h2v2h-2zM19,10h1v3h-1zM8,13h2v2h-2zM13,14h2v2h-2zM16,14h3v1h-3zM9,16h2v2h-2zM12,17h2v3h-2zM15,16h2v2h-2zM18,17h3v3h-3zM8,19h3v1h-3z"/>
                </svg>
            </div>

            <div class="qris-total-wrap">
                <span class="qris-total-label">Total Tagihan</span>
                <strong class="cust-price qris-total-amount">
                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                </strong>
            </div>
        </div>

        <div class="qris-items-box">
            <strong>Rincian Menu:</strong>
            <ul class="qris-items-list">
                @foreach ($pesanan->detailPesanan as $detail)
                    <li>{{ $detail->produk->nama_produk ?? '-' }} ({{ $detail->jumlah }}x) — Rp {{ number_format($detail->total_harga, 0, ',', '.') }}</li>
                @endforeach
            </ul>
        </div>

        <div class="qris-actions">
            <form action="{{ route('customer.pesanan.bayar', $pesanan->id) }}" method="POST" class="qris-action-form">
                @csrf
                <button type="submit" class="market-button qris-btn-full">
                    <i class="fa-solid fa-check"></i> Bayar
                </button>
            </form>

            <form action="{{ route('customer.pesanan.batalkan', $pesanan->id) }}" method="POST" class="qris-action-form" onsubmit="return confirm('Batalkan pembayaran QRIS dan batalkan pesanan ini?');">
                @csrf
                <button type="submit" class="market-button market-button-outline qris-btn-full qris-btn-cancel">
                    <i class="fa-solid fa-xmark"></i> Batalkan
                </button>
            </form>
        </div>
    </div>
@endsection