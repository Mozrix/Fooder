<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdminController, PesananController, UserController};

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
