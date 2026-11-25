@extends('layouts.sellerSidebar')

@section('title', 'Ubah Produk')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menuSeller.css') }}">
@endpush

@section('content')
    <div class="catalog-header"><h1 class="catalog-title">Ubah Produk</h1></div>
    <div class="queue-section-card" style="max-width:760px">
    <form method="post" action="{{ route('seller.produk.update', $produk->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display:flex;align-items:center;gap:18px;margin-bottom:20px">
            <img src="{{ asset('storage/' . $produk->gambar) }}"
                 alt="{{ $produk->nama_produk }}" style="width:92px;height:92px;border-radius:12px;object-fit:cover;border:1px solid #e2e8f0">
            <div>
                <label class="form-label-modal" for="gambar">Gambar Produk</label>
                <input class="form-input-modal" id="gambar" name="gambar" type="file" accept="image/jpeg,image/png,image/webp">
            </div>
        </div>

        <div class="form-row-2col">
            <div class="form-group-modal">
                <label class="form-label-modal" for="nama_produk">Nama Produk</label>
                <input class="form-input-modal" id="nama_produk" name="nama_produk" type="text" maxlength="255" required value="{{ old('nama_produk', $produk->nama_produk) }}">
            </div>
            <div class="form-group-modal">
                <label class="form-label-modal" for="kategori_id">Kategori</label>
                <select class="form-select-modal" id="kategori_id" name="kategori_id" required>
                    @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori->id }}" @selected(old('kategori_id', $produk->kategori_id) == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row-2col">
            <div class="form-group-modal">
            <label class="form-label-modal" for="tipe">Tipe Produk</label>
            <select class="form-select-modal" id="tipe" name="tipe" required>
                @foreach (['makanan berat', 'makanan ringan', 'minuman'] as $tipe)
                    <option value="{{ $tipe }}" @selected(old('tipe', $produk->tipe) === $tipe)>{{ ucfirst($tipe) }}</option>
                @endforeach
            </select>
            </div>
            <div class="form-group-modal">
                <label class="form-label-modal" for="harga">Harga</label>
                <input class="form-input-modal" id="harga" name="harga" type="number" min="0" step="1" required value="{{ old('harga', $produk->harga) }}">
            </div>
        </div>

        <div class="form-group-modal">
            <label class="form-label-modal" for="deskripsi">Deskripsi</label>
            <textarea class="form-textarea-modal" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
        </div>

        <div class="product-modal-footer">
            <a href="{{ route('seller.produk') }}" class="btn-modal-cancel" style="text-decoration:none">Batal</a>
            <button type="submit" class="btn-modal-submit">Simpan Perubahan</button>
        </div>
    </form>
    </div>
@endsection