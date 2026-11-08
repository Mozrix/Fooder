<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdminController, PesananController, UserController,};
use App\Http\Controllers\Seller\{TokoController, DashboardController, ProdukController, StokController};

Route::get('/', fn() => redirect()->route('admin.dashboard'));
Route::get('/login', [UserController::class, 'tampilkanFormMasuk'])->name('login');
Route::post('/login', [UserController::class, 'prosesMasuk'])->name('login.store');
Route::get('/register', [UserController::class, 'tampilkanFormDaftar'])->name('register');
Route::post('/register', [UserController::class, 'prosesDaftar']);
Route::post('/logout', [UserController::class, 'prosesKeluar'])->name('logout');
Route::get('/home', [UserController::class, 'berandaCustomer'])->name('customer.home');
Route::get('/store/dashboard', [UserController::class, 'dashboardToko'])->name('store.dashboard');

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
    Route::get('/customer/menu', [PesananController::class, 'menu'])->name('customer.menu.index');
    Route::get('/customer/pesanan', [PesananController::class, 'index'])->name('customer.pesanan.index');
    Route::get('/customer/pesanan/checkout', [PesananController::class, 'checkout'])->name('customer.pesanan.checkout');
    Route::post('/customer/pesanan', [PesananController::class, 'store'])->name('customer.pesanan.store');
    Route::get('/customer/pesanan/{pesanan}', [PesananController::class, 'show'])->name('customer.pesanan.show');
});

Route::prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [ProdukController::class, 'index'])->name('produk');
    Route::post('/products', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/products/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/products/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/products/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    Route::get('produk/stok', [StokController::class, 'index'])->name('produk.stok');
    Route::get('/stocks', [StokController::class, 'index'])->name('stok');
    Route::get('/stocks/{id}/edit', [StokController::class, 'edit'])->name('stok.edit');
    Route::put('/stocks/{id}', [StokController::class, 'update'])->name('stok.update');
    Route::view('/orders', 'seller.placeholder')->name('pesanan.index');
    Route::view('/queue', 'seller.placeholder')->name('queue.index');
    Route::view('/preorders', 'seller.placeholder')->name('preorders.index');
    Route::view('/pos', 'seller.placeholder')->name('pos.create');
    Route::view('/settings', 'seller.placeholder')->name('settings');
    Route::get('/profile', [TokoController::class, 'show'])->name('toko');
    Route::get('/profile/edit', [TokoController::class, 'edit'])->name('toko.edit');
    Route::put('/profile', [TokoController::class, 'update'])->name('toko.update');
});
