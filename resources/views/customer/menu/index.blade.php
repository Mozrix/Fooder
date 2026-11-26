@extends('customer.layouts.app')

@section('title', '')

@section('content')
    <div class="cust-header-card">
        <span class="cust-header-icon"><i class="fa-solid fa-utensils"></i></span>
        <h2 class="cust-header-title">Daftar Menu</h2>
        <div class="cust-header-identity">
            {{ auth()->user()?->name ?? '' }}
        </div>
    </div>

    @if ($produk->isEmpty())
        <div class="cust-card">
            <p class="cust-muted">Belum ada menu yang tersedia.</p>
        </div>
    @else
        <div class="cust-menu-grid">
            @foreach ($produk as $p)
                <div class="cust-card cust-product-card{{ $p->gambar ? ' has-image' : '' }}">
                    @if ($p->gambar)
                        <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama_produk }}" class="cust-product-image">
                    @endif
                    <div class="cust-product-body">
                        <h2>{{ $p->nama_produk }}</h2>
                        @if ($p->deskripsi)
                            <p class="cust-muted">{{ $p->deskripsi }}</p>
                        @endif
                        <div class="cust-product-footer">
                            <div>
                                <p class="cust-price">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                                <p class="cust-muted">Stok: {{ $p->stok }}</p>
                            </div>
                            <div class="cust-product-action">
                                @if ($p->toko?->nama_toko)
                                    <span class="cust-muted">{{ $p->toko->nama_toko }}</span>
                                @endif
                                @if (isset($p->kategori) && $p->kategori?->nama_kategori)
                                    <span class="cust-muted">{{ $p->kategori->nama_kategori }}</span>
                                @endif
                                <form action="{{ route('customer.pesanan.checkout') }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $p->id }}">
                                    <label for="jumlah_{{ $p->id }}" class="cust-label-inline">Jumlah:</label>
                                    <input type="number" class="cust-input" id="jumlah_{{ $p->id }}" name="jumlah" min="1" value="1" aria-label="Jumlah {{ $p->nama_produk }}">
                                    <button type="submit" class="cust-btn cust-btn-sm">Pilih</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
