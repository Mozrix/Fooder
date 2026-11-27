@extends('customer.layouts.app')

@section('title', $produk->nama_produk)

@section('content')
    <nav class="market-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('customer.home') }}">Beranda</a>
        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        <a href="{{ route('customer.toko.show', $produk->toko_id) }}">{{ $produk->toko?->nama_toko ?? 'Toko' }}</a>
        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        <span>{{ $produk->nama_produk }}</span>
    </nav>

    <article class="market-detail-card">
        <div class="market-detail-media">
            @if ($produk->gambar)
                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}">
            @else
                <span class="market-media-placeholder"><i class="fa-solid fa-bowl-food"></i></span>
            @endif
            <div class="market-detail-highlights">
                <span><i class="fa-solid fa-store"></i> {{ $produk->toko?->nama_toko ?? 'Toko Fooder' }}</span>
                <span><i class="fa-solid fa-box"></i> Stok {{ $produk->stok }}</span>
            </div>
        </div>
        <div class="market-detail-info">
            <a class="market-product-store" href="{{ route('customer.toko.show', $produk->toko_id) }}">
                <i class="fa-solid fa-store"></i> {{ $produk->toko?->nama_toko ?? 'Toko Fooder' }}
            </a>
            <h1>{{ $produk->nama_produk }}</h1>
            @if ($produk->kategori)
                <span class="market-detail-category">{{ $produk->kategori->nama_kategori }}</span>
            @endif
            <strong class="market-detail-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong>
            <p class="market-detail-description">{{ $produk->deskripsi ?: 'Menu pilihan yang disiapkan oleh toko.' }}</p>

            <form class="market-detail-form" action="{{ route('customer.keranjang.add') }}" method="POST">
                @csrf
                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                <label for="jumlah">Jumlah pesanan</label>
                <div class="market-detail-order">
                    <input class="market-quantity-input" type="number" id="jumlah" name="jumlah" min="1" max="{{ $produk->stok }}" value="1" required>
                    <button class="market-button" type="submit"><i class="fa-solid fa-bag-shopping"></i> Tambah ke keranjang</button>
                </div>
            </form>
            <a class="market-text-link market-back-link" href="{{ route('customer.toko.show', $produk->toko_id) }}">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke toko
            </a>
        </div>
    </article>
@endsection
