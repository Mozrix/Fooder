@extends('layouts.sellerSidebar')

@section('title', 'Stok')

@section('content')
    <style>
        [data-row] .ubah { display: none; }

        [data-row][data-mode="restock"] .ubah,
        [data-row][data-mode="koreksi"] .ubah { display: inline; }

        [data-row][data-mode="restock"] .lihat,
        [data-row][data-mode="koreksi"] .lihat { display: none; }
    </style>
    <script>
        const judul = {
        '': 'Stok saat ini',
        restock: 'Tambah stok',
        koreksi: 'Koreksi stok',
        };

        function perbaruiJudul() {
            const th = document.querySelector('[data-th-stok]');
            if (!th) return;   // jika penanda tidak ditemukan, jangan error

            const aktif = document.querySelector(
                '[data-row][data-mode="restock"], [data-row][data-mode="koreksi"]'
            );
            th.textContent = judul[aktif ? aktif.dataset.mode : ''];
        }

        function tutupBaris(baris) {
            baris.dataset.mode = '';
            baris.querySelector('[data-jumlah]').value = '';
            baris.querySelector('[data-keterangan]').value = '';
            baris.querySelector('[data-jenis]').value = '';
        }

        document.addEventListener('click', function (e) {
            const baris = e.target.closest('[data-row]');
            if (!baris) return;

            const tombolMode  = e.target.closest('[data-mode-btn]');
            const tombolBatal = e.target.closest('[data-batal]');

            const jumlah     = baris.querySelector('[data-jumlah]');
            const keterangan = baris.querySelector('[data-keterangan]');
            const jenis      = baris.querySelector('[data-jenis]');

            if (tombolMode) {
                document.querySelectorAll('[data-row]').forEach(function (r) {
                    if (r !== baris) tutupBaris(r);
                });

                const mode = tombolMode.dataset.modeBtn;   // "restock" atau "koreksi"
                baris.dataset.mode = mode;
                jenis.value = mode;

                if (mode === 'restock') {
                    keterangan.value = 'Restock';
                    keterangan.readOnly = true;
                } else {
                    keterangan.value = '';
                    keterangan.readOnly = false;
                }

                jumlah.focus();
            }

            if (tombolBatal) {
                tutupBaris(baris);
            }

            perbaruiJudul();
        });
        perbaruiJudul();
    </script>
    <h1>Stok Produk</h1>

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

    <form method="get" action="{{ route('seller.produk.stok') }}">
        <label for="search">Cari produk</label>
        <input id="search" name="search" type="search" value="{{ request('search') }}">
        <button type="submit">Cari</button>
        @if (request()->filled('search'))
            <a href="{{ route('seller.produk.stok') }}">Hapus pencarian</a>
        @endif
    </form>

    @if ($produk->count())
        <table>
            <thead>
                <tr>
                    <th>Nama produk</th>
                    <th>Tipe</th>
                    <th data-th-stok>Stok saat ini</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk as $item)
                    @php
                        $formId = 'form-stok-'.$item->id;
                        $mode = (string) old('produk_id') === (string) $item->id ? old('jenis') : '';
                    @endphp

                    <tr data-row data-mode="{{ $mode }}">
                        <td>{{ $item->nama_produk }}</td>
                        <td>{{ ucfirst($item->tipe) }}</td>
                        <td>
                            <span class="lihat">{{ $item->stok }}</span>

                            <span class="ubah">
                                <input type="number" name="jumlah" min="0" step="1" required
                                    form="{{ $formId }}" data-jumlah
                                    aria-label="Jumlah untuk {{ $item->nama_produk }}"
                                    value="{{ $mode ? old('jumlah') : '' }}">
                                <small>(sekarang: {{ $item->stok }})</small>
                            </span>
                        </td>
                        <td>
                            <span class="lihat">-</span>

                            <span class="ubah">
                                <input type="text" name="keterangan" maxlength="255"
                                    form="{{ $formId }}" data-keterangan
                                    aria-label="Keterangan untuk {{ $item->nama_produk }}"
                                    value="{{ $mode === 'restock' ? 'Restock' : ($mode === 'koreksi' ? old('keterangan') : '') }}"
                                    @readonly($mode === 'restock')>
                            </span>
                        </td>
                        <td>
                            <span class="lihat">
                                <button type="button" data-mode-btn="restock">Restock</button>
                                <button type="button" data-mode-btn="koreksi">Koreksi</button>
                            </span>

                            <form id="{{ $formId }}" method="post"
                                action="{{ route('seller.stok.update', $item->id) }}" class="ubah">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                <input type="hidden" name="jenis" value="{{ $mode }}" data-jenis>

                                <button type="submit">Simpan</button>
                                <button type="button" data-batal>Batal</button>
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