@extends('layouts.sellerSidebar')

@section('title', 'Profil Toko')
@section('main_class', 'main-content-orange')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menuSeller.css') }}">
@endpush

@section('content')
<div class="seller-orange-container">

    <div class="dashboard-header-card">
        <h1 class="dashboard-header-title">Profil Toko</h1>
    </div>

    <div class="queue-section-card" style="max-width:760px">
        <form method="post" action="{{ route('seller.toko.edit', $toko) }}" enctype="multipart/form-data">
            @csrf
            @method('GET')

            <div style="display:flex;align-items:center;gap:18px;margin-bottom:24px">
                <div style="width:96px;height:96px;border-radius:12px;overflow:hidden;background:#f1f5f9;border:1px solid #e2e8f0">
                    @if($toko->gambar)
                        <img src="{{ asset('storage/' . $toko->gambar) }}" alt="{{ $toko->nama_toko }}" style="width:100%;height:100%;object-fit:cover">
                    @else
                        <div style="height:100%;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:28px">
                            <i class="fa-solid fa-store"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <label class="form-label-modal" for="gambar">Foto / Logo Toko</label>
                    <input class="form-input-modal" id="gambar" name="gambar" type="file" accept="image/jpeg,image/png,image/webp" disabled>
                    <div class="kpi-subtext">JPG, PNG, atau WEBP. Maksimal 2 MB.</div>
                </div>
            </div>

            <div class="form-row-2col">
                <div class="form-group-modal">
                    <label class="form-label-modal" for="nama_toko">Nama Toko</label>
                    <input class="form-input-modal" id="nama_toko" name="nama_toko" type="text" value="{{ old('nama_toko', $toko->nama_toko) }}" required maxlength="255" disabled>
                </div>

                <div class="form-group-modal">
                    <label class="form-label-modal" for="alamat">Lokasi / Alamat Toko</label>
                    <input class="form-input-modal" id="alamat" name="alamat" type="text" value="{{ old('alamat', $toko->alamat) }}" placeholder="Belum diatur" maxlength="255" disabled>
                </div>
            </div>

            <div class="form-group-modal">
                <label class="form-label-modal" for="deskripsi">Deskripsi</label>
                <textarea class="form-textarea-modal" id="deskripsi" name="deskripsi" rows="5" disabled>{{ old('deskripsi', $toko->deskripsi) }}</textarea>
            </div>

            <div class="form-row-2col">
                <div class="form-group-modal">
                    <label class="form-label-modal" for="jam_buka">Jam Buka</label>
                    <input class="form-input-modal" id="jam_buka" name="jam_buka" type="time" value="{{ old('jam_buka', $toko->jam_buka) }}" disabled>
                </div>
                <div class="form-group-modal">
                    <label class="form-label-modal" for="jam_tutup">Jam Tutup</label>
                    <input class="form-input-modal" id="jam_tutup" name="jam_tutup" type="time" value="{{ old('jam_tutup', $toko->jam_tutup) }}" disabled>
                </div>
            </div>

            <div class="product-modal-footer">
                <a href="{{ route('seller.dashboard') }}" class="btn-modal-cancel" style="text-decoration:none">Batal</a>
                <button type="submit" class="btn-modal-submit"><i class="fa-regular fa-pen-to-square" style="margin-right:8px"></i>Edit</button>
            </div>
        </form>
    </div>

</div>
@endsection