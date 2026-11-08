@extends('layouts.sellerSidebar')

@section('title', 'Ubah Produk')

@section('content')
    <h1>Ubah Produk</h1>

    @if ($errors->any())
        <div role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('seller.produk.update', $produk->id) }}">
        @csrf
        @method('PUT')

        <p>
            <label for="nama_produk">Nama produk</label><br>
            <input id="nama_produk" name="nama_produk" type="text" maxlength="255" required
                   value="{{ old('nama_produk', $produk->nama_produk) }}">
        </p>

        <p>
            <label for="kategori_id">Kategori</label><br>
            <input id="kategori_id" name="kategori_id" type="number" min="1" required
                   value="{{ old('kategori_id', $produk->kategori_id) }}">
        </p>

        <p>
            <label for="tipe">Tipe produk</label><br>
            <select id="tipe" name="tipe" required>
                @foreach (['makanan berat', 'makanan ringan', 'minuman'] as $tipe)
                    <option value="{{ $tipe }}"
                        @selected(old('tipe', $produk->tipe) === $tipe)>
                        {{ ucfirst($tipe) }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="harga">Harga</label><br>
            <input id="harga" name="harga" type="number" min="0" step="0.01" required
                   value="{{ old('harga', $produk->harga) }}">
        </p>

        <p>
            <label for="deskripsi">Deskripsi</label><br>
            <textarea id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
        </p>

        <button type="submit">Simpan perubahan</button>
        <a href="{{ route('seller.produk') }}">Batal</a>
    </form>
@endsection