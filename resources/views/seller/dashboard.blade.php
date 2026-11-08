@extends('layouts.sellerSidebar')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard Seller</h1>
    <p>Kelola toko dan produk Anda melalui menu berikut.</p>

    <ul>
        <li><a href="{{ route('seller.produk') }}">Kelola produk</a></li>
        <li><a href="{{ route('seller.toko') }}">Ubah informasi toko</a></li>
    </ul>
@endsection