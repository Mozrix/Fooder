@extends('layouts.admin')

@section('content')
@php($isUser = ($type === 'users'))
<div class="card" style="max-width: 600px;">
    <h2 style="margin-top:0; margin-bottom:20px; font-size:18px;">
        {{ $item->exists ? 'Edit '.$title : 'Tambah '.$title }}
    </h2>

    <form method="post" action="{{ $item->exists ? route('admin.'.$type.'.update', $item) : route('admin.'.$type.'.store') }}">
        @csrf
        @if($item->exists)
            @method('PUT')
        @endif

        @if($isUser)
            <div style="margin-bottom:14px;">
                <label style="font-weight:600; display:block; margin-bottom:6px;">Nama Lengkap</label>
                <input class="input" style="width:100%; box-sizing:border-box;" name="nama" value="{{ old('nama', $item->nama) }}" placeholder="Masukkan nama" required>
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-weight:600; display:block; margin-bottom:6px;">Alamat Email</label>
                <input class="input" style="width:100%; box-sizing:border-box;" name="email" type="email" value="{{ old('email', $item->email) }}" placeholder="email@domain.com" required>
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-weight:600; display:block; margin-bottom:6px;">
                    Password {!! $item->exists ? '<small style="color:var(--m); font-weight:normal;">(Kosongkan jika tidak ingin mengubah password)</small>' : '' !!}
                </label>
                <input class="input" style="width:100%; box-sizing:border-box;" name="password" type="password" placeholder="Minimal 8 karakter" {{ $item->exists ? '' : 'required' }}>
            </div>

            <div style="margin-bottom:20px;">
                <label style="font-weight:600; display:block; margin-bottom:6px;">Role Pengguna</label>
                <select class="input" style="width:100%; box-sizing:border-box;" name="role" required>
                    <option value="admin" {{ old('role', $item->role) === 'admin' ? 'selected' : '' }}>Admin (Pengelola Sistem)</option>
                    <option value="seller" {{ old('role', $item->role) === 'seller' ? 'selected' : '' }}>Seller (Pemilik Toko)</option>
                    <option value="customer" {{ old('role', $item->role) === 'customer' ? 'selected' : '' }}>Customer (Pembeli)</option>
                </select>
            </div>
        @else
            <div style="margin-bottom:20px;">
                <label style="font-weight:600; display:block; margin-bottom:6px;">Nama Kategori</label>
                <input class="input" style="width:100%; box-sizing:border-box;" name="nama_kategori" value="{{ old('nama_kategori', $item->nama_kategori) }}" placeholder="Contoh: Minuman, Makanan Berat, Snack" required>
            </div>
        @endif

        <div style="display:flex; gap:10px;">
            <button class="btn" type="submit">Simpan Data</button>
            <a href="{{ route('admin.'.$type) }}" class="btn" style="background:#f1f5f9; color:#475569;">Batal</a>
        </div>
    </form>
</div>
@endsection
