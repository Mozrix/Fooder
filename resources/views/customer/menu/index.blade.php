@extends('customer.layouts.app')

@section('title', 'Menu Pilihan')

@section('content')
    <section class="market-page-heading">
        <div>
            <span class="market-section-kicker">Dari toko dan kantin</span>
            <h1>Temukan menu favoritmu</h1>
            <p>Cari hidangan yang kamu inginkan dan lihat menu lain dari tokonya.</p>
        </div>
    </section>

    @if ($kategori->isNotEmpty())
        <nav class="market-filter-list" aria-label="Filter kategori">
            <a class="{{ request('kategori') ? '' : 'active' }}" href="{{ route('customer.menu.index', array_filter(['q' => request('q')])) }}">Semua</a>
            @foreach ($kategori as $itemKategori)
                <a class="{{ (string) request('kategori') === (string) $itemKategori->id ? 'active' : '' }}"
                   href="{{ route('customer.menu.index', array_filter(['q' => request('q'), 'kategori' => $itemKategori->id])) }}">
                    {{ $itemKategori->nama_kategori }}
                </a>
            @endforeach
        </nav>
    @endif

    @if ($produk->isEmpty())
        <div class="market-empty">
            <span><i class="fa-solid fa-magnifying-glass"></i></span>
            <h3>Menu tidak ditemukan</h3>
            <p>Coba kata kunci atau kategori lain.</p>
            <a class="market-button" href="{{ route('customer.menu.index') }}">Tampilkan semua menu</a>
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
                        @if ($item->deskripsi)
                            <p class="market-product-description">{{ $item->deskripsi }}</p>
                        @endif
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
                                <button class="market-button market-button-small" type="submit"><i class="fa-solid fa-plus"></i> Keranjang</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="market-pagination">{{ $produk->links() }}</div>
    @endif
@endsection
