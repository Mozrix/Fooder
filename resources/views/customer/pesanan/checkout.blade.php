@extends('customer.layouts.app')

@section('title', 'Keranjang')

@section('content')
    <nav class="market-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('customer.home') }}">Beranda</a>
        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        <span>Keranjang</span>
    </nav>

    <section class="market-page-heading market-cart-heading">
        <div>
            <span class="market-section-kicker">Tinjau sebelum memesan</span>
            <h1>Keranjang belanja</h1>
            <p>Pastikan menu dan jumlah pesananmu sudah sesuai.</p>
        </div>
        <a class="market-button market-button-outline" href="{{ route('customer.menu.index') }}">
            <i class="fa-solid fa-plus"></i> Tambah menu
        </a>
    </section>

    @if (empty($items))
        <div class="market-empty market-cart-empty">
            <span><i class="fa-solid fa-bag-shopping"></i></span>
            <h2>Keranjangmu masih kosong</h2>
            <p>Jelajahi menu dan tambahkan hidangan favoritmu ke keranjang.</p>
            <a class="market-button" href="{{ route('customer.menu.index') }}">Jelajahi menu</a>
        </div>
    @else
        <div class="market-cart-layout">
            <div class="market-cart-main">
                @if ($toko)
                    <section class="market-cart-store">
                        <span class="market-cart-store-icon"><i class="fa-solid fa-store"></i></span>
                        <div>
                            <span class="market-section-kicker">Pesanan dari</span>
                            <h2>{{ $toko->nama_toko }}</h2>
                            @if ($toko->jam_buka && $toko->jam_tutup)
                                <span>{{ $toko->jam_buka }}–{{ $toko->jam_tutup }}</span>
                            @endif
                        </div>
                        <a class="market-text-link" href="{{ route('customer.toko.show', $toko->id) }}">Tambah menu lain <i class="fa-solid fa-arrow-right"></i></a>
                    </section>
                @else
                    <div class="market-error" role="alert">Toko untuk keranjang ini tidak tersedia. Hapus menu yang tidak tersedia sebelum melanjutkan.</div>
                @endif

                <section class="market-cart-items" aria-label="Item keranjang">
                    @foreach ($items as $item)
                        <article class="market-cart-item">
                            <div class="market-cart-item-image">
                                @if ($item['gambar'])
                                    <img src="{{ asset('storage/' . $item['gambar']) }}" alt="{{ $item['nama_produk'] }}">
                                @else
                                    <span class="market-media-placeholder"><i class="fa-solid fa-bowl-food"></i></span>
                                @endif
                            </div>
                            <div class="market-cart-item-info">
                                <h3>{{ $item['nama_produk'] }}</h3>
                                @if (!$item['tersedia'])
                                    <span class="market-unavailable">Stok berubah atau menu tidak tersedia</span>
                                @endif
                                <span class="market-cart-unit-price">Rp {{ number_format($item['harga_satuan'], 0, ',', '.') }} / item</span>
                                <strong class="market-price">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</strong>
                            </div>
                            <div class="market-cart-item-actions">
                                @if ($item['tersedia'])
                                    <form class="market-quantity-form" action="{{ route('customer.keranjang.update', $item['produk_id']) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <label class="sr-only" for="jumlah-{{ $item['produk_id'] }}">Jumlah {{ $item['nama_produk'] }}</label>
                                        <input class="market-quantity-input" type="number" id="jumlah-{{ $item['produk_id'] }}" name="jumlah" min="1" value="{{ $item['jumlah'] }}" required>
                                        <button class="market-button market-button-small" type="submit">Perbarui</button>
                                    </form>
                                @else
                                    <span class="market-quantity-label">Jumlah: {{ $item['jumlah'] }}</span>
                                @endif
                                <form action="{{ route('customer.keranjang.remove', $item['produk_id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="market-remove-button" type="submit"><i class="fa-regular fa-trash-can"></i> Hapus</button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </section>

                @if (!$cartHasUnavailable && $toko)
                    <form id="place-order" action="{{ route('customer.pesanan.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="toko_id" value="{{ $tokoId }}">
                        <input type="hidden" name="tipe_pesanan" value="online">
                        @foreach ($items as $item)
                            <input type="hidden" name="items[{{ $item['produk_id'] }}][produk_id]" value="{{ $item['produk_id'] }}">
                            <input type="hidden" name="items[{{ $item['produk_id'] }}][jumlah]" value="{{ $item['jumlah'] }}">
                        @endforeach
                    </form>
                @endif
            </div>

            <aside class="market-cart-summary">
                <h2>Ringkasan pesanan</h2>
                <div class="market-summary-row">
                    <span>Subtotal ({{ count($items) }} menu)</span>
                    <strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong>
                </div>
                <div class="market-summary-row market-summary-total">
                    <span>Total pembayaran</span>
                    <strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong>
                </div>
                @if (!$cartHasUnavailable && $toko)
                    @auth
                        <button class="market-button market-order-button" type="submit" form="place-order">
                            Buat pesanan <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    @else
                        <a class="market-button market-order-button" href="{{ route('login') }}">
                            Masuk untuk memesan <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    @endauth
                @else
                    <button class="market-button market-order-button" type="button" disabled>
                        Periksa keranjang untuk melanjutkan
                    </button>
                @endif
                <p class="market-summary-note"><i class="fa-solid fa-shield-halved"></i> Harga dihitung kembali saat pesanan dibuat.</p>
            </aside>
        </div>
    @endif
@endsection
