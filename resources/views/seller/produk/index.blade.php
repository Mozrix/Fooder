@extends('layouts.sellerSidebar')

@section('title', 'Produk')

@section('content')
    <h1>Produk Toko</h1>

    @if (session('success'))
        <p role="status">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div role="alert">
            <p>Periksa kembali data yang dimasukkan:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="get" action="{{ route('seller.produk') }}">
        <label for="search">Cari produk</label>
        <input id="search" name="search" type="search" value="{{ request('search') }}">
        <button type="submit">Cari</button>
        @if (request()->filled('search'))
            <a href="{{ route('seller.produk') }}">Hapus pencarian</a>
        @endif
    </form>

    <details>
        <summary>Tambah produk</summary>
        <form method="post" action="{{ url('/seller/products') }}">
            @csrf
            @method('POST')

            <p>
                <label for="nama_produk">Nama produk</label><br>
                <input id="nama_produk" name="nama_produk" type="text" value="{{ old('nama_produk') }}" required maxlength="255">
            </p>

            <p>
                <label for="kategori_id">ID kategori</label><br>
                <input id="kategori_id" name="kategori_id" type="number" min="1" value="{{ old('kategori_id') }}" required>
            </p>

            <p>
                <label for="tipe">Tipe produk</label><br>
                <select id="tipe" name="tipe" required>
                    <option value="">Pilih tipe produk</option>
                    @foreach (['makanan berat', 'makanan ringan', 'minuman'] as $tipe)
                        <option value="{{ $tipe }}" @selected(old('tipe') === $tipe)>{{ ucfirst($tipe) }}</option>
                    @endforeach
                </select>
            </p>

            <p>
                <label for="harga">Harga</label><br>
                <input id="harga" name="harga" type="number" min="0" step="0.01" value="{{ old('harga') }}" required>
            </p>

            <p>
                <label for="stok">Stok awal</label><br>
                <input id="stok" name="stok" type="number" min="0" step="1" value="{{ old('stok', 0) }}" required>
            </p>

            <p>
                <label for="deskripsi">Deskripsi</label><br>
                <textarea id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
            </p>

            <button type="submit">Simpan produk</button>
        </form>
    </details>

    @if ($produk->count())
        <table>
            <thead>
                <tr>
                    <th>Nama produk</th>
                    <th>Kategori</th>
                    <th>Tipe</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk as $item)
                    <tr>
                        <td>{{ $item->nama_produk }}</td>
                        <td>{{ $item->kategori?->nama_kategori ?? '-' }}</td>
                        <td>{{ ucfirst($item->tipe) }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('seller.produk.edit', $item->id) }}">Ubah</a>
                            <form method="post" action="{{ route('seller.produk.destroy', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $produk->links() }}
    @else
        <p>Belum ada produk yang cocok.</p>
    @endif
@endsection