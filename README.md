<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# FOODORDER — Spesifikasi Lengkap Proyek

**Nama Proyek:** FoodOrder  
**Jenis Aplikasi:** Sistem Pemesanan Makanan Berbasis Web  
**Framework:** Laravel  
**Database:** MySQL  
**Arsitektur:** Model-View-Controller (MVC)  
**Acuan UI:** Referensi dashboard food ordering dan storefront yang diberikan pengguna.

---

## 1. TUJUAN PROYEK

FoodOrder merupakan aplikasi pemesanan makanan berbasis web yang menghubungkan Customer, Seller, dan Admin dalam satu sistem terintegrasi.

Sistem menyediakan fitur katalog makanan, pemesanan, keranjang, checkout, pembayaran simulasi, Pre-Order, pengelolaan stok, antrean pesanan, kasir walk-in, struk transaksi, riwayat pesanan, dashboard, monitoring, dan laporan.

Aplikasi harus memiliki frontend dan backend yang benar-benar terintegrasi dengan database. Seluruh fitur wajib berfungsi, bukan hanya tampilan statis.

### 1.1 Tujuan utama

1. Memudahkan Customer mencari dan memesan makanan.
2. Memungkinkan Seller mengelola produk, stok, pesanan, dan transaksi.
3. Memungkinkan Admin memantau keseluruhan aktivitas sistem.
4. Mengintegrasikan pesanan online dan walk-in ke sistem antrean yang sama.
5. Membedakan mekanisme Makanan Berat dan Makanan Ringan.
6. Mendukung pemesanan langsung dan Pre-Order.
7. Menyediakan informasi transaksi yang transparan dan mudah dipantau.

## 2. ATURAN PENGEMBANGAN

Sebelum melakukan perubahan kode, Codex wajib:

1. Membaca seluruh dokumen spesifikasi ini.
2. Memeriksa struktur repository Laravel yang tersedia.
3. Memeriksa versi PHP, Laravel, Composer, migration, model, controller, middleware, route, view, dan konfigurasi database.
4. Mengidentifikasi fitur yang sudah tersedia dan fitur yang belum selesai.
5. Mempertahankan kode yang sudah benar.
6. Menghindari pembuatan tabel, controller, route, atau fitur duplikat.
7. Menggunakan struktur MVC sesuai konvensi proyek.
8. Menggunakan migration untuk perubahan struktur database.
9. Memastikan seluruh fitur terhubung ke database.
10. Tidak menghapus data atau melakukan perubahan destruktif tanpa memeriksa dampaknya.
11. Tidak mengganti versi framework tanpa alasan yang jelas.
12. Tidak menggunakan data dummy sebagai pengganti fitur backend.
13. Tidak membuat tombol, form, filter, atau navigasi yang hanya menjadi dekorasi.
14. Memperbarui README sesuai implementasi akhir.

Jika repository sudah memiliki implementasi yang sesuai, lanjutkan dari kode yang ada dan jangan membangun ulang tanpa kebutuhan.

## 3. TEKNOLOGI DAN ARSITEKTUR

Gunakan teknologi sesuai kondisi repository:

- Laravel sebagai framework backend.
- PHP sebagai bahasa pemrograman.
- MySQL sebagai database.
- Blade untuk template antarmuka.
- HTML5 dan CSS3 untuk struktur dan desain.
- JavaScript vanilla jika dibutuhkan untuk interaksi frontend.
- Eloquent ORM untuk pengelolaan data.
- Laravel Migration untuk struktur database.
- Middleware, Policy, atau Gate untuk pengaturan hak akses.
- Laravel Validation atau Form Request untuk validasi input.

Versi PHP dan Laravel harus mengikuti repository aktual.

### 3.1 Model

Model bertanggung jawab atas representasi data, relasi antartabel, dan interaksi dengan database.

### 3.2 View

View menggunakan Blade untuk menampilkan halaman publik, Customer, Seller, dan Admin.

### 3.3 Controller

Controller menangani request pengguna, memanggil logika bisnis, dan mengembalikan response.

### 3.4 Service

Untuk proses kompleks seperti checkout, pembayaran, pengurangan stok, alokasi Pre-Order, dan pembuatan antrean, gunakan service atau action class jika sesuai dengan struktur proyek.

### 3.5 Keamanan

Seluruh otorisasi wajib diperiksa di backend. Menyembunyikan tombol atau menu pada frontend tidak cukup untuk melindungi data.

---

# 4. ROLE DAN HAK AKSES

Sistem memiliki tiga role utama yang telah login, yaitu Customer, Seller, dan Admin, serta Guest sebagai pengunjung yang belum login.

## 4.1 Guest

Guest dapat:

- Membuka landing page.
- Melihat katalog makanan yang tersedia untuk publik.
- Melihat kategori makanan.
- Melihat detail produk.
- Membuka halaman login.
- Membuka halaman registrasi Customer.

Guest tidak dapat membuat pesanan atau mengakses dashboard role.

## 4.2 Customer

Customer dapat:

- Registrasi akun.
- Login dan logout.
- Melihat katalog makanan.
- Mencari produk.
- Memfilter kategori dan toko jika tersedia.
- Melihat detail produk.
- Menambahkan produk ke keranjang.
- Mengubah jumlah item.
- Menghapus item dari keranjang.
- Melakukan checkout.
- Memilih Pesan Sekarang.
- Memilih Pre-Order.
- Memilih jadwal pengambilan Pre-Order.
- Memilih metode pembayaran simulasi.
- Melihat status pembayaran.
- Melihat status pesanan dan antrean jika relevan.
- Melihat riwayat pesanan.
- Melihat detail transaksi.
- Melihat dan mencetak struk digital untuk pesanan yang telah dibayar.

Customer hanya boleh melihat dan mengelola transaksi miliknya sendiri.

## 4.3 Seller

Seller dapat:

- Login ke dashboard Seller.
- Mengelola informasi toko sesuai struktur aplikasi.
- Menambahkan produk.
- Melihat produk.
- Mengedit produk.
- Menghapus atau menonaktifkan produk sesuai aturan relasi data.
- Mengelola harga dan stok.
- Melakukan restock.
- Melihat histori stok.
- Melihat pesanan masuk.
- Melihat detail pesanan.
- Memproses pesanan yang memenuhi syarat.
- Melihat waiting list Makanan Berat.
- Melihat daftar Pre-Order.
- Membuat transaksi walk-in melalui kasir.
- Mendapatkan nomor antrean untuk pesanan Makanan Berat.
- Mencetak struk fisik.
- Melihat histori transaksi tokonya.

Seller tidak boleh mengakses produk, stok, pesanan, atau transaksi milik Seller lain.

## 4.4 Admin

Admin dapat:

- Mengakses dashboard Admin.
- Melihat statistik global.
- Mengelola pengguna.
- Mengelola kategori.
- Melihat daftar toko.
- Memantau produk seluruh toko.
- Memantau stok.
- Memantau pesanan.
- Memantau pembayaran.
- Memantau antrean.
- Melihat histori stok.
- Melihat ringkasan transaksi.
- Melihat laporan.
- Melihat aktivitas administratif jika modul tersebut tersedia.

Admin bertindak sebagai pengelola dan pengawas sistem. Pada alur normal, Admin tidak menggantikan Seller untuk memproses pesanan dapur.

---

# 5. HALAMAN PUBLIK

## 5.1 Landing Page

Buat halaman utama FoodOrder dengan desain modern dan profesional.

Komponen:

- Navbar dengan logo FoodOrder.
- Navigasi Home.
- Navigasi Menu.
- Tombol Login.
- Tombol Register.
- Hero section.
- Deskripsi singkat sistem.
- Tombol Lihat Menu.
- Bagian kategori makanan.
- Bagian produk pilihan jika data tersedia.
- Bagian keunggulan layanan.
- Footer.

Navbar harus menyesuaikan status autentikasi pengguna.

Jika pengguna sudah login, tampilkan navigasi sesuai role yang bersangkutan.

## 5.2 Katalog Makanan

Katalog menampilkan produk dari database.

Setiap kartu produk menampilkan:

- Gambar produk.
- Nama produk.
- Harga.
- Kategori.
- Nama toko.
- Tipe makanan.
- Informasi stok atau ketersediaan.
- Tombol detail.
- Tombol tambah ke keranjang jika pengguna memenuhi syarat.

Tambahkan pencarian dan filter yang benar-benar berfungsi.

Produk yang tidak tersedia harus ditandai dan tidak boleh dipesan.

## 5.3 Detail Produk

Halaman detail produk menampilkan:

- Nama produk.
- Gambar.
- Deskripsi.
- Harga.
- Kategori.
- Tipe makanan.
- Nama toko.
- Ketersediaan.
- Input jumlah.
- Tombol tambah ke keranjang.

Validasi jumlah dan ketersediaan harus dilakukan kembali di server.

## 5.4 Autentikasi

Buat fitur:

- Registrasi Customer.
- Login.
- Logout.
- Validasi input.
- Validasi email unik.
- Password hashing.
- Session management.
- Redirect berdasarkan role.
- Pesan error dan sukses.

Registrasi publik tidak boleh memberikan role Admin secara bebas.

Pembuatan akun Seller mengikuti mekanisme yang tersedia dalam proyek.

---

# 6. MODUL CUSTOMER

## 6.1 Dashboard Customer

Dashboard Customer dapat menampilkan:

- Sapaan pengguna.
- Ringkasan pesanan terbaru.
- Status pesanan aktif.
- Riwayat pesanan.
- Tombol menuju katalog.
- Informasi antrean untuk pesanan yang relevan.

Semua data harus berdasarkan akun yang sedang login.

## 6.2 Keranjang Belanja

Customer dapat:

- Menambahkan produk.
- Mengubah jumlah produk.
- Menghapus produk.
- Melihat harga satuan.
- Melihat subtotal.
- Melihat total sementara.
- Melanjutkan ke checkout.

Aturan keranjang:

1. Keranjang tidak boleh kosong saat checkout.
2. Jumlah produk minimal satu.
3. Jumlah tidak boleh melebihi stok bebas.
4. Harga harus dihitung ulang dari database.
5. Total tidak boleh dipercaya hanya dari frontend.
6. Stok harus diperiksa kembali saat checkout.
7. Jika desain database mengharuskan satu pesanan berasal dari satu toko, keranjang tidak boleh menggabungkan produk dari toko berbeda.

Penyimpanan keranjang dapat menggunakan session atau database sesuai arsitektur yang ada.

## 6.3 Checkout

Halaman checkout menampilkan:

- Daftar produk.
- Nama toko.
- Jumlah.
- Harga satuan.
- Subtotal.
- Total pembayaran.
- Mode pemesanan.
- Metode pembayaran.
- Jadwal pengambilan jika Pre-Order.

Customer dapat memilih:

- Pesan Sekarang.
- Pre-Order.

Ketika Pre-Order dipilih, tampilkan pilihan jadwal pengambilan yang tersedia.

Sebelum menyimpan pesanan, sistem wajib memvalidasi:

- Identitas Customer.
- Produk.
- Harga terbaru.
- Jumlah.
- Ketersediaan stok.
- Toko.
- Jadwal Pre-Order.
- Total pembayaran.

Gunakan transaksi database agar pesanan tidak tersimpan sebagian ketika terjadi kegagalan.

## 6.4 Pesan Sekarang

Alur:

1. Customer memilih produk.
2. Customer memasukkan produk ke keranjang.
3. Customer membuka checkout.
4. Customer memilih Pesan Sekarang.
5. Sistem memvalidasi harga dan stok.
6. Sistem membuat pesanan.
7. Customer memilih metode pembayaran.
8. Customer menyelesaikan pembayaran simulasi.
9. Status pembayaran diperbarui.
10. Pesanan yang memenuhi syarat ditampilkan kepada Seller.
11. Customer dapat memantau status pesanan.

Untuk Makanan Berat, pesanan yang telah memenuhi syarat masuk ke waiting list.

Untuk Makanan Ringan, stok mengikuti mekanisme pengurangan stok yang ditentukan oleh aturan bisnis.

## 6.5 Pre-Order

Pre-Order digunakan untuk pemesanan dengan tanggal dan waktu pengambilan yang dipilih Customer.

Fitur:

- Memilih produk.
- Memilih jumlah.
- Memilih jadwal pengambilan.
- Melihat ringkasan pesanan.
- Melakukan pembayaran simulasi.
- Melihat status Pre-Order.
- Melihat detail jadwal.
- Melihat struk yang mencantumkan jadwal pengambilan.

Aturan:

1. Jadwal harus tersedia dan valid.
2. Pre-Order tidak langsung masuk antrean reguler.
3. Pesanan yang belum dibayar tidak boleh diproses.
4. Stok yang dialokasikan untuk Pre-Order tidak boleh dihitung sebagai stok bebas.
5. Pesanan yang sudah memasuki tahap pemrosesan tidak dapat mengubah jadwal secara bebas.
6. Pesanan expired atau canceled tidak boleh diproses.
7. Pelepasan alokasi stok harus dilakukan secara konsisten dan tidak boleh terjadi dua kali.

Jika proyek belum memiliki pengaturan jadwal, implementasikan mekanisme sederhana yang nyata dan dokumentasikan aturan slot serta batas waktunya.

## 6.6 Pembayaran Simulasi

Metode pembayaran:

- QRIS.
- E-Wallet.
- Virtual Account.

Pembayaran merupakan simulasi untuk kebutuhan proyek, bukan integrasi langsung ke penyedia pembayaran eksternal.

Status pembayaran yang digunakan:

- `pending`
- `paid`
- `failed`, jika alur gagal diterapkan.
- `expired`

Alur:

1. Customer memilih metode pembayaran.
2. Sistem membuat data pembayaran.
3. Customer menjalankan simulasi pembayaran.
4. Sistem memvalidasi status dan kepemilikan pesanan.
5. Jika berhasil, status berubah menjadi paid.
6. Sistem menjalankan proses bisnis lanjutan sesuai tipe makanan dan pesanan.
7. Customer memperoleh informasi pembayaran.

Aturan:

- Pesanan paid tidak boleh dibayar ulang.
- Pesanan expired tidak boleh diproses.
- Request berulang tidak boleh mengurangi stok dua kali.
- Customer tidak boleh membayar pesanan milik orang lain.
- Status pembayaran tidak boleh diubah secara bebas melalui request frontend.
- Tidak perlu upload bukti transfer.
- Tidak perlu verifikasi manual Admin atau Seller.

## 6.7 Riwayat Pesanan

Tampilkan:

- Kode pesanan.
- Tanggal transaksi.
- Nama toko.
- Daftar produk.
- Total pembayaran.
- Tipe pemesanan.
- Status pembayaran.
- Status pesanan.
- Jadwal Pre-Order jika ada.
- Nomor antrean jika relevan.
- Tombol detail.
- Tombol struk untuk transaksi yang memenuhi syarat.

Customer hanya dapat melihat riwayat pesanan miliknya sendiri.

## 6.8 Struk Digital

Struk digital tersedia untuk pesanan online yang telah dibayar.

Informasi:

- Nama FoodOrder.
- Kode pesanan.
- Tanggal transaksi.
- Nama Customer.
- Nama toko.
- Daftar produk.
- Jumlah.
- Harga satuan.
- Subtotal.
- Total pembayaran.
- Metode pembayaran.
- Status pembayaran.
- Nomor antrean jika relevan.
- Jadwal pengambilan untuk Pre-Order.

Sediakan tampilan yang dapat dicetak menggunakan browser.

---

# 7. MODUL SELLER

## 7.1 Dashboard Seller

Dashboard Seller menampilkan data toko yang dimiliki Seller.

Komponen:

- Ringkasan pesanan.
- Pesanan yang menunggu pemrosesan.
- Waiting list Makanan Berat.
- Pre-Order mendatang.
- Jumlah produk.
- Ringkasan stok.
- Akses kasir walk-in.
- Histori transaksi.
- Histori perubahan stok.

Seluruh data harus dibatasi berdasarkan toko yang dimiliki Seller.

## 7.2 Manajemen Produk

Buat CRUD produk dengan field yang sesuai database:

- Nama produk.
- Deskripsi.
- Harga.
- Kategori.
- Tipe makanan.
- Stok.
- Status ketersediaan jika tersedia.
- Gambar jika fitur upload didukung.

Fitur:

- Daftar produk.
- Tambah produk.
- Detail produk.
- Edit produk.
- Hapus atau nonaktifkan produk.
- Pencarian.
- Filter kategori.
- Pagination.

Validasi:

- Nama produk wajib.
- Harga tidak boleh negatif.
- Stok tidak boleh negatif.
- Kategori harus valid.
- Produk harus terkait dengan toko milik Seller.
- Seller tidak boleh memalsukan `toko_id` melalui request.

## 7.3 Pengelolaan Stok

Seller dapat melakukan:

- Melihat stok.
- Menambah stok.
- Melakukan koreksi stok.
- Melihat histori stok.

Setiap perubahan stok harus mencatat:

- Produk.
- Actor yang melakukan perubahan.
- Stok sebelum perubahan.
- Jumlah perubahan.
- Stok sesudah perubahan.
- Jenis perubahan.
- Keterangan.
- Waktu perubahan.

Stok tidak boleh negatif.

Perubahan stok otomatis akibat pembayaran, checkout, pembatalan, atau expired harus konsisten dengan histori stok.

## 7.4 Daftar Pesanan

Seller dapat melihat:

- Kode pesanan.
- Waktu pesanan.
- Nama Customer atau identitas yang relevan.
- Produk.
- Jumlah.
- Total.
- Status pembayaran.
- Status pesanan.
- Tipe pemesanan.
- Jadwal Pre-Order.
- Nomor antrean.

Seller hanya dapat melihat pesanan tokonya.

Pesanan yang belum dibayar, expired, atau canceled tidak boleh diproses.

## 7.5 Waiting List Makanan Berat

Waiting list berlaku untuk Makanan Berat.

Informasi:

- Nomor antrean.
- Kode pesanan.
- Waktu masuk.
- Detail pesanan.
- Status pemrosesan.

Ketentuan:

1. Pesanan online dan walk-in menggunakan antrean yang sama.
2. Antrean terikat pada toko yang relevan.
3. Urutan mengikuti waktu masuk sesuai aturan sistem.
4. Pesanan yang belum dibayar tidak boleh diproses jika pembayaran diwajibkan.
5. Pesanan expired atau canceled tidak boleh diproses.
6. Pre-Order tidak langsung masuk antrean reguler.
7. Penomoran harus aman terhadap pesanan yang dibuat bersamaan.

## 7.6 Manajemen Pre-Order

Tampilkan daftar Pre-Order berdasarkan tanggal dan waktu pengambilan.

Seller dapat:

- Melihat Pre-Order.
- Melihat detail.
- Memeriksa status pembayaran.
- Memeriksa jadwal.
- Memproses pesanan pada tahap yang diperbolehkan.

Pre-Order harus dibedakan secara visual dari waiting list reguler.

## 7.7 Kasir Walk-In

Buat modul kasir untuk pesanan langsung di toko.

Fitur:

- Memilih produk.
- Memasukkan jumlah.
- Melihat harga.
- Melihat total.
- Membuat pesanan walk-in.
- Menyimpan transaksi.
- Mendapatkan nomor antrean untuk Makanan Berat.
- Mencetak struk.

Pesanan walk-in harus menggunakan model pesanan dan sistem antrean yang sama dengan pesanan online.

Aturan status pembayaran walk-in harus konsisten dengan desain transaksi yang diterapkan.

## 7.8 Struk Fisik

Struk fisik menampilkan:

- Nama toko.
- Kode transaksi.
- Waktu transaksi.
- Daftar produk.
- Jumlah.
- Harga.
- Total.
- Status pembayaran jika relevan.
- Nomor antrean jika relevan.

Gunakan print stylesheet yang sederhana, mudah dibaca, dan mendukung printer standar atau thermal melalui browser.

## 7.9 Histori Transaksi Seller

Tampilkan histori transaksi milik toko sendiri.

Sediakan:

- Pencarian.
- Filter tanggal.
- Filter status.
- Detail transaksi.
- Informasi total.
- Status pembayaran.
- Tipe pemesanan.

Jangan menampilkan transaksi toko lain.

---

# 8. MODUL ADMIN

## 8.1 Dashboard Admin

Dashboard Admin menampilkan statistik global dari database.

Komponen:

- Total pengguna.
- Total Customer.
- Total Seller.
- Total toko.
- Total kategori.
- Total produk.
- Total pesanan.
- Total transaksi berhasil.
- Ringkasan pembayaran.
- Grafik transaksi.
- Grafik pesanan.
- Perbandingan Pesan Sekarang dan Pre-Order.
- Pesanan terbaru.
- Aktivitas administratif jika tersedia.

Perhitungan nilai transaksi berhasil hanya menggunakan transaksi yang statusnya sesuai definisi pembayaran berhasil.

Jangan menghitung pembayaran pending, failed, atau expired sebagai pendapatan berhasil.

Jika database belum memiliki data, tampilkan angka nol dan empty state yang sesuai.

## 8.2 Manajemen Pengguna

Fitur CRUD:

- Daftar pengguna.
- Tambah pengguna.
- Detail pengguna.
- Edit pengguna.
- Hapus atau nonaktifkan pengguna sesuai struktur aplikasi.
- Pencarian nama dan email.
- Filter role.
- Pagination.

Field mengikuti database:

- Nama.
- Email.
- Password jika pembuatan akun.
- Role.

Aturan:

- Email harus valid dan unik.
- Password harus di-hash.
- Role harus divalidasi.
- Registrasi publik tidak boleh membuat Admin.
- Admin tidak boleh menghapus dirinya sendiri secara tidak sengaja.
- Lindungi satu-satunya Admin aktif.
- Penghapusan pengguna tidak boleh merusak transaksi historis.

## 8.3 Manajemen Kategori

Fitur:

- Daftar kategori.
- Tambah kategori.
- Edit kategori.
- Hapus kategori jika aman.
- Pencarian.
- Pagination.

Kategori yang masih digunakan produk tidak boleh dihapus tanpa kebijakan yang menjaga integritas data.

## 8.4 Monitoring Toko

Admin dapat melihat:

- Nama toko.
- Pemilik/Seller.
- Jumlah produk jika tersedia.
- Informasi toko.
- Produk terkait.
- Status toko jika tersedia.

Admin memantau toko tanpa menggantikan Seller dalam operasional harian.

## 8.5 Monitoring Produk dan Stok

Tampilkan:

- Nama produk.
- Kategori.
- Tipe makanan.
- Harga.
- Stok.
- Status ketersediaan.
- Nama toko.
- Pemilik toko.

Sediakan pencarian dan filter berdasarkan toko, kategori, dan tipe makanan jika didukung data.

Perubahan stok rutin merupakan tanggung jawab Seller. Jika koreksi administratif disediakan, setiap perubahan harus diaudit.

## 8.6 Monitoring Pesanan

Tampilkan:

- Kode pesanan.
- Customer.
- Toko.
- Tanggal.
- Tipe pemesanan.
- Total.
- Status pesanan.
- Status pembayaran.

Fitur:

- Pencarian kode pesanan.
- Filter tanggal.
- Filter toko.
- Filter tipe pemesanan.
- Filter status pembayaran.
- Filter status pesanan.
- Pagination.
- Detail pesanan.

Admin tidak boleh mengubah status transaksi sembarangan tanpa validasi aturan bisnis.

## 8.7 Monitoring Pembayaran

Tampilkan:

- Kode pesanan.
- Metode pembayaran.
- Jumlah.
- Status pembayaran.
- Waktu transaksi.

Admin bertindak sebagai pengawas pembayaran simulasi.

Tidak perlu menambahkan verifikasi manual yang bertentangan dengan ketentuan sistem.

## 8.8 Monitoring Antrean

Tampilkan:

- Nomor antrean.
- Kode pesanan.
- Toko.
- Waktu masuk.
- Status antrean.

Pastikan antrean online dan walk-in untuk Makanan Berat menggunakan sistem terintegrasi.

Pre-Order tidak boleh otomatis masuk antrean reguler terlalu awal.

## 8.9 Histori Stok

Tampilkan:

- Produk.
- Toko.
- Actor.
- Jenis perubahan.
- Stok sebelum.
- Perubahan.
- Stok sesudah.
- Keterangan.
- Waktu perubahan.

Sediakan filter dan pencarian yang sesuai.

## 8.10 Laporan dan Analitik

Buat laporan berdasarkan data aktual:

- Jumlah pesanan.
- Nilai transaksi berhasil.
- Ringkasan status pembayaran.
- Perbandingan Pesan Sekarang dan Pre-Order.
- Produk yang sering dipesan jika data mendukung.
- Ringkasan transaksi per toko.
- Tren transaksi berdasarkan periode.

Jika ekspor CSV dibuat, file harus berisi data yang sesuai dengan filter yang dipilih.

## 8.11 Aktivitas Administratif

Jika modul aktivitas tersedia atau dibutuhkan, catat:

- Pengguna yang melakukan aksi.
- Jenis aksi.
- Entitas terkait.
- Ringkasan perubahan.
- Waktu aksi.

Jangan menyimpan password, token, atau secret dalam log.

Jangan menyatakan aktivitas bersifat real-time kecuali terdapat implementasi pembaruan langsung yang benar-benar berfungsi.

---

# 9. ATURAN BISNIS UTAMA

## 9.1 Perbedaan Makanan Berat dan Makanan Ringan

**Makanan Berat:**

- Menggunakan waiting list.
- Pesanan online dan walk-in masuk ke antrean terintegrasi.
- Pesanan harus memenuhi syarat pembayaran sebelum diproses jika pembayaran diwajibkan.

**Makanan Ringan:**

- Mengandalkan inventaris dan stok.
- Stok berkurang otomatis setelah pembayaran tervalidasi sesuai ketentuan proyek.
- Tidak menggunakan waiting list reguler jika aturan bisnis menetapkan mekanisme stok saja.

## 9.2 Pesan Sekarang

Pesanan dibuat untuk segera diproses sesuai kondisi operasional.

Pesanan hanya boleh diteruskan ke tahap pemrosesan setelah memenuhi ketentuan pembayaran dan ketersediaan.

## 9.3 Pre-Order

Pre-Order harus memiliki jadwal pengambilan yang valid.

Stok yang telah dialokasikan untuk Pre-Order tidak boleh dijual kembali sebagai stok bebas.

Pesanan yang belum dibayar, expired, atau canceled tidak boleh diproses.

## 9.4 Pembayaran

Pembayaran simulasi mendukung QRIS, E-Wallet, dan Virtual Account.

Status pembayaran harus konsisten antara database, Customer, Seller, dan Admin.

Pesanan paid tidak boleh mengalami pembayaran ganda.

## 9.5 Stok

- Stok tidak boleh negatif.
- Jumlah pesanan tidak boleh melebihi stok bebas.
- Pengurangan stok harus konsisten.
- Pengurangan stok tidak boleh terjadi dua kali akibat request berulang.
- Histori stok harus mencerminkan perubahan yang benar.

## 9.6 Antrean

- Online dan walk-in Makanan Berat memakai antrean terintegrasi.
- Nomor antrean harus unik sesuai lingkup yang ditetapkan.
- Pre-Order tidak langsung masuk antrean reguler.
- Pesanan tidak sah tidak boleh diproses.

## 9.7 Harga Historis

Harga pada detail pesanan harus disimpan sebagai snapshot transaksi.

Perubahan harga produk tidak boleh mengubah nilai transaksi lama.

---

# 10. DATABASE DAN RELASI

Bab database harus disesuaikan dengan SRS dan migration yang sudah ada.

Jangan membuat ulang tabel yang sudah tersedia.

## 10.1 Tabel Users

Menyimpan:

- ID.
- Nama.
- Email.
- Password hash.
- Role.
- Timestamps.

Role utama:

- `admin`
- `customer`
- `seller`

Gunakan nama tabel yang konsisten dengan repository. Jika proyek sudah memakai `users`, jangan membuat tabel `user` baru hanya karena perbedaan penamaan.

## 10.2 Tabel Toko

Menyimpan informasi toko dan relasinya dengan Seller.

Field yang dapat digunakan sesuai struktur:

- ID.
- User ID pemilik.
- Nama toko.
- Timestamps.

Kardinalitas Seller terhadap toko harus diverifikasi dari SRS dan repository.

## 10.3 Tabel Kategori

Menyimpan kategori produk.

Field:

- ID.
- Nama kategori.
- Timestamps.

## 10.4 Tabel Produk

Menyimpan:

- ID.
- Toko ID.
- Kategori ID.
- Nama produk.
- Deskripsi.
- Harga.
- Tipe makanan.
- Stok.
- Status ketersediaan jika tersedia.
- Timestamps.

## 10.5 Tabel Pesanan

Menyimpan:

- ID.
- User ID Customer.
- Toko ID.
- Kode pesanan.
- Tipe pemesanan.
- Status pesanan.
- Total harga.
- Jadwal pengambilan jika Pre-Order.
- Sumber pesanan online/walk-in jika dibutuhkan.
- Timestamps.

## 10.6 Tabel Detail Pesanan

Menyimpan:

- ID.
- Pesanan ID.
- Produk ID.
- Jumlah.
- Harga saat transaksi.
- Subtotal.
- Timestamps.

Harga satuan dan subtotal harus menjadi snapshot transaksi.

## 10.7 Tabel Pembayaran

Menyimpan:

- ID.
- Pesanan ID.
- Metode pembayaran.
- Status pembayaran.
- Jumlah pembayaran.
- Timestamps.

Relasi dan batasan jumlah pembayaran per pesanan harus disesuaikan dengan desain yang telah diterapkan.

## 10.8 Tabel Antrean

Menyimpan:

- ID.
- Pesanan ID.
- Nomor antrean.
- Status antrean.
- Timestamps.

Nomor antrean harus mempunyai aturan keunikan yang jelas.

## 10.9 Tabel Histori Stok

Menyimpan:

- ID.
- Produk ID.
- User ID actor jika tersedia.
- Jenis perubahan.
- Stok sebelum.
- Jumlah perubahan.
- Stok sesudah.
- Keterangan.
- Timestamps.

## 10.10 Relasi

Relasi utama:

- User memiliki relasi dengan toko sesuai kardinalitas aktual.
- Customer memiliki banyak pesanan.
- Toko memiliki banyak produk.
- Toko memiliki banyak pesanan.
- Kategori memiliki banyak produk.
- Produk terkait dengan satu toko dan satu kategori.
- Pesanan memiliki banyak detail pesanan.
- Detail pesanan terkait dengan produk.
- Pesanan terkait dengan pembayaran sesuai desain.
- Pesanan terkait dengan antrean jika memenuhi syarat.
- Produk memiliki banyak histori stok.
- User dapat menjadi actor perubahan stok.

Gunakan foreign key, indeks, dan constraint sesuai kebutuhan.

Hindari penghapusan cascade yang dapat menghapus transaksi historis secara tidak sengaja.

---

# 11. STRUKTUR NAVIGASI

Nama route akhir harus mengikuti konvensi repository.

## 11.1 Halaman Publik

- Home.
- Katalog.
- Kategori.
- Detail produk.
- Login.
- Register.

## 11.2 Customer

- Dashboard.
- Cart.
- Checkout.
- Pembayaran.
- Status pembayaran.
- Riwayat pesanan.
- Detail pesanan.
- Struk digital.
- Profil jika tersedia.

## 11.3 Seller

- Dashboard.
- Manajemen produk.
- Tambah produk.
- Edit produk.
- Detail produk.
- Manajemen stok.
- Histori stok.
- Daftar pesanan.
- Detail pesanan.
- Waiting list.
- Pre-Order.
- Kasir walk-in.
- Cetak struk.
- Histori transaksi.

## 11.4 Admin

- Dashboard.
- Manajemen pengguna.
- Tambah pengguna.
- Edit pengguna.
- Detail pengguna.
- Manajemen kategori.
- Monitoring toko.
- Monitoring produk.
- Monitoring stok.
- Monitoring pesanan.
- Monitoring pembayaran.
- Monitoring antrean.
- Histori stok.
- Laporan.
- Aktivitas administratif jika tersedia.

Setiap route harus menerapkan autentikasi dan otorisasi yang sesuai.

---

# 12. UI/UX DAN DESIGN SYSTEM

## 12.1 Referensi Desain

Gunakan gambar dashboard food ordering yang diberikan sebagai acuan utama untuk panel Admin.

Karakteristik:

- Sidebar di sebelah kiri.
- Header di bagian atas.
- Area konten utama.
- Kartu statistik.
- Panel informasi.
- Tabel data.
- Background terang.
- Aksen coral atau salmon.
- Radius lembut.
- Shadow tipis.
- Tata letak rapi dan modern.

Gambar storefront digunakan sebagai inspirasi tambahan untuk komposisi, whitespace, hero section, dan grid produk.

Gunakan identitas FoodOrder. Jangan menggunakan nama merek dari gambar referensi.

## 12.2 Warna

Gunakan palet yang konsisten:

- Background utama: off-white atau abu-abu sangat muda.
- Surface/card: putih.
- Primary: coral atau salmon.
- Teks utama: abu-abu gelap.
- Teks sekunder: abu-abu.
- Success: hijau.
- Warning: kuning atau amber.
- Danger: merah.

Pastikan kontras teks cukup jelas.

## 12.3 Komponen UI

Gunakan komponen yang konsisten:

- Navbar.
- Sidebar.
- Topbar.
- Breadcrumb.
- Page heading.
- Stat card.
- Button.
- Form input.
- Select.
- Search bar.
- Table.
- Pagination.
- Status badge.
- Alert.
- Modal konfirmasi.
- Empty state.
- Error state.
- Loading state jika diperlukan.
- Print stylesheet.

## 12.4 Dashboard Admin

Dashboard harus memiliki hierarki visual yang jelas.

Gunakan:

- Kartu statistik.
- Grafik jika relevan.
- Tabel pesanan terbaru.
- Ringkasan transaksi.
- Filter periode jika tersedia.
- Sidebar navigasi.
- Profil pengguna di header.

Hindari tabel yang terlalu padat dan grafik yang saling bertumpuk.

## 12.5 Dashboard Seller

Prioritaskan operasional:

- Pesanan masuk.
- Waiting list.
- Pre-Order.
- Status pesanan.
- Informasi stok.
- Akses kasir.
- Aksi pemrosesan yang mudah ditemukan.

## 12.6 Halaman Customer

Prioritaskan:

- Katalog yang mudah dijelajahi.
- Kartu produk yang jelas.
- Harga dan stok.
- Keranjang yang mudah diakses.
- Checkout sederhana.
- Pemilihan mode pemesanan.
- Informasi pembayaran.
- Status pesanan.
- Riwayat dan struk.

## 12.7 Responsivitas

Aplikasi harus dapat digunakan pada:

- Desktop.
- Laptop.
- Tablet.
- Mobile.

Sidebar dapat berubah menjadi drawer pada layar kecil.

Tabel harus tetap terbaca melalui penyesuaian layout atau horizontal scrolling yang sesuai.

## 12.8 Aset

Gunakan aset lokal yang tersedia di repository.

Jika gambar produk belum tersedia, gunakan placeholder yang konsisten dan rapi.

Jangan menggunakan URL gambar acak yang mudah rusak.

---

# 13. KEAMANAN

Terapkan:

1. Validasi input di server.
2. CSRF protection.
3. Escape output untuk mencegah XSS.
4. Eloquent atau parameter binding untuk query database.
5. Password hashing.
6. Authentication middleware.
7. Role-based authorization.
8. Ownership validation untuk toko, produk, dan pesanan.
9. Validasi upload jika upload gambar diterapkan.
10. Validasi harga dan total dari database.
11. Perlindungan pembayaran ganda.
12. Perlindungan stok negatif.
13. Transaksi database untuk proses kritis.
14. Penyimpanan secret melalui environment.
15. Pembatasan akses route sensitif.
16. Pencegahan manipulasi status dari frontend.
17. Pencegahan akses data lintas Customer dan Seller.
18. Pengamanan aktivitas penghapusan data.

Jangan menonaktifkan proteksi keamanan hanya untuk mengatasi error.

---

# 14. INTEGRITAS TRANSAKSI

## 14.1 Checkout

Checkout harus memastikan stok dan harga masih valid.

Jika salah satu proses gagal, perubahan terkait harus di-rollback.

## 14.2 Pembayaran

Pembayaran harus idempotent.

Request berulang tidak boleh menyebabkan:

- Pembayaran ganda.
- Pengurangan stok ganda.
- Pembuatan antrean ganda.
- Pembuatan struk dengan nilai yang berbeda.

## 14.3 Pre-Order

Alokasi stok harus diperhitungkan saat menentukan stok bebas.

Pembatalan atau expired harus melepaskan alokasi paling banyak satu kali.

## 14.4 Antrean

Pembuatan nomor antrean harus aman ketika beberapa pesanan masuk secara bersamaan.

## 14.5 Histori Stok

Catat perubahan stok hanya berdasarkan perubahan yang benar-benar berhasil.

Stok sebelum, jumlah perubahan, dan stok sesudah harus konsisten.

## 14.6 Data Historis

Perubahan produk tidak boleh mengubah detail transaksi lama.

Jangan menghapus transaksi historis hanya karena produk atau pengguna dinonaktifkan.

---

# 15. VALIDASI DATA

Minimal, terapkan validasi berikut:

- Email valid dan unik.
- Role hanya nilai yang diperbolehkan.
- Nama kategori wajib.
- Nama produk wajib.
- Harga tidak negatif.
- Stok tidak negatif.
- Jumlah pesanan minimal satu.
- Jumlah tidak melebihi stok bebas.
- Produk dan kategori harus tersedia.
- Seller hanya dapat mengubah produk milik tokonya.
- Customer hanya dapat mengakses pesanan miliknya.
- Jadwal Pre-Order harus valid.
- Metode pembayaran hanya nilai yang diizinkan.
- Total dihitung di server.
- Cart kosong tidak dapat di-checkout.
- Pesanan expired tidak dapat diproses.
- Pesanan paid tidak dapat dibayar ulang.
- Status transaksi hanya dapat berubah melalui transisi yang sah.

---

# 16. TESTING DAN QUALITY ASSURANCE

Gunakan PHPUnit atau Pest sesuai dependency yang tersedia.

## 16.1 Authentication

Uji:

- Login berhasil.
- Login gagal.
- Registrasi berhasil.
- Email duplikat ditolak.
- Password di-hash.
- Logout berhasil.
- Redirect role benar.

## 16.2 Authorization

Uji:

- Guest ditolak dari halaman privat.
- Customer ditolak dari dashboard Admin.
- Customer ditolak dari dashboard Seller.
- Seller ditolak dari dashboard Admin.
- Seller tidak dapat mengakses toko lain.
- Customer tidak dapat mengakses pesanan orang lain.

## 16.3 CRUD

Uji:

- CRUD pengguna.
- CRUD kategori.
- CRUD produk.
- Validasi input.
- Pencegahan penghapusan data yang masih direferensikan.
- Pencarian.
- Filter.
- Pagination.

## 16.4 Cart dan Checkout

Uji:

- Cart kosong.
- Jumlah tidak valid.
- Stok tidak cukup.
- Harga berubah sebelum checkout.
- Checkout berhasil.
- Checkout gagal.
- Request checkout berulang.
- Validasi toko.

## 16.5 Pembayaran

Uji:

- Pembayaran berhasil.
- Pembayaran gagal jika didukung.
- Pembayaran expired.
- Pembayaran berulang.
- Akses pembayaran lintas pengguna.
- Konsistensi status pembayaran dan pesanan.

## 16.6 Stok

Uji:

- Stok berkurang sesuai aturan.
- Stok tidak negatif.
- Restock berhasil.
- Histori stok benar.
- Pengurangan stok tidak terjadi dua kali.
- Alokasi Pre-Order benar.
- Alokasi stok dilepas secara konsisten.

## 16.7 Antrean

Uji:

- Pesanan Makanan Berat online.
- Pesanan Makanan Berat walk-in.
- Antrean terintegrasi.
- Nomor antrean tidak bentrok.
- Pre-Order tidak masuk antrean reguler terlalu awal.
- Pesanan belum dibayar tidak diproses.

## 16.8 UI

Uji:

- Semua navigasi bekerja.
- Tombol berfungsi.
- Validasi tampil.
- Pesan sukses dan error tampil.
- Empty state bekerja.
- Layout responsif.
- Struk dapat dicetak.

Jangan menyatakan test berhasil jika belum benar-benar dijalankan.

---

# 17. SEEDER DAN DATA DEVELOPMENT

Jika diperlukan, sediakan seeder untuk:

- Akun Admin.
- Akun Seller.
- Akun Customer.
- Toko.
- Kategori.
- Produk Makanan Berat.
- Produk Makanan Ringan.
- Contoh pesanan.

Ketentuan:

- Password harus di-hash.
- Data demo hanya untuk development.
- Seeder sebaiknya tidak membuat duplikasi ketika dijalankan kembali.
- Kredensial development harus didokumentasikan.
- Jangan menggunakan kredensial development untuk produksi.

---

# 18. README DAN INSTALASI

Perbarui README proyek agar menjelaskan:

1. Deskripsi FoodOrder.
2. Fitur utama.
3. Teknologi.
4. Persyaratan PHP, Laravel, Composer, dan MySQL.
5. Cara menyiapkan environment.
6. Cara mengatur `.env`.
7. Cara membuat database.
8. Cara memasang dependency.
9. Cara menjalankan migration.
10. Cara menjalankan seeder.
11. Cara menjalankan aplikasi.
12. Cara menjalankan test.
13. Akun development jika tersedia.
14. Storage link jika upload gambar digunakan.
15. Scheduler untuk expiration jika diterapkan.
16. Troubleshooting umum.

Jangan menuliskan kredensial produksi ke README.

---

# 19. KEPUTUSAN YANG HARUS DIVERIFIKASI

Sebelum implementasi, periksa repository dan SRS untuk memastikan:

1. Versi Laravel dan PHP.
2. Nama tabel aktual.
3. Relasi Seller dengan toko.
4. Status pesanan yang telah digunakan.
5. Status pembayaran.
6. Batas waktu pembayaran.
7. Mekanisme jadwal Pre-Order.
8. Jam operasional toko jika diperlukan.
9. Mekanisme pembayaran walk-in.
10. Upload gambar.
11. Activity log.
12. Ekspor CSV.
13. Soft delete atau penghapusan data.
14. Penyimpanan cart.
15. Lingkup penomoran antrean.

Jangan menganggap keputusan tersebut sudah ditetapkan oleh SRS jika memang tidak tertulis di dalamnya.

Jika ada kebutuhan yang belum jelas, pilih solusi paling sederhana, aman, dan konsisten dengan repository. Dokumentasikan keputusan tersebut.

---

# 20. TAHAPAN IMPLEMENTASI

Implementasikan proyek secara bertahap, tetapi tetap selesaikan keseluruhan aplikasi.

### Tahap 1 — Audit

- Periksa repository.
- Periksa database.
- Periksa routes.
- Periksa models dan controllers.
- Periksa views.
- Identifikasi fitur yang belum selesai.

### Tahap 2 — Fondasi

- Autentikasi.
- Role.
- Middleware.
- Model.
- Relasi database.
- Migration.
- Layout utama.

### Tahap 3 — Halaman Publik

- Landing page.
- Katalog.
- Kategori.
- Detail produk.
- Login.
- Register.

### Tahap 4 — Customer

- Dashboard.
- Cart.
- Checkout.
- Pesan Sekarang.
- Pre-Order.
- Pembayaran simulasi.
- Riwayat pesanan.
- Struk digital.

### Tahap 5 — Seller

- Dashboard.
- CRUD produk.
- Pengelolaan stok.
- Histori stok.
- Daftar pesanan.
- Waiting list.
- Pre-Order.
- Kasir walk-in.
- Cetak struk.

### Tahap 6 — Admin

- Dashboard statistik.
- Manajemen pengguna.
- Manajemen kategori.
- Monitoring toko.
- Monitoring produk dan stok.
- Monitoring pesanan.
- Monitoring pembayaran.
- Monitoring antrean.
- Histori stok.
- Laporan.

### Tahap 7 — Integrasi

- Integrasi pembayaran dengan status pesanan.
- Integrasi stok dengan transaksi.
- Integrasi antrean online dan walk-in.
- Integrasi Pre-Order dengan alokasi stok.
- Integrasi struk dengan transaksi.

### Tahap 8 — QA

- Pengujian semua role.
- Pengujian validasi.
- Pengujian keamanan.
- Pengujian konsistensi transaksi.
- Pengujian responsivitas.
- Perbaikan bug.

### Tahap 9 — Dokumentasi

- Perbarui README.
- Dokumentasikan route.
- Dokumentasikan migration.
- Dokumentasikan akun development.
- Dokumentasikan hasil testing.

---

# 21. KRITERIA PENERIMAAN

Proyek dianggap memenuhi spesifikasi jika:

## Umum

- Aplikasi dapat dijalankan sesuai dokumentasi.
- Database dapat dibangun melalui migration.
- Role memiliki hak akses yang benar.
- Frontend terhubung dengan backend.
- Tidak ada tombol utama yang hanya menjadi dekorasi.
- UI konsisten dan responsif.

## Customer

- Customer dapat melihat produk.
- Customer dapat menggunakan keranjang.
- Customer dapat checkout.
- Customer dapat memilih Pesan Sekarang.
- Customer dapat memilih Pre-Order.
- Customer dapat membayar melalui simulasi.
- Customer dapat melihat status pesanan.
- Customer dapat melihat riwayat.
- Customer dapat melihat struk miliknya.

## Seller

- Seller dapat mengelola produk.
- Seller dapat mengelola stok.
- Seller dapat melihat pesanan.
- Seller dapat melihat waiting list.
- Seller dapat mengelola Pre-Order.
- Seller dapat membuat pesanan walk-in.
- Seller dapat mencetak struk.
- Seller tidak dapat mengakses data toko lain.

## Admin

- Dashboard menggunakan data database.
- CRUD pengguna berfungsi.
- CRUD kategori berfungsi.
- Monitoring toko tersedia.
- Monitoring produk dan stok tersedia.
- Monitoring pesanan tersedia.
- Monitoring pembayaran tersedia.
- Monitoring antrean tersedia.
- Histori stok tersedia.
- Laporan menggunakan perhitungan yang benar.

## Aturan Bisnis

- Makanan Berat menggunakan waiting list.
- Makanan Ringan mengikuti mekanisme stok.
- Pre-Order mengikuti jadwal dan alokasi stok.
- Pesanan belum dibayar tidak dapat diproses.
- Pesanan expired tidak dapat diproses.
- Pesanan paid tidak dapat dibayar ulang.
- Stok tidak boleh negatif.
- Antrean online dan walk-in terintegrasi.
- Struk online tersedia setelah pembayaran berhasil.

---


Bertindak sebagai Senior Full-Stack Laravel Developer, Database Engineer, UI/UX Engineer, dan QA Engineer.

Baca seluruh isi file `FOODORDER_PROJECT_SPEC.md` dan implementasikan aplikasi FoodOrder secara menyeluruh berdasarkan spesifikasi tersebut.

**PENTING: Jangan hanya mengerjakan dashboard Admin. Implementasikan seluruh aplikasi, termasuk halaman publik, autentikasi, Customer, Seller, Admin, katalog, produk, keranjang, checkout, Pesan Sekarang, Pre-Order, pembayaran simulasi, stok, waiting list, kasir walk-in, antrean, struk, riwayat pesanan, monitoring, dan laporan.**

Sebelum coding:

1. Audit struktur repository.
2. Periksa versi Laravel dan PHP.
3. Periksa migration, model, controller, route, middleware, view, asset, dan konfigurasi database.
4. Identifikasi fitur yang sudah berfungsi.
5. Identifikasi fitur yang belum selesai.
6. Pertahankan kode yang benar.
7. Hindari membuat tabel atau fitur duplikat.
8. Cocokkan kebutuhan dengan SRS dan struktur database aktual.

Saat implementasi:

1. Gunakan arsitektur MVC yang konsisten.
2. Buat backend dan frontend yang terintegrasi.
3. Implementasikan autentikasi dan otorisasi setiap role.
4. Terapkan validasi input di server.
5. Implementasikan seluruh CRUD yang diperlukan.
6. Implementasikan seluruh alur bisnis Customer.
7. Implementasikan seluruh alur operasional Seller.
8. Implementasikan seluruh modul Admin.
9. Integrasikan pembayaran, stok, Pre-Order, dan antrean.
10. Terapkan database transaction dan idempotensi untuk proses kritis.
11. Pastikan Customer hanya mengakses transaksi miliknya.
12. Pastikan Seller hanya mengakses data toko miliknya.
13. Pastikan Admin memiliki akses monitoring global sesuai ketentuan.
14. Terapkan desain UI berdasarkan referensi visual.
15. Buat tampilan responsif.
16. Pastikan seluruh tombol dan form benar-benar berfungsi.
17. Jangan menggunakan data statis untuk menggantikan fitur database.
18. Jangan mengarang fitur yang tidak didukung SRS tanpa mendokumentasikan keputusan.
19. Jangan menghapus data atau melakukan perubahan destruktif tanpa memeriksa dampaknya.
20. Jangan berhenti setelah membuat mockup, layout, atau rencana implementasi.

Setelah implementasi:

1. Periksa seluruh route.
2. Jalankan migration yang sesuai.
3. Jalankan test yang tersedia.
4. Periksa autentikasi dan otorisasi.
5. Periksa checkout, pembayaran, stok, antrean, dan Pre-Order.
6. Periksa tampilan pada desktop dan mobile.
7. Perbaiki bug yang ditemukan.
8. Perbarui README.
9. Laporkan file yang dibuat dan diubah.
10. Laporkan migration yang ditambahkan.
11. Laporkan fitur yang benar-benar selesai.
12. Berikan langkah menjalankan aplikasi.
13. Laporkan hasil testing yang benar-benar dijalankan.
14. Jelaskan fitur yang belum selesai beserta penyebabnya.

Jika ada masalah lingkungan atau dependency, jelaskan kendalanya secara spesifik dan lanjutkan mengerjakan bagian lain yang tidak terblokir.

**Target akhir: aplikasi FoodOrder yang berfungsi secara end-to-end untuk Guest, Customer, Seller, dan Admin, dengan backend Laravel, database yang konsisten, aturan bisnis yang benar, UI modern berdasarkan referensi, keamanan yang memadai, dan dokumentasi instalasi yang lengkap.**

Jangan hanya memberikan tutorial atau potongan kode. Kerjakan implementasi nyata di repository.
