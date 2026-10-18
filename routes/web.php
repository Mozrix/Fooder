<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PesananController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [UserController::class, 'tampilkanFormMasuk'])->name('login');
Route::post('/login', [UserController::class, 'prosesMasuk']);

Route::get('/register', [UserController::class, 'tampilkanFormDaftar'])->name('register');
Route::post('/register', [UserController::class, 'prosesDaftar']);

Route::get('/home', [UserController::class, 'berandaCustomer'])->name('customer.home');
Route::get('/store/dashboard', [UserController::class, 'dashboardToko'])->name('store.dashboard');
Route::get('/admin/dashboard', [UserController::class, 'dashboardAdmin'])->name('admin.dashboard');

Route::post('/logout', [UserController::class, 'prosesKeluar'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/customer/menu', [PesananController::class, 'menu'])->name('customer.menu.index');
    Route::get('/customer/pesanan', [PesananController::class, 'index'])->name('customer.pesanan.index');
    Route::get('/customer/pesanan/checkout', [PesananController::class, 'checkout'])->name('customer.pesanan.checkout');
    Route::post('/customer/pesanan', [PesananController::class, 'store'])->name('customer.pesanan.store');
    Route::get('/customer/pesanan/{pesanan}', [PesananController::class, 'show'])->name('customer.pesanan.show');
});
