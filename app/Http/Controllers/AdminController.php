<?php

namespace App\Http\Controllers;

use App\Models\{User, Toko, Kategori, Produk, Pesanan, Pembayaran, Antrian, HistoriStok};
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $r)
    {
        $d = $r->validate(['from' => 'nullable|date|before_or_equal:to', 'to' => 'nullable|date|after_or_equal:from']);
        $from = $d['from'] ?? null; $to = $d['to'] ?? null;
        $period = fn ($q) => $q->when($from, fn ($x) => $x->whereDate('created_at', '>=', $from))->when($to, fn ($x) => $x->whereDate('created_at', '<=', $to));

        return view('admin.dashboard', [
            'users' => $period(User::query())->count(), 'stores' => $period(Toko::query())->count(), 'categories' => $period(Kategori::query())->count(),
            'products' => $period(Produk::query())->count(), 'orders' => $period(Pesanan::query())->count(),
            'paid' => $period(Pembayaran::query())->where('status', 'sudah dibayar')->count(),
            'recent' => $period(Pesanan::with(['user', 'toko', 'pembayaran']))->latest()->take(8)->get(), 'from' => $from, 'to' => $to,
            'orderStats' => $period(Pesanan::query())->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status'),
            'paymentStats' => $period(Pembayaran::query())->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status'),
        ]);
    }

    public function users(Request $r)
    {
        $q = User::query()
            ->when($r->q, fn($x, $v) => $x->where(fn($y) => $y->where('nama', 'like', "%$v%")->orWhere('email', 'like', "%$v%")))
            ->when($r->role, fn($x, $v) => $x->where('role', $v));

        return view('admin.index', [
            'title' => 'Pengguna',
            'type' => 'users',
            'items' => $q->latest()->paginate(10)->withQueryString(),
        ]);
    }

    public function userCreate()
    {
        return view('admin.form', ['title' => 'Pengguna', 'type' => 'users', 'item' => new User]);
    }

    public function userStore(Request $r)
    {
        $d = $r->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,seller,customer',
        ]);
        User::create($d);
        return redirect()->route('admin.users')->with('ok', 'Pengguna berhasil ditambahkan.');
    }

    public function userEdit(User $user)
    {
        return view('admin.form', ['title' => 'Pengguna', 'type' => 'users', 'item' => $user]);
    }

    public function userUpdate(Request $r, User $user)
    {
        $d = $r->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:user,email,' . $user->id,
            'password' => 'nullable|min:8',
            'role' => 'required|in:admin,seller,customer',
        ]);
        abort_if($user->role === 'admin' && $d['role'] !== 'admin' && User::where('role', 'admin')->count() <= 1, 422, 'Admin aktif terakhir tidak boleh kehilangan akses.');
        abort_if($user->id === auth()->id() && $d['role'] !== 'admin', 422, 'Akun yang sedang digunakan harus tetap menjadi Admin.');
        if (empty($d['password'])) {
            unset($d['password']);
        }
        $user->update($d);
        return redirect()->route('admin.users')->with('ok', 'Pengguna diperbarui.');
    }

    public function userDestroy(User $user)
    {
        abort_if($user->id === auth()->id() || ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1), 422, 'Admin aktif terakhir tidak boleh dihapus.');
        abort_if($user->toko()->exists() || $user->pesanan()->exists() || $user->historiStok()->exists(), 422, 'Pengguna masih memiliki data terkait dan tidak dapat dihapus.');
        $user->delete();
        return back()->with('ok', 'Pengguna dihapus.');
    }

    public function categories(Request $r)
    {
        $q = Kategori::query()->when($r->q, fn($x, $v) => $x->where('nama_kategori', 'like', "%$v%"));
        return view('admin.index', [
            'title' => 'Kategori',
            'type' => 'categories',
            'items' => $q->withCount('produk')->latest()->paginate(10)->withQueryString(),
        ]);
    }

    public function categoryCreate()
    {
        return view('admin.form', ['title' => 'Kategori', 'type' => 'categories', 'item' => new Kategori]);
    }

    public function categoryStore(Request $r)
    {
        $d = $r->validate(['nama_kategori' => 'required|max:255|unique:kategori,nama_kategori']);
        Kategori::create($d);
        return redirect()->route('admin.categories')->with('ok', 'Kategori berhasil ditambahkan.');
    }

    public function categoryEdit(Kategori $category)
    {
        return view('admin.form', ['title' => 'Kategori', 'type' => 'categories', 'item' => $category]);
    }

    public function categoryUpdate(Request $r, Kategori $category)
    {
        $d = $r->validate(['nama_kategori' => 'required|max:255|unique:kategori,nama_kategori,' . $category->id]);
        $category->update($d);
        return redirect()->route('admin.categories')->with('ok', 'Kategori diperbarui.');
    }

    public function categoryDestroy(Kategori $category)
    {
        abort_if($category->produk()->exists(), 422, 'Kategori masih digunakan produk.');
        $category->delete();
        return back()->with('ok', 'Kategori dihapus.');
    }

    public function resource(Request $r, ?string $type = null)
    {
        $type = $type ?? $r->segment(2);
        $dateFilter = fn ($q) => $q->when($r->filled('from'), fn ($x) => $x->whereDate('created_at', '>=', $r->input('from')))->when($r->filled('to'), fn ($x) => $x->whereDate('created_at', '<=', $r->input('to')));

        switch ($type) {
            case 'stores':
                $items = Toko::with('user')->withCount('produk')->latest()->paginate(15)->withQueryString();
                $title = 'Daftar Toko & Restoran';
                break;
            case 'products':
                $items = Produk::with(['toko', 'kategori'])->latest()->paginate(15)->withQueryString();
                $title = 'Daftar Menu & Produk';
                break;
            case 'orders':
                $items = $dateFilter(Pesanan::with(['user', 'toko', 'pembayaran', 'antrian']))->when($r->filled('status'), fn ($q) => $q->where('status', $r->input('status')))->latest()->paginate(15)->withQueryString();
                $title = 'Daftar Pesanan Masuk';
                break;
            case 'payments':
                $items = $dateFilter(Pembayaran::with('pesanan.toko'))->when($r->filled('status'), fn ($q) => $q->where('status', $r->input('status')))->latest()->paginate(15)->withQueryString();
                $title = 'Riwayat Transaksi & Pembayaran';
                break;
            case 'queues':
                $items = $dateFilter(Antrian::with(['pesanan.toko', 'pesanan.user']))->when($r->filled('status'), fn ($q) => $q->where('status', $r->input('status')))->latest()->paginate(15)->withQueryString();
                $title = 'Daftar Antrean Pesanan';
                break;
            case 'stock-history':
                $items = HistoriStok::with(['produk.toko', 'user'])->latest()->paginate(15)->withQueryString();
                $title = 'Riwayat Mutasi Stok';
                break;
            default:
                abort(404);
        }

        return view('admin.resource', compact('type', 'title', 'items'));
    }
}
