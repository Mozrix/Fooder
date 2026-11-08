@extends('layouts.sellerSidebar')

@section('title', 'Informasi Toko')

@section('content')
    <h1>Informasi Toko</h1>

    @if (session('success'))
        <p role="status">{{ session('success') }}</p>
    @endif

    <dl>
        <dt>Nama toko</dt>
        <dd>{{ $toko->nama_toko }}</dd>

        <dt>Deskripsi</dt>
        <dd>{{ $toko->deskripsi ?: '-' }}</dd>

        <dt>Jam buka</dt>
        <dd>{{ $toko->jam_buka ?: '-' }}</dd>

        <dt>Jam tutup</dt>
        <dd>{{ $toko->jam_tutup ?: '-' }}</dd>
    </dl>

    <a href="{{ route('seller.settings.toko.edit') }}">Ubah informasi toko</a>
@endsection
