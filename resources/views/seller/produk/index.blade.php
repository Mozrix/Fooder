@extends('layouts.sellerSidebar')

@section('title', 'Katalog Produk & Menu')
@section('main_class', 'main-content-orange')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menuSeller.css') }}">
@endpush

@section('content')
<div class="seller-orange-container">

    <div class="catalog-header">
        <h1 class="stock-page-title">Katalog Produk & Menu</h1>
        <button type="button" class="btn-add-product" onclick="openAddProductModal()">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Produk Baru</span>
        </button>
    </div>

    <div class="kpi-grid">
        <div class="kpi-card">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="kpi-label">TOTAL MENU</div>
                    <div class="kpi-value-main">{{ $totalMenu ?? 0 }} Hidangan</div>
                </div>
                <div class="kpi-icon-circle kpi-icon-orange">
                    <i class="fa-solid fa-utensils"></i>
                </div>
            </div>
        </div>

        <div class="kpi-card">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="kpi-label">AKTIF</div>
                    <div class="kpi-value-main kpi-value-green">{{ $aktifMenu ?? 0 }} Menu</div>
                </div>
                <div class="kpi-icon-circle kpi-icon-green">
                    <i class="fa-regular fa-eye"></i>
                </div>
            </div>
        </div>

        <div class="kpi-card">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="kpi-label">STOK HABIS</div>
                    <div class="kpi-value-main kpi-value-red">{{ $habisMenu ?? 0 }} Menu</div>
                </div>
                <div class="kpi-icon-circle kpi-icon-red">
                    <i class="fa-regular fa-eye-slash"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="search-filter-card">
        <form method="get" action="{{ route('seller.produk') }}">
            @if(request('tipe'))
                <input type="hidden" name="tipe" value="{{ request('tipe') }}">
            @endif
            @if(request('kategori_id'))
                <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">
            @endif

            <div class="search-bar-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama hidangan, deskripsi, atau rasa..."
                       class="search-bar-input"
                       onchange="this.form.submit()">
                @if(request('search'))
                    <a href="{{ route('seller.produk', request()->except('search')) }}" style="color: #94a3b8; text-decoration: none;">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>
        </form>

        <div class="filter-pills-row">
            <a href="{{ route('seller.produk') }}" class="filter-pill {{ !request('tipe') && !request('status') ? 'active' : '' }}">
                Semua ({{ $totalMenu ?? 0 }})
            </a>
            <a href="{{ route('seller.produk', array_merge(request()->except('page'), ['tipe' => 'makanan berat'])) }}"
               class="filter-pill {{ request('tipe') === 'makanan berat' ? 'active' : '' }}">
                Makanan Utama
            </a>
            <a href="{{ route('seller.produk', array_merge(request()->except('page'), ['tipe' => 'minuman'])) }}"
               class="filter-pill {{ request('tipe') === 'minuman' ? 'active' : '' }}">
                Minuman Segar
            </a>
            <a href="{{ route('seller.produk', array_merge(request()->except('page'), ['tipe' => 'makanan ringan'])) }}"
               class="filter-pill {{ request('tipe') === 'makanan ringan' ? 'active' : '' }}">
                Camilan & Ekstra
            </a>
        </div>
    </div>

    <div class="stock-table-card">
        <div class="queue-table-container">
            <table class="queue-table product-table">
                <thead>
                    <tr>
                        <th>PRODUK</th>
                        <th>KATEGORI</th>
                        <th>HARGA</th>
                        <th>STOK</th>
                        <th>STATUS</th>
                        <th style="width: 150px; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produk as $item)
                        <tr>
                            <td>
                                <div class="stock-product-cell">
                                    <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : '' }}" alt="{{ $item->nama_produk }}" class="stock-thumb-img">
                                    <div class="stock-product-info product-table-info">
                                        <span class="stock-product-name">{{ $item->nama_produk }}</span>
                                        <span class="stock-product-tipe">{{ $item->deskripsi ?: 'Tidak ada deskripsi produk.' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-category-pill">{{ $item->kategori->nama_kategori ?? '-' }}</span>
                                <div class="queue-customer-name">{{ ucfirst($item->tipe) }}</div>
                            </td>
                            <td><strong class="price-text-orange">Rp {{ number_format($item->harga, 0, ',', '.') }}</strong></td>
                            <td><strong>{{ $item->stok }}</strong> porsi</td>
                            <td>
                                @if($item->in_stock && $item->stok > 0)
                                    <span class="badge-stock-tersedia">Tersedia</span>
                                @else
                                    <span class="badge-stock-habis">Habis</span>
                                @endif
                            </td>
                            <td>
                                <div class="product-table-actions">
                                    <a href="{{ route('seller.produk.edit', $item->id) }}" class="btn-edit-pill" aria-label="Edit {{ $item->nama_produk }}">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        <span>Edit</span>
                                    </a>
                                    <form method="post" action="{{ route('seller.produk.destroy', $item->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-icon" title="Hapus Produk" aria-label="Hapus {{ $item->nama_produk }}">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="stock-empty-state">
                                    <i class="fa-solid fa-utensils"></i>
                                    <strong>Tidak ada produk ditemukan</strong>
                                    <span>Belum ada produk yang sesuai dengan pencarian atau filter yang dipilih.</span>
                                    <button type="button" class="btn-add-product" onclick="openAddProductModal()">
                                        <i class="fa-solid fa-plus"></i> Tambah Produk
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="figma-pagination-footer product-pagination-footer">
            <div>
                Menampilkan <strong>{{ $produk->count() > 0 ? $produk->firstItem() : 0 }} - {{ $produk->count() > 0 ? $produk->lastItem() : 0 }}</strong> dari <strong>{{ $produk->total() }}</strong> data produk
            </div>
            <div class="figma-pagination-controls">
                @if($produk->count() > 0 && $produk->hasPages())
                    @if($produk->onFirstPage())
                        <span class="figma-page-btn disabled" aria-disabled="true">&lt;</span>
                    @else
                        <a href="{{ $produk->previousPageUrl() }}" class="figma-page-btn" aria-label="Halaman sebelumnya">&lt;</a>
                    @endif

                    @foreach($produk->getUrlRange(1, $produk->lastPage()) as $page => $url)
                        @if($page == $produk->currentPage())
                            <span class="figma-page-btn active" aria-current="page">{{ $page }}</span>
                        @elseif($page <= 3 || $page == $produk->lastPage() || abs($page - $produk->currentPage()) <= 1)
                            <a href="{{ $url }}" class="figma-page-btn" aria-label="Halaman {{ $page }}">{{ $page }}</a>
                        @elseif($page == 4 && $produk->currentPage() > 3)
                            <span class="figma-page-ellipsis">...</span>
                        @endif
                    @endforeach

                    @if($produk->hasMorePages())
                        <a href="{{ $produk->nextPageUrl() }}" class="figma-page-btn" aria-label="Halaman berikutnya">&gt;</a>
                    @else
                        <span class="figma-page-btn disabled" aria-disabled="true">&gt;</span>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div id="modalAddProduct" class="product-modal-backdrop">
        <div class="product-modal-card">
            <div class="product-modal-header">
                <h3 class="product-modal-title">Tambah Produk Baru</h3>
                <button type="button" class="product-modal-close" onclick="closeAddProductModal()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form method="post" action="{{ route('seller.produk.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group-modal">
                    <label class="form-label-modal" for="nama_produk">Nama Hidangan / Produk</label>
                    <input type="text" id="nama_produk" name="nama_produk" class="form-input-modal"
                           placeholder="Contoh: Ayam Geprek Sambal Bawang" required value="{{ old('nama_produk') }}">
                </div>

                <div class="form-row-2col">
                    <div class="form-group-modal">
                        <label class="form-label-modal" for="kategori_id">Kategori Menu</label>
                        <select id="kategori_id" name="kategori_id" class="form-select-modal" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat->id }}" @selected(old('kategori_id') == $kat->id)>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group-modal">
                        <label class="form-label-modal" for="tipe">Tipe Produk</label>
                        <select id="tipe" name="tipe" class="form-select-modal" required>
                            <option value="makanan berat" @selected(old('tipe') === 'makanan berat')>Makanan Utama (Berat)</option>
                            <option value="makanan ringan" @selected(old('tipe') === 'makanan ringan')>Camilan / Makanan Ringan</option>
                            <option value="minuman" @selected(old('tipe') === 'minuman')>Minuman</option>
                        </select>
                    </div>
                </div>

                <div class="form-row-2col">
                    <div class="form-group-modal">
                        <label class="form-label-modal" for="harga">Harga (Rp)</label>
                        <input type="number" id="harga" name="harga" class="form-input-modal"
                               placeholder="25000" min="0" step="1" required value="{{ old('harga') }}">
                    </div>

                    <div class="form-group-modal">
                        <label class="form-label-modal" for="stok">Stok Awal (Porsi)</label>
                        <input type="number" id="stok" name="stok" class="form-input-modal"
                               placeholder="20" min="0" step="1" required value="{{ old('stok', 10) }}">
                    </div>
                </div>

                <div class="form-group-modal">
                    <label class="form-label-modal" for="deskripsi">Deskripsi Hidangan</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-textarea-modal" rows="3"
                              placeholder="Tuliskan rasa, racikan rempah, dan keistimewaan menu ini...">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="form-group-modal">
                    <label class="form-label-modal" for="gambar">Gambar Produk</label>
                    <input id="gambar" name="gambar" type="file" accept="image/jpeg,image/png,image/webp" class="form-input-modal">
                    <div class="kpi-subtext">JPG, PNG, atau WEBP. Maksimal 2 MB.</div>
                </div>

                <div class="product-modal-footer">
                    <button type="button" class="btn-modal-cancel" onclick="closeAddProductModal()">Batal</button>
                    <button type="submit" class="btn-modal-submit">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function openAddProductModal() {
        const modal = document.getElementById('modalAddProduct');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                const input = document.getElementById('nama_produk');
                if (input) input.focus();
            }, 100);
        }
    }

    function closeAddProductModal() {
        const modal = document.getElementById('modalAddProduct');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    window.addEventListener('click', function(e) {
        const modal = document.getElementById('modalAddProduct');
        if (e.target === modal) {
            closeAddProductModal();
        }
    });

    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAddProductModal();
        }
    });
</script>
@endpush
