<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fooder - Food Order Kampus</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|playfair-display:600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <main class="min-h-screen bg-[#f5f1ea] text-[#1f1712]">
        <div class="mx-auto max-w-[1480px] px-4 py-5 sm:px-6 lg:px-10">
            <section class="grid gap-5 lg:grid-cols-[1.58fr_1fr]">
                <div class="overflow-hidden rounded-[28px] bg-white p-3 shadow-[0_24px_80px_rgba(78,45,19,.10)]">
                    <div class="relative min-h-[640px] overflow-hidden rounded-[24px] bg-[#cf401d] text-white sm:min-h-[680px] lg:min-h-[720px]">
                        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1800&q=85" alt="Suasana kantin dengan makanan siap dipesan" class="absolute inset-0 h-full w-full object-cover opacity-30 mix-blend-screen">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_61%_38%,rgba(255,191,69,.78),transparent_30%),linear-gradient(118deg,#b72d17_0%,#ef5a1f_49%,#8f2414_100%)]"></div>

                        <header class="relative z-10 flex items-center justify-between gap-4 px-5 py-5 sm:px-7">
                            <a href="#" class="flex items-center gap-2 text-lg font-bold">
                                <span class="grid h-9 w-9 place-items-center rounded-full bg-white text-[#e44e1d]">F</span>
                                Fooder
                            </a>
                            <nav class="hidden items-center gap-1 rounded-full bg-white px-2 py-2 text-sm font-medium text-[#261812] shadow-lg md:flex">
                                <a class="rounded-full bg-[#ff8b1a] px-5 py-2 text-white" href="#">Home</a>
                                <a class="rounded-full px-5 py-2 transition hover:bg-[#fff0dd]" href="#">Menu</a>
                                <a class="rounded-full px-5 py-2 transition hover:bg-[#fff0dd]" href="#">Antrean</a>
                                <a class="rounded-full px-5 py-2 transition hover:bg-[#fff0dd]" href="#">Pre-Order</a>
                                <a class="rounded-full px-5 py-2 transition hover:bg-[#fff0dd]" href="#">Seller</a>
                            </nav>
                            <div class="flex items-center gap-2">
                                <button class="grid h-11 w-11 place-items-center rounded-full bg-white text-[#211711] shadow-lg" aria-label="Cari menu">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.2-3.2"/></svg>
                                </button>
                                <button class="hidden h-11 items-center gap-2 rounded-full bg-white px-4 text-sm font-semibold text-[#211711] shadow-lg sm:flex" aria-label="Pilih kampus">
                                    Kampus
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </button>
                                <button class="relative grid h-11 w-11 place-items-center rounded-full bg-white text-[#211711] shadow-lg" aria-label="Keranjang pesanan">
                                    <span class="absolute -right-1 -top-1 grid h-5 w-5 place-items-center rounded-full bg-[#ff8b1a] text-[11px] font-bold text-white">2</span>
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6h15l-1.5 8.5H8L6 3H3"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg>
                                </button>
                            </div>
                        </header>

                        <div class="relative z-10 grid min-h-[550px] items-end gap-8 px-6 pb-8 pt-10 sm:px-9 lg:grid-cols-[1fr_.72fr] lg:items-center lg:pb-12">
                            <div>
                                <p class="mb-4 inline-flex rounded-full bg-white/15 px-4 py-2 text-sm font-semibold backdrop-blur">Food order untuk lingkungan kampus</p>
                                <h1 class="max-w-[660px] font-['Playfair_Display'] text-5xl font-bold leading-[.94] sm:text-7xl lg:text-8xl">Pesan Makan Tanpa Antre Panjang</h1>
                                <p class="mt-6 max-w-xl text-base leading-7 text-white/88 sm:text-lg">Pilih menu kantin, bayar dengan simulasi QRIS, E-Wallet, atau Virtual Account, lalu pantau nomor antrean dan jadwal ambil pesananmu.</p>
                                <div class="mt-8 flex max-w-[620px] flex-wrap items-center gap-4">
                                    <a href="#" class="rounded-full bg-[#ff8b1a] px-7 py-3 text-sm font-bold text-white shadow-[0_12px_32px_rgba(71,24,8,.25)]">Pesan Sekarang</a>
                                    <a href="#" class="rounded-full bg-white/16 px-7 py-3 text-sm font-bold text-white backdrop-blur">Buat Pre-Order</a>
                                    <div class="flex items-center gap-3 rounded-full bg-white/15 px-4 py-3 backdrop-blur">
                                        <span class="grid h-9 w-9 place-items-center rounded-full bg-white text-sm font-bold text-[#e44e1d]">A12</span>
                                        <span class="text-sm font-semibold">Antrean real-time</span>
                                    </div>
                                </div>
                            </div>

                            <aside class="max-w-sm rounded-[24px] bg-white/14 p-4 backdrop-blur-md">
                                <div class="overflow-hidden rounded-[18px]">
                                    <img src="https://images.unsplash.com/photo-1512058564366-18510be2db19?auto=format&fit=crop&w=760&q=85" alt="Menu nasi goreng siap saji" class="h-44 w-full object-cover">
                                </div>
                                <div class="mt-4 flex items-end justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-semibold underline underline-offset-4">Nasi goreng spesial</p>
                                        <p class="mt-3 text-sm leading-6 text-white/85">Makanan berat masuk waiting list otomatis. Pesanan online dan walk-in tetap satu antrean.</p>
                                    </div>
                                    <span class="shrink-0 rounded-full bg-white px-4 py-2 text-sm font-bold text-[#e84d1f]">#A12</span>
                                </div>
                            </aside>
                        </div>
                    </div>

                    <div class="grid gap-4 px-1 py-8 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-[18px] border border-[#ece6df] bg-white p-6 text-center shadow-sm">
                            <div class="mx-auto mb-3 grid h-11 w-11 place-items-center rounded-full bg-[#fff0dd] text-[#f47b16]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="M8 9h8"/><path d="M8 13h6"/><path d="M8 17h4"/></svg>
                            </div>
                            <h3 class="font-['Playfair_Display'] text-xl font-bold">Menu Kampus</h3>
                            <p class="mt-1 text-xs text-[#6f625b]">Produk tenant tersusun per kategori</p>
                        </div>
                        <div class="rounded-[18px] border border-[#ece6df] bg-white p-6 text-center shadow-sm">
                            <div class="mx-auto mb-3 grid h-11 w-11 place-items-center rounded-full bg-[#fff0dd] text-[#f47b16]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/></svg>
                            </div>
                            <h3 class="font-['Playfair_Display'] text-xl font-bold">Waiting List</h3>
                            <p class="mt-1 text-xs text-[#6f625b]">Online dan walk-in tersinkron</p>
                        </div>
                        <div class="rounded-[18px] border border-[#ece6df] bg-white p-6 text-center shadow-sm">
                            <div class="mx-auto mb-3 grid h-11 w-11 place-items-center rounded-full bg-[#fff0dd] text-[#f47b16]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/><path d="M8 15h4"/></svg>
                            </div>
                            <h3 class="font-['Playfair_Display'] text-xl font-bold">Pre-Order</h3>
                            <p class="mt-1 text-xs text-[#6f625b]">Pilih jadwal pengambilan</p>
                        </div>
                        <div class="rounded-[18px] border border-[#ece6df] bg-white p-6 text-center shadow-sm">
                            <div class="mx-auto mb-3 grid h-11 w-11 place-items-center rounded-full bg-[#fff0dd] text-[#f47b16]">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18"/><path d="M7 15h4"/></svg>
                            </div>
                            <h3 class="font-['Playfair_Display'] text-xl font-bold">Auto Paid</h3>
                            <p class="mt-1 text-xs text-[#6f625b]">Simulasi pembayaran instan</p>
                        </div>
                    </div>

                    <section class="px-1 pb-5">
                        <div class="mb-5 flex items-end justify-between gap-4">
                            <h2 class="font-['Playfair_Display'] text-3xl font-bold uppercase sm:text-4xl">Pilihan Menu</h2>
                            <a href="#" class="hidden text-sm font-semibold text-[#e84d1f] sm:inline">Lihat semua menu</a>
                        </div>
                        <div class="grid min-h-[560px] gap-4 lg:grid-cols-[.95fr_1.6fr]">
                            <a href="#" class="group relative overflow-hidden rounded-[22px] bg-[#ddd5ca]">
                                <img src="https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&w=900&q=85" alt="Makanan berat nasi goreng" class="h-full min-h-[360px] w-full object-cover transition duration-500 group-hover:scale-105">
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-6 text-white">
                                    <span class="mb-2 inline-flex rounded-full bg-[#ff8b1a] px-3 py-1 text-xs font-bold">Waiting List</span>
                                    <h3 class="font-['Playfair_Display'] text-2xl font-bold">Makanan Berat</h3>
                                    <p class="text-sm">Nasi goreng, ayam geprek, soto, dan menu masak.</p>
                                </div>
                            </a>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <a href="#" class="group relative overflow-hidden rounded-[22px] bg-[#ddd5ca] sm:col-span-2">
                                    <img src="https://images.unsplash.com/photo-1544145945-f90425340c7e?auto=format&fit=crop&w=1200&q=85" alt="Minuman dingin dan makanan ringan" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105">
                                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-6 text-white">
                                        <span class="mb-2 inline-flex rounded-full bg-white/20 px-3 py-1 text-xs font-bold">Stok Otomatis</span>
                                        <h3 class="font-['Playfair_Display'] text-2xl font-bold">Makanan Ringan & Minuman</h3>
                                        <p class="text-sm">Stok langsung berkurang setelah pembayaran berhasil.</p>
                                    </div>
                                </a>
                                <a href="#" class="group relative overflow-hidden rounded-[22px] bg-[#ddd5ca]">
                                    <img src="https://images.unsplash.com/photo-1627308595229-7830a5c91f9f?auto=format&fit=crop&w=760&q=85" alt="Paket makan siang" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105">
                                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-5 text-white">
                                        <h3 class="font-['Playfair_Display'] text-xl font-bold">Paket Hemat</h3>
                                        <p class="text-sm">Favorit mahasiswa untuk jam istirahat.</p>
                                    </div>
                                </a>
                                <a href="#" class="group relative overflow-hidden rounded-[22px] bg-[#ddd5ca]">
                                    <img src="https://images.unsplash.com/photo-1562967914-608f82629710?auto=format&fit=crop&w=760&q=85" alt="Pre-order makanan" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105">
                                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-5 text-white">
                                        <h3 class="font-['Playfair_Display'] text-xl font-bold">Ambil Terjadwal</h3>
                                        <p class="text-sm">Pesan sekarang, ambil sesuai slot waktu.</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </section>
                </div>

                <aside class="space-y-5">
                    <section class="overflow-hidden rounded-[24px] bg-[#f4ad1f] p-5 text-white shadow-[0_24px_80px_rgba(78,45,19,.10)]">
                        <div class="relative min-h-[330px] overflow-hidden rounded-[18px]">
                            <img src="https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&w=1100&q=85" alt="Tenant kantin melayani pesanan" class="absolute inset-0 h-full w-full object-cover opacity-58 mix-blend-multiply">
                            <div class="absolute inset-0 bg-gradient-to-br from-[#f2a719]/90 via-[#f7bd42]/72 to-[#e18217]/78"></div>
                            <p class="relative z-10 p-6 text-xs font-bold uppercase">Dashboard Seller</p>
                            <h2 class="relative z-10 px-6 font-['Playfair_Display'] text-6xl font-bold leading-none sm:text-7xl">POS Cepat</h2>
                            <div class="absolute bottom-6 left-6 right-6 rounded-[20px] bg-white/18 p-4 backdrop-blur-md">
                                <div class="grid gap-3">
                                    <div class="flex items-center justify-between rounded-[14px] bg-white/18 px-4 py-3">
                                        <span class="text-sm font-bold">#A10 Ayam Bakar</span>
                                        <span class="rounded-full bg-white px-3 py-1 text-xs font-bold text-[#e18217]">Diproses</span>
                                    </div>
                                    <div class="flex items-center justify-between rounded-[14px] bg-white/18 px-4 py-3">
                                        <span class="text-sm font-bold">#A11 Soto Ayam</span>
                                        <span class="rounded-full bg-white/25 px-3 py-1 text-xs font-bold">Menunggu</span>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute right-6 top-28 grid h-20 w-20 place-items-center rounded-full border border-white/60 bg-[#ff8b1a] text-center text-[11px] font-bold uppercase leading-tight">Walk-in<br>Ready</div>
                        </div>
                    </section>

                    <section class="rounded-[24px] bg-white p-5 shadow-[0_24px_80px_rgba(78,45,19,.10)]">
                        <div class="mb-4 flex items-end justify-between gap-4">
                            <h2 class="font-['Playfair_Display'] text-2xl font-bold uppercase leading-tight">Alur Pesanan<br>FoodOrder</h2>
                            <a href="#" class="text-xs font-semibold text-[#6f625b]">Mulai</a>
                        </div>
                        <div class="grid gap-3">
                            <div class="rounded-[18px] bg-[#fff7ec] p-4">
                                <div class="flex items-start gap-4">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-[#ff8b1a] text-sm font-bold text-white">1</span>
                                    <div>
                                        <h3 class="font-['Playfair_Display'] text-xl font-bold">Customer pilih menu</h3>
                                        <p class="mt-1 text-sm leading-6 text-[#6f625b]">Masukkan makanan berat atau ringan ke cart, lalu pilih Pesan Sekarang atau Pre-Order.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="rounded-[18px] bg-[#f3f1ee] p-4">
                                <div class="flex items-start gap-4">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-[#1f1712] text-sm font-bold text-white">2</span>
                                    <div>
                                        <h3 class="font-['Playfair_Display'] text-xl font-bold">Pembayaran tervalidasi</h3>
                                        <p class="mt-1 text-sm leading-6 text-[#6f625b]">Simulasi payment gateway mengubah status menjadi paid tanpa upload bukti manual.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="rounded-[18px] bg-[#fff7ec] p-4">
                                <div class="flex items-start gap-4">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-[#ff8b1a] text-sm font-bold text-white">3</span>
                                    <div>
                                        <h3 class="font-['Playfair_Display'] text-xl font-bold">Seller proses antrean</h3>
                                        <p class="mt-1 text-sm leading-6 text-[#6f625b]">Pesanan online dan walk-in masuk daftar yang sama, struk digital atau fisik siap dibuat.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="grid gap-3 sm:grid-cols-3 lg:grid-cols-1 xl:grid-cols-3">
                        <div class="rounded-[18px] bg-[#1f1712] p-5 text-white">
                            <p class="text-xs font-bold uppercase text-[#ffba51]">Customer</p>
                            <h3 class="mt-2 font-['Playfair_Display'] text-xl font-bold">Pesan cepat</h3>
                        </div>
                        <div class="rounded-[18px] bg-white p-5">
                            <p class="text-xs font-bold uppercase text-[#e84d1f]">Seller</p>
                            <h3 class="mt-2 font-['Playfair_Display'] text-xl font-bold">Kelola stok</h3>
                        </div>
                        <div class="rounded-[18px] bg-[#ff8b1a] p-5 text-white">
                            <p class="text-xs font-bold uppercase text-white/80">Admin</p>
                            <h3 class="mt-2 font-['Playfair_Display'] text-xl font-bold">Pantau data</h3>
                        </div>
                    </section>
                </aside>
            </section>
        </div>
    </main>
</body>
</html>
