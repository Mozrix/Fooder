@extends('customer.layouts.app')

@section('title', $toko->nama_toko ?: 'Detail Toko')

@section('content')
    <nav class="market-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('customer.home') }}">Beranda</a>
        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        <span>{{ $toko->nama_toko }}</span>
    </nav>

    <section class="market-store-hero">
        <div class="market-store-cover">
            @if ($toko->gambar)
                <img src="{{ asset('storage/' . $toko->gambar) }}" alt="{{ $toko->nama_toko }}">
            @else
                <span class="market-media-placeholder"><i class="fa-solid fa-store"></i></span>
            @endif
        </div>
        <div class="market-store-profile">
            <span class="market-eyebrow"><i class="fa-solid fa-store"></i> Toko &amp; kantin Fooder</span>
            <h1>{{ $toko->nama_toko }}</h1>
            <p>{{ $toko->deskripsi ?: 'Lihat menu yang tersedia dari toko ini.' }}</p>
            <div class="market-store-meta">
                <span><i class="fa-solid fa-utensils"></i> {{ $toko->produk->count() }} menu tersedia</span>
                @if ($toko->jam_buka && $toko->jam_tutup)
                    <span><i class="fa-regular fa-clock"></i> {{ $toko->jam_buka }}–{{ $toko->jam_tutup }}</span>
                @endif
                <span><i class="fa-solid fa-location-dot"></i> {{ $toko->alamat ?: 'Lokasi belum dicantumkan' }}</span>
            </div>
        </div>
        <a class="market-button" href="#menu-toko">Lihat menu <i class="fa-solid fa-arrow-down"></i></a>
    </section>

    <section class="market-section" id="menu-toko">
        <div class="market-section-heading">
            <div>
                <span class="market-section-kicker">Menu dari {{ $toko->nama_toko }}</span>
                <h2>Pilih hidanganmu</h2>
            </div>
            <span class="market-count">{{ $toko->produk->count() }} menu</span>
        </div>

        @if ($toko->produk->isEmpty())
            <div class="market-empty">
                <span><i class="fa-solid fa-bowl-food"></i></span>
                <h3>Belum ada menu tersedia</h3>
                <p>Toko ini belum memiliki menu yang dapat dipesan.</p>
            </div>
        @else
            <div class="market-products">
                @foreach ($toko->produk as $item)
                    <article class="market-product-card">
                        <a class="market-product-media" href="{{ route('customer.menu.show', $item->id) }}">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_produk }}" loading="lazy">
                            @else
                                <span class="market-media-placeholder"><i class="fa-solid fa-bowl-food"></i></span>
                            @endif
                        </a>
                        <div class="market-product-info">
                            <span class="market-product-store">{{ $item->kategori?->nama_kategori ?? 'Menu' }}</span>
                            <h3><a href="{{ route('customer.menu.show', $item->id) }}">{{ $item->nama_produk }}</a></h3>
                            @if ($item->deskripsi)
                                <p class="market-product-description">{{ $item->deskripsi }}</p>
                            @endif
                            <div class="market-product-bottom">
                                <div>
                                    <strong class="market-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</strong>
                                    <span class="market-stock">Stok {{ $item->stok }}</span>
                                </div>
                                <form action="{{ route('customer.keranjang.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button class="market-button market-button-small" type="submit"><i class="fa-solid fa-plus"></i> Tambah</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection
