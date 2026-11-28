<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdminController, PesananController, UserController,};
use App\Http\Controllers\Seller\{TokoController, DashboardController, ProdukController, StokController, RiwayatController, LaporanController, PesananController  as SellerPesananController};

Route::get('/register', [UserController::class, 'tampilkanFormDaftar'])->name('register');
Route::post('/register', [UserController::class, 'prosesDaftar']);
Route::get('/', fn() => redirect()->route('admin.dashboard'));
Route::get('/login', [UserController::class, 'tampilkanFormMasuk'])->name('login');
Route::post('/login', [UserController::class, 'prosesMasuk'])->name('login.store');
Route::post('/logout', [UserController::class, 'prosesKeluar'])->name('logout');
Route::get('/home', [UserController::class, 'berandaCustomer'])->name('customer.home');
Route::get('/store/dashboard', [UserController::class, 'dashboardToko'])->name('store.dashboard');
Route::get('/customer/menu', [PesananController::class, 'menu'])->name('customer.menu.index');
Route::get('/customer/menu/{produk}', [PesananController::class, 'detailMenu'])->name('customer.menu.show');
Route::get('/customer/toko/{toko}', [PesananController::class, 'detailToko'])->name('customer.toko.show');
Route::post('/customer/keranjang/items', [PesananController::class, 'addToCart'])->name('customer.keranjang.add');
Route::patch('/customer/keranjang/items/{produk}', [PesananController::class, 'updateCart'])->name('customer.keranjang.update');
Route::delete('/customer/keranjang/items/{produk}', [PesananController::class, 'removeFromCart'])->name('customer.keranjang.remove');
Route::get('/customer/keranjang', [PesananController::class, 'checkout'])->name('customer.pesanan.checkout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('users', [AdminController::class, 'users'])->name('users');
    Route::get('users/create', [AdminController::class, 'userCreate'])->name('users.create');
    Route::post('users', [AdminController::class, 'userStore'])->name('users.store');
    Route::get('users/{user}/edit', [AdminController::class, 'userEdit'])->name('users.edit');
    Route::put('users/{user}', [AdminController::class, 'userUpdate'])->name('users.update');
    Route::delete('users/{user}', [AdminController::class, 'userDestroy'])->name('users.destroy');
    Route::get('categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('categories/create', [AdminController::class, 'categoryCreate'])->name('categories.create');
    Route::post('categories', [AdminController::class, 'categoryStore'])->name('categories.store');
    Route::get('categories/{category}/edit', [AdminController::class, 'categoryEdit'])->name('categories.edit');
    Route::put('categories/{category}', [AdminController::class, 'categoryUpdate'])->name('categories.update');
    Route::delete('categories/{category}', [AdminController::class, 'categoryDestroy'])->name('categories.destroy');
    foreach (['stores', 'products', 'orders', 'payments', 'queues', 'stock-history'] as $resource) {
        Route::get($resource, fn(\Illuminate\Http\Request $request) => app(AdminController::class)->resource($request, $resource))->name($resource);
    }
});

Route::middleware(['auth'])->group(function () {
    Route::get('/customer/pesanan', [PesananController::class, 'index'])->name('customer.pesanan.index');
    Route::post('/customer/pesanan', [PesananController::class, 'store'])->name('customer.pesanan.store');
    Route::get('/customer/pesanan/{pesanan}', [PesananController::class, 'show'])->name('customer.pesanan.show');

    Route::get('/customer/pesanan/{pesanan}/pembayaran', [PesananController::class, 'halamanPembayaran'])->name('customer.pesanan.pembayaran');
    Route::post('/customer/pesanan/{pesanan}/bayar', [PesananController::class, 'prosesBayar'])->name('customer.pesanan.bayar');
    Route::post('/customer/pesanan/{pesanan}/batalkan', [PesananController::class, 'batalkanPembayaran'])->name('customer.pesanan.batalkan');

    Route::get('/customer/pesanan/{pesanan}/struk', [PesananController::class, 'struk'])->name('customer.pesanan.struk');
});

Route::prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/stok', [StokController::class, 'index'])->name('stok');
    Route::get('/stok/{id}/edit', [StokController::class, 'edit'])->name('stok.edit');
    Route::put('/stok/{id}', [StokController::class, 'update'])->name('stok.update');
    Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    Route::get('/pesanan', [\App\Http\Controllers\Seller\PesananController::class, 'index'])->name('pesanan');
    Route::patch('/pesanan/{pesanan}/status', [\App\Http\Controllers\Seller\PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/riwayat/stok', [RiwayatController::class, 'stokIndex'])->name('riwayat.stok.index');
    Route::get('/riwayat/stok/{id}', [RiwayatController::class, 'stok'])->name('riwayat.stok');

    Route::get('/toko', [TokoController::class, 'index'])->name('toko');
    Route::get('/toko/edit', [TokoController::class, 'edit'])->name('toko.edit');
    Route::put('/toko', [TokoController::class, 'update'])->name('toko.update');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
});
