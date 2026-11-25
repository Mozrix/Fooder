@extends('layouts.sellerSidebar')

@section('title', 'Manajemen Stok Harian')
@section('main_class', 'main-content-orange')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menuSeller.css') }}">
@endpush

@section('content')
<div class="seller-orange-container">

        <div class="catalog-header">
            <h1 class="stock-page-title">Manajemen Stok Harian</h1>
            <button type="button" class="btn-add-product" onclick="window.location.href='{{ route('seller.riwayat.stok.index') }}'">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span>Riwayat Stok</span>
            </button>
         </div>

    <div class="kpi-grid">
        <div class="kpi-card">
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div class="kpi-label">Total Menu Terdaftar</div>
                    <div class="kpi-value-main">{{ $totalMenu ?? 0 }}</div>
                    <div class="kpi-subtext">Aktif di etalase toko</div>
                </div>
                <div class="kpi-icon-circle kpi-icon-orange">
                    <i class="fa-solid fa-utensils"></i>
                </div>
            </div>
        </div>

        <div class="kpi-card">
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div class="kpi-label">Stok Aman</div>
                    <div class="kpi-value-main kpi-value-green">{{ $stokAman ?? 0 }}</div>
                    <div class="kpi-subtext">Kesiapan order optimal (&ge; 5)</div>
                </div>
                <div class="kpi-icon-circle kpi-icon-green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>

        <div class="kpi-card">
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div class="kpi-label">Menipis / Habis</div>
                    <div class="kpi-value-main kpi-value-red">{{ $stokMenipis ?? 0 }}</div>
                    <div class="kpi-subtext">Segera isi ulang porsi</div>
                </div>
                <div class="kpi-icon-circle kpi-icon-red">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="search-filter-card">
        <form method="get" action="{{ route('seller.stok') }}" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
            <div class="search-bar-wrap" style="flex:1;min-width:220px;">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama produk..."
                       class="search-bar-input"
                       onchange="this.form.submit()">
            </div>
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>

        <div class="filter-pills-row" style="margin-top:14px;">
            <a href="{{ route('seller.stok', request()->except(['status','page'])) }}"
               class="filter-pill {{ !request('status') ? 'active' : '' }}">
                Semua ({{ $totalMenu ?? 0 }})
            </a>
            <a href="{{ route('seller.stok', array_merge(request()->except('page'), ['status' => 'tersedia'])) }}"
               class="filter-pill {{ request('status') === 'tersedia' ? 'active' : '' }}">
                Tersedia ({{ $stokTersedia ?? 0 }})
            </a>
            <a href="{{ route('seller.stok', array_merge(request()->except('page'), ['status' => 'hampir_habis'])) }}"
               class="filter-pill {{ request('status') === 'hampir_habis' ? 'active' : '' }}">
                Hampir Habis &lt; 5 ({{ $stokHampirHabis ?? 0 }})
            </a>
            <a href="{{ route('seller.stok', array_merge(request()->except('page'), ['status' => 'habis'])) }}"
               class="filter-pill {{ request('status') === 'habis' ? 'active' : '' }}">
                Habis ({{ $stokHabis ?? 0 }})
            </a>
        </div>
    </div>

    <div class="stock-table-card">
        @if($produk->count())
            <table class="stock-table">
                <thead>
                    <tr>
                        <th style="width:40%;">NAMA PRODUK</th>
                        <th style="width:12%;">STATUS</th>
                        <th style="width:20%;">STOK</th>
                        <th style="width:28%; text-align:right;">TOMBOL AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produk as $item)
                        @php
                            $stok   = (int) $item->stok;
                            $formId = 'form-stok-' . $item->id;
                        @endphp

                        <tr class="stock-table-row {{ $stok <= 0 ? 'row-habis' : '' }}"
                            id="row-{{ $item->id }}">
                            <td>
                                <div class="stock-product-cell">
                                    <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : '' }}" alt="{{ $item->nama_produk }}" class="stock-thumb-img }}"
                                         alt="{{ $item->nama_produk }}"
                                         class="stock-thumb-img">
                                    <div class="stock-product-info">
                                        <span class="stock-product-name {{ $stok <= 0 ? 'text-muted-striked' : '' }}">
                                            {{ $item->nama_produk }}
                                        </span>
                                        <span class="stock-product-tipe">{{ ucfirst($item->tipe ?? '-') }}</span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                @if($stok >= 5)
                                    <span class="badge-stock-tersedia">
                                        <span style="width:6px;height:6px;border-radius:50%;background:#16a34a;display:inline-block;"></span>
                                        Tersedia
                                    </span>
                                @elseif($stok > 0)
                                    <span class="badge-stock-menipis">
                                        <span style="width:6px;height:6px;border-radius:50%;background:#ea580c;display:inline-block;"></span>
                                        Menipis
                                    </span>
                                @else
                                    <span class="badge-stock-habis">
                                        <span style="width:6px;height:6px;border-radius:50%;background:#dc2626;display:inline-block;"></span>
                                        Habis
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="stock-view" id="stock-view-{{ $item->id }}">
                                    <strong>{{ $stok }}</strong>
                                    <span class="stock-porsi-label" style="margin-left:4px;">Porsi</span>
                                </div>
                                <div class="stock-editor" id="stock-editor-{{ $item->id }}" style="display:none;">
                                    <div class="stock-stepper-wrap">
                                        <button type="button" class="btn-stepper-step"
                                                id="qty-minus-{{ $item->id }}"
                                                onclick="stepperChange('{{ $item->id }}', -1)">−</button>
                                        <input type="number"
                                               class="input-stepper-qty"
                                               id="qty-{{ $item->id }}"
                                               data-original="{{ $stok }}"
                                               value="{{ $stok }}"
                                               required
                                               min="0"
                                               step="1">
                                        <button type="button" class="btn-stepper-step"
                                                onclick="stepperChange('{{ $item->id }}', 1)">+</button>
                                    </div>
                                    <span class="stock-porsi-label" id="qty-label-{{ $item->id }}">Porsi</span>
                                </div>
                            </td>

             <td>
                                 <div style="display:flex;align-items:center;gap:6px;justify-content:flex-end;flex-wrap:wrap;"> 
                                     <form id="{{ $formId }}"
                                          method="post"
                                          action="{{ route('seller.stok.update', $item->id) }}"
                                          style="display:none;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="jenis" id="hidden-jenis-{{ $item->id }}" value="koreksi">
                                        <input type="hidden" name="jumlah" id="hidden-qty-{{ $item->id }}" value="{{ $stok }}">
                                        <input type="hidden" name="keterangan" id="hidden-keterangan-{{ $item->id }}">
                                    </form>

                                    <button type="button"
                                            class="btn-action-stock-edit"
                                            id="btn-edit-{{ $item->id }}"
                                            onclick="openStockEditor('{{ $item->id }}', 'restock')">
                                            <i class="fa-solid fa-pencil"></i> Restock
                                    </button>
                                    <button type="button"
                                            class="btn-action-set-habis"
                                            id="btn-koreksi-{{ $item->id }}"
                                            onclick="openCorrectionModal('{{ $item->id }}')">
                                            <i class="fa-regular fa-pen-to-square"></i> Koreksi
                                    </button>
                                    <div id="edit-actions-{{ $item->id }}" style="display:none;gap:6px;">
                                        <button type="button"
                                                class="btn-action-set-tersedia"
                                                onclick="submitUbahStok('{{ $item->id }}', '{{ $formId }}')">
                                            <i class="fa-solid fa-check"></i> Simpan
                                        </button>
                                        <button type="button"
                                                class="btn-action-stock-edit"
                                                onclick="closeStockEditor('{{ $item->id }}')">
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="figma-pagination-footer stock-pagination-footer">
                <div>
                    Menampilkan <strong>{{ $produk->count() > 0 ? $produk->firstItem() : 0 }} - {{ $produk->count() > 0 ? $produk->lastItem() : 0 }}</strong> dari <strong>{{ $produk->total() }}</strong> data produk
                </div>
                <div class="figma-pagination-controls">
                    @if($produk->hasPages())
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

        @else
            <div class="stock-empty-state">
                <i class="fa-solid fa-box-open" style="font-size:40px;color:#cbd5e1;margin-bottom:12px;"></i>
                <div style="font-size:15px;font-weight:700;color:#94a3b8;">Tidak tersedia</div>
                <div style="font-size:13px;color:#cbd5e1;margin-top:4px;">Belum ada produk yang cocok dengan filter ini.</div>
            </div>
        @endif
    </div>

</div>

<div id="correction-modal"
     role="dialog"
     aria-modal="true"
     aria-labelledby="correction-modal-title"
     style="display:none;position:fixed;inset:0;z-index:1000;background:rgba(15,23,42,.55);align-items:center;justify-content:center;padding:16px;">
    <div style="width:min(100%,420px);background:#fff;border-radius:14px;padding:24px;box-shadow:0 20px 50px rgba(15,23,42,.25);">
        <h2 id="correction-modal-title" style="margin:0 0 8px;font-size:18px;">Alasan Koreksi Stok</h2>
        <p style="margin:0 0 16px;color:#64748b;font-size:13px;">Tuliskan keterangan perubahan stok sebelum melanjutkan.</p>
        <label for="correction-reason" style="display:block;margin-bottom:6px;font-size:13px;font-weight:600;">Keterangan</label>
        <input id="correction-reason"
               type="text"
               maxlength="255"
               required
               placeholder="Contoh: stok rusak atau salah hitung"
               style="box-sizing:border-box;width:100%;padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;">
        <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:18px;">
            <button type="button" class="btn-action-stock-edit" onclick="closeCorrectionModal()">Batal</button>
            <button type="button" class="btn-action-set-tersedia" onclick="confirmCorrectionReason()">Lanjutkan</button>
        </div>
    </div>
</div>

    <script>
    let correctionProductId = null;

    function openStockEditor(id, mode) {
            document.querySelectorAll('.stock-editor').forEach(function (editor) {
                editor.style.display = 'none';
            });
            document.querySelectorAll('.stock-view').forEach(function (view) {
                view.style.display = '';
            });
            document.querySelectorAll('[id^="edit-actions-"]').forEach(function (actions) {
                actions.style.display = 'none';
            });
            document.querySelectorAll('[id^="btn-edit-"]').forEach(function (button) {
                button.style.display = '';
            });
            document.querySelectorAll('[id^="btn-koreksi-"]').forEach(function (button) {
                button.style.display = 'none';
            });

            document.querySelectorAll('.input-stepper-qty').forEach(function (input) {
                input.value = input.dataset.original;
                input.min = '0';
                document.getElementById('qty-minus-' + input.id.replace('qty-', '')).disabled = false;
                document.getElementById('qty-label-' + input.id.replace('qty-', '')).textContent = 'Porsi';
            });

            const input = document.getElementById('qty-' + id);
            const minusButton = document.getElementById('qty-minus-' + id);
            document.getElementById('hidden-jenis-' + id).value = mode;
            document.getElementById('hidden-keterangan-' + id).value =
                mode === 'restock' ? 'restock' : document.getElementById('correction-reason').value.trim();
            input.min = mode === 'restock' ? '1' : '0';
            document.getElementById('qty-label-' + id).textContent =
                mode === 'restock' ? 'Porsi tambahan' : 'Porsi';
            minusButton.disabled = mode === 'restock';
            input.value = mode === 'restock' ? '0' : input.dataset.original;

            document.getElementById('stock-view-' + id).style.display = 'none';
            document.getElementById('stock-editor-' + id).style.display = 'flex';
            document.getElementById('btn-edit-' + id).style.display = 'none';
            document.getElementById('edit-actions-' + id).style.display = 'flex';
            document.getElementById('qty-' + id).focus();
            document.getElementById('qty-' + id).select();
        }

        function closeStockEditor(id) {
            const input = document.getElementById('qty-' + id);
            input.value = input.dataset.original;
            input.min = '0';
            document.getElementById('qty-minus-' + id).disabled = false;
            document.getElementById('qty-label-' + id).textContent = 'Porsi';

            document.getElementById('stock-view-' + id).style.display = '';
            document.getElementById('stock-editor-' + id).style.display = 'none';
            document.getElementById('btn-edit-' + id).style.display = '';
            document.getElementById('edit-actions-' + id).style.display = 'none';
        }

        function stepperChange(id, delta) {
            const input = document.getElementById('qty-' + id);
            const val   = Math.max(Number(input.min), parseInt(input.value || 0) + delta);
            input.value = val;
        }

        function openCorrectionModal(id) {
            correctionProductId = id;
            document.getElementById('correction-reason').value = '';
            document.getElementById('correction-modal').style.display = 'flex';
            document.getElementById('correction-reason').focus();
        }

        function closeCorrectionModal() {
            document.getElementById('correction-modal').style.display = 'none';
            correctionProductId = null;
        }

        function confirmCorrectionReason() {
            const reasonInput = document.getElementById('correction-reason');
            if (!reasonInput.reportValidity()) {
                return;
            }

            document.getElementById('hidden-keterangan-' + correctionProductId).value = reasonInput.value.trim();
            openStockEditor(correctionProductId, 'koreksi');
            closeCorrectionModal();
        }

        function submitUbahStok(id, formId) {
            const input = document.getElementById('qty-' + id);
            if (!input.reportValidity()) {
                return;
            }

            document.getElementById('hidden-qty-' + id).value = input.value;
            document.getElementById(formId).submit();
        }
    </script>

@endsection
