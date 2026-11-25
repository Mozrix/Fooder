@extends('layouts.sellerSidebar')

@section('title', 'Riwayat Stok')
@section('main_class', 'main-content-orange')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menuSeller.css') }}">
@endpush

@section('content')
<div class="seller-orange-container stock-history-container">
    <div class="stock-page-header">
        <div class="stock-header-left">
            <h1 class="stock-page-title">Riwayat Stok</h1>
        </div>
        <div class="stock-header-actions">
            <a href="{{ route('seller.stok') }}" class="btn-action-stock-edit">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke stok
            </a>
        </div>
    </div>

    @isset($produk)
        <div class="stock-history-product-card">
            <img src="{{ $produk->gambar ? asset('storage/' . $produk->gambar) : '' }}" alt="{{ $produk->nama_produk }}" class="stock-thumb-img">
            <div class="stock-product-info">
                <span class="stock-product-name">{{ $produk->nama_produk }}</span>
                <span class="stock-product-tipe">Stok saat ini: <strong>{{ $produk->stok }} porsi</strong></span>
            </div>
        </div>
    @endisset

    <div class="stock-history-table-card">
        <div class="stock-history-table-heading">
            <div>
                <h2>Catatan Perubahan</h2>
                <p>{{ $riwayatStok->total() }} catatan tersimpan</p>
            </div>
        </div>
        <div class="queue-table-container">
            <table class="queue-table stock-history-table">
                <thead>
                    <tr>
                        @unless(isset($produk))
                            <th>PRODUK</th>
                        @endunless
                        <th>WAKTU</th>
                        <th>JENIS</th>
                        <th>STOK SEBELUM</th>
                        <th>PERUBAHAN</th>
                        <th>STOK SETELAH</th>
                        <th>KETERANGAN</th>
                        <th>DIUBAH OLEH</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatStok as $item)
                        <tr>
                            @unless(isset($produk))
                                <td>
                                    <a class="stock-history-product-link" href="{{ route('seller.riwayat.stok', $item->produk_id) }}">{{ $item->produk->nama_produk ?? 'Produk dihapus' }}</a>
                                </td>
                            @endunless
                            <td>
                                <div class="queue-order-id">{{ $item->created_at->format('d M Y') }}</div>
                                <div class="queue-customer-name">{{ $item->created_at->format('H:i') }}</div>
                            </td>
                            <td>
                                <span class="stock-history-type {{ $item->tipe === 'otomatis' ? 'stock-history-type-auto' : 'stock-history-type-manual' }}">
                                    {{ ucfirst($item->tipe) }}
                                </span>
                            </td>
                            <td>{{ $item->jumlah_sebelum }} porsi</td>
                            <td class="{{ $item->jumlah_perubahan >= 0 ? 'stock-history-change-positive' : 'stock-history-change-negative' }}">
                                {{ $item->jumlah_perubahan > 0 ? '+' : '' }}{{ $item->jumlah_perubahan }} porsi
                            </td>
                            <td><strong>{{ $item->jumlah_setelah }} porsi</strong></td>
                            <td>{{ $item->keterangan ?: '-' }}</td>
                            <td>{{ $item->user->nama ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ isset($produk) ? 7 : 8 }}">
                                <div class="stock-empty-state">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                    <strong>Belum ada riwayat stok</strong>
                                    <span>{{ isset($produk) ? 'Perubahan stok untuk produk ini akan muncul di sini.' : 'Perubahan stok produk akan muncul di sini.' }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="figma-pagination-footer stock-pagination-footer">
            <div>
                Menampilkan <strong>{{ $riwayatStok->count() > 0 ? $riwayatStok->firstItem() : 0 }} - {{ $riwayatStok->count() > 0 ? $riwayatStok->lastItem() : 0 }}</strong> dari <strong>{{ $riwayatStok->total() }}</strong> data perubahan stok
            </div>
            <div class="figma-pagination-controls">
                @if($riwayatStok->count() > 0 && $riwayatStok->hasPages())
                    @if($riwayatStok->onFirstPage())
                        <span class="figma-page-btn disabled" aria-disabled="true">&lt;</span>
                    @else
                        <a href="{{ $riwayatStok->previousPageUrl() }}" class="figma-page-btn" aria-label="Halaman sebelumnya">&lt;</a>
                    @endif

                    @foreach($riwayatStok->getUrlRange(1, $riwayatStok->lastPage()) as $page => $url)
                        @if($page == $riwayatStok->currentPage())
                            <span class="figma-page-btn active" aria-current="page">{{ $page }}</span>
                        @elseif($page <= 3 || $page == $riwayatStok->lastPage() || abs($page - $riwayatStok->currentPage()) <= 1)
                            <a href="{{ $url }}" class="figma-page-btn" aria-label="Halaman {{ $page }}">{{ $page }}</a>
                        @elseif($page == 4 && $riwayatStok->currentPage() > 3)
                            <span class="figma-page-ellipsis">...</span>
                        @endif
                    @endforeach

                    @if($riwayatStok->hasMorePages())
                        <a href="{{ $riwayatStok->nextPageUrl() }}" class="figma-page-btn" aria-label="Halaman berikutnya">&gt;</a>
                    @else
                        <span class="figma-page-btn disabled" aria-disabled="true">&gt;</span>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
