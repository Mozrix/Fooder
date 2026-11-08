@extends('layouts.sellerSidebar')

@section('title', 'Ubah Informasi Toko')

@section('content')
    <h1>Ubah Informasi Toko</h1>

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

    <form method="post" action="{{ route('seller.toko.update', $toko) }}">
        @csrf
        @method('PUT')

        <p>
            <label for="nama_toko">Nama toko</label><br>
            <input id="nama_toko" name="nama_toko" type="text" value="{{ old('nama_toko', $toko->nama_toko) }}" required maxlength="255">
        </p>

        <p>
            <label for="deskripsi">Deskripsi</label><br>
            <textarea id="deskripsi" name="deskripsi" rows="5">{{ old('deskripsi', $toko->deskripsi) }}</textarea>
        </p>

        <p>
            <label for="jam_buka">Jam buka</label><br>
            <input id="jam_buka" name="jam_buka" type="time" value="{{ old('jam_buka', $toko->jam_buka) }}">
        </p>

        <p>
            <label for="jam_tutup">Jam tutup</label><br>
            <input id="jam_tutup" name="jam_tutup" type="time" value="{{ old('jam_tutup', $toko->jam_tutup) }}">
        </p>

        <button type="submit">Simpan perubahan</button>
        <a href="{{ route('seller.dashboard') }}">Batal</a>
    </form>
@endsection