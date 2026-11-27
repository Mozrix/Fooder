@extends('customer.layouts.app')

@section('title', 'Beranda')

@section('content')
    @php($highlight = $produk->first())

    <section class="market-hero">
        <div class="market-hero-copy">
            <span class="market-eyebrow"><i class="fa-solid fa-location-dot"></i> Kuliner pilihan, dekat denganmu</span>
            <h1>Temukan makanan favoritmu hari ini.</h1>
            <p>Jelajahi menu dari toko dan kantin pilihan, lalu pesan dengan praktis.</p>
            <a class="market-button market-button-light" href="{{ route('customer.menu.index') }}">
                Jelajahi menu <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="market-hero-art" aria-hidden="true">
            @if ($highlight?->gambar)
                <img src="{{ asset('storage/' . $highlight->gambar) }}" alt="">
            @else
                <span class="market-hero-plate"><i class="fa-solid fa-bowl-food"></i></span>
            @endif
            <div class="market-hero-note">
                <span>Mulai dari</span>
                <strong>{{ $highlight ? 'Rp ' . number_format($highlight->harga, 0, ',', '.') : 'menu pilihan' }}</strong>
                @if ($highlight)
                    <small>{{ $highlight->nama_produk }}</small>
                @endif
            </div>
        </div>
        <div class="market-hero-spark market-hero-spark-one" aria-hidden="true">✦</div>
        <div class="market-hero-spark market-hero-spark-two" aria-hidden="true">✦</div>
    </section>

    @if ($kategori->isNotEmpty())
        <section class="market-category-section" aria-label="Kategori menu">
            <a class="market-category-chip" href="{{ route('customer.menu.index') }}">
                <i class="fa-solid fa-border-all"></i> Semua menu
            </a>
            @foreach ($kategori as $itemKategori)
                <a class="market-category-chip" href="{{ route('customer.menu.index', ['kategori' => $itemKategori->id]) }}">
                    <i class="fa-solid fa-utensils"></i>
                    {{ $itemKategori->nama_kategori }}
                </a>
            @endforeach
        </section>
    @endif

    <section class="market-section">
        <div class="market-section-heading">
            <div>
                <span class="market-section-kicker">Dari dapur pilihan</span>
                <h2>Menu yang mungkin kamu suka</h2>
            </div>
            <a class="market-text-link" href="{{ route('customer.menu.index') }}">Lihat semua <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        @if ($produk->isEmpty())
            <div class="market-empty">
                <span><i class="fa-solid fa-bowl-food"></i></span>
                <h3>Menu sedang disiapkan</h3>
                <p>Belum ada menu yang tersedia. Coba kunjungi lagi nanti.</p>
            </div>
        @else
            <div class="market-products">
                @foreach ($produk as $item)
                    <article class="market-product-card">
                        <a class="market-product-media" href="{{ route('customer.menu.show', $item->id) }}">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_produk }}" loading="lazy">
                            @else
                                <span class="market-media-placeholder"><i class="fa-solid fa-bowl-food"></i></span>
                            @endif
                        </a>
                        <div class="market-product-info">
                            <a class="market-product-store" href="{{ route('customer.toko.show', $item->toko_id) }}">{{ $item->toko?->nama_toko ?? 'Toko Fooder' }}</a>
                            <h3><a href="{{ route('customer.menu.show', $item->id) }}">{{ $item->nama_produk }}</a></h3>
                            <div class="market-product-meta">
                                <span>{{ $item->kategori?->nama_kategori ?? 'Menu' }}</span>
                                <span>Stok {{ $item->stok }}</span>
                            </div>
                            <div class="market-product-bottom">
                                <strong class="market-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</strong>
                                <form action="{{ route('customer.keranjang.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button class="market-add-button" type="submit" aria-label="Tambah {{ $item->nama_produk }} ke keranjang">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <section class="market-section" id="toko">
        <div class="market-section-heading">
            <div>
                <span class="market-section-kicker">Kenali tempatnya</span>
                <h2>Toko &amp; kantin pilihan</h2>
            </div>
            <a class="market-text-link" href="{{ route('customer.menu.index') }}">Jelajahi menu <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        @if ($toko->isEmpty())
            <div class="market-empty">
                <span><i class="fa-solid fa-store"></i></span>
                <h3>Belum ada toko tersedia</h3>
                <p>Toko akan muncul di sini saat sudah memiliki menu yang tersedia.</p>
            </div>
        @else
            <div class="market-store-list">
                @foreach ($toko as $store)
                    <article class="market-store-card">
                        <a class="market-store-image" href="{{ route('customer.toko.show', $store->id) }}">
                            @if ($store->gambar)
                                <img src="{{ asset('storage/' . $store->gambar) }}" alt="{{ $store->nama_toko }}" loading="lazy">
                            @else
                                <span class="market-media-placeholder"><i class="fa-solid fa-store"></i></span>
                            @endif
                        </a>
                        <div class="market-store-info">
                            <span class="market-section-kicker">Toko &amp; kantin</span>
                            <h3><a href="{{ route('customer.toko.show', $store->id) }}">{{ $store->nama_toko }}</a></h3>
                            <p>{{ $store->deskripsi ?: 'Temukan menu pilihan dari toko ini.' }}</p>
                            <span class="market-store-meta">
                                <i class="fa-solid fa-utensils"></i>
                                {{ $store->produk->count() }} menu tersedia
                                @if ($store->jam_buka && $store->jam_tutup)
                                    <span aria-hidden="true">·</span> {{ $store->jam_buka }}–{{ $store->jam_tutup }}
                                @endif
                            </span>
                        </div>
                        <div class="market-store-preview">
                            @foreach ($store->produk->take(3) as $preview)
                                <a href="{{ route('customer.menu.show', $preview->id) }}" title="{{ $preview->nama_produk }}">
                                    @if ($preview->gambar)
                                        <img src="{{ asset('storage/' . $preview->gambar) }}" alt="{{ $preview->nama_produk }}" loading="lazy">
                                    @else
                                        <span class="market-media-placeholder"><i class="fa-solid fa-bowl-food"></i></span>
                                    @endif
                                    <span>{{ $preview->nama_produk }}</span>
                                </a>
                            @endforeach
                        </div>
                        <a class="market-button market-button-outline" href="{{ route('customer.toko.show', $store->id) }}">
                            Lihat toko <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection
