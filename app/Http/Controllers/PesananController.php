<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar riwayat pesanan customer yang login.
     */
    public function index(Request $request)
    {
        $this->authorizeCustomer();

        $pesanan = Pesanan::with(['detailPesanan.produk.toko'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('customer.pesanan.index', compact('pesanan'));
    }

    /**
     * Menampilkan daftar menu produk untuk customer.
     */
    public function menu(Request $request)
    {
        $query = Produk::with(['toko', 'kategori'])
            ->where('in_stock', true)
            ->where('stok', '>', 0)
            ->orderBy('nama_produk');

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($products) use ($search) {
                $products->where('nama_produk', 'like', "%{$search}%")
                    ->orWhereHas('toko', fn ($stores) => $stores->where('nama_toko', 'like', "%{$search}%"))
                    ->orWhereHas('kategori', fn ($categories) => $categories->where('nama_kategori', 'like', "%{$search}%"));
            });
        }

        if ($kategoriId = $request->input('kategori')) {
            $query->where('kategori_id', $kategoriId);
        }

        $produk = $query->paginate(12)->withQueryString();
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('customer.menu.index', compact('produk', 'kategori'));
    }

    public function detailToko(string $toko)
    {
        $toko = Toko::with(['produk' => fn ($query) => $query
                ->with('kategori')
                ->where('in_stock', true)
                ->where('stok', '>', 0)
                ->orderBy('nama_produk')])
            ->findOrFail($toko);

        return view('customer.toko.show', compact('toko'));
    }

    public function detailMenu(string $produk)
    {
        $produk = Produk::with(['toko', 'kategori'])
            ->where('in_stock', true)
            ->where('stok', '>', 0)
            ->findOrFail($produk);

        return view('customer.menu.show', compact('produk'));
    }

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'produk_id' => 'required|integer|exists:produk,id',
            'jumlah' => 'required|integer|min:1',
        ]);
        $produk = Produk::findOrFail($validated['produk_id']);

        if (!$produk->in_stock || $validated['jumlah'] > $produk->stok) {
            return back()->withErrors(['cart' => 'Jumlah yang dipilih melebihi stok yang tersedia.']);
        }

        $cart = $request->session()->get('customer_cart', ['toko_id' => null, 'items' => []]);
        if (!empty($cart['items']) && (int) $cart['toko_id'] !== (int) $produk->toko_id) {
            return back()->withErrors(['cart' => 'Selesaikan atau kosongkan keranjang dari toko lain terlebih dahulu.']);
        }

        $existingQuantity = (int) ($cart['items'][$produk->id] ?? 0);
        if ($existingQuantity + (int) $validated['jumlah'] > $produk->stok) {
            return back()->withErrors(['cart' => 'Jumlah di keranjang melebihi stok yang tersedia.']);
        }

        $cart['toko_id'] = $produk->toko_id;
        $cart['items'][$produk->id] = $existingQuantity + (int) $validated['jumlah'];
        $request->session()->put('customer_cart', $cart);

        return redirect()->route('customer.pesanan.checkout')->with('success', 'Menu ditambahkan ke keranjang.');
    }

    public function updateCart(Request $request, Produk $produk)
    {
        $validated = $request->validate(['jumlah' => 'required|integer|min:1']);
        $cart = $request->session()->get('customer_cart', ['toko_id' => null, 'items' => []]);

        if (!array_key_exists($produk->id, $cart['items'] ?? [])) {
            return back()->withErrors(['cart' => 'Menu tersebut tidak ada di keranjang.']);
        }
        if (!$produk->in_stock || $validated['jumlah'] > $produk->stok) {
            return back()->withErrors(['cart' => 'Jumlah yang dipilih melebihi stok yang tersedia.']);
        }

        $cart['items'][$produk->id] = (int) $validated['jumlah'];
        $request->session()->put('customer_cart', $cart);

        return redirect()->route('customer.pesanan.checkout')->with('success', 'Jumlah menu diperbarui.');
    }

    public function removeFromCart(Request $request, Produk $produk)
    {
        $cart = $request->session()->get('customer_cart', ['toko_id' => null, 'items' => []]);
        if (!array_key_exists($produk->id, $cart['items'] ?? [])) {
            return back()->withErrors(['cart' => 'Menu tersebut tidak ada di keranjang.']);
        }

        unset($cart['items'][$produk->id]);
        if (empty($cart['items'])) {
            $request->session()->forget('customer_cart');
        } else {
            $request->session()->put('customer_cart', $cart);
        }

        return redirect()->route('customer.pesanan.checkout')->with('success', 'Menu dihapus dari keranjang.');
    }

    /**
     * Menampilkan halaman checkout untuk konfirmasi pesanan.
     */
    public function checkout(Request $request)
    {
        $items = [];
        $totalHarga = 0;
        $cart = $request->session()->get('customer_cart', ['toko_id' => null, 'items' => []]);
        $produk = Produk::with('toko')->whereIn('id', array_keys($cart['items'] ?? []))->get()->keyBy('id');
        $cartHasUnavailable = false;

        foreach ($cart['items'] ?? [] as $produkId => $jumlah) {
            $itemProduk = $produk->get($produkId);
            $tersedia = $itemProduk
                && $itemProduk->in_stock
                && (int) $jumlah <= (int) $itemProduk->stok
                && (int) $itemProduk->toko_id === (int) ($cart['toko_id'] ?? 0);
            $cartHasUnavailable = $cartHasUnavailable || !$tersedia;
            $hargaSatuan = $itemProduk ? (float) $itemProduk->harga : 0;
            $subtotal = $hargaSatuan * (int) $jumlah;
            $totalHarga += $subtotal;

            $items[] = [
                'produk_id' => (int) $produkId,
                'nama_produk' => $itemProduk?->nama_produk ?? 'Menu tidak tersedia',
                'gambar' => $itemProduk?->gambar,
                'jumlah' => (int) $jumlah,
                'harga_satuan' => $hargaSatuan,
                'subtotal' => $subtotal,
                'tersedia' => $tersedia,
            ];
        }

        $tokoId = $cart['toko_id'] ?? null;
        $toko = $tokoId ? Toko::find($tokoId) : null;
        if (!empty($items) && !$toko) {
            $cartHasUnavailable = true;
        }

        return view('customer.pesanan.checkout', compact('items', 'toko', 'tokoId', 'totalHarga', 'cartHasUnavailable'));
    }

    /**
     * Membuat pesanan baru untuk customer yang login.
     */
    public function store(Request $request)
    {
        $this->authorizeCustomer();

        $request->validate([
            'toko_id'      => 'required|integer|exists:toko,id',
            'tipe_pesanan' => 'sometimes|in:walk-in,online',
            'items'        => 'required|array|min:1',
            'items.*.produk_id' => 'required|integer|exists:produk,id',
            'items.*.jumlah'    => 'required|integer|min:1',
        ]);

        $user     = auth()->user();
        $tokoId   = $request->toko_id;
        $tipe     = $request->input('tipe_pesanan', 'online');

        $toko = Toko::find($tokoId);
        if (!$toko) {
            return back()->withErrors(['toko_id' => 'Toko tidak ditemukan.'])->withInput();
        }

        $items     = [];
        $totalHarga = 0;

        foreach ($request->items as $item) {
            $produk = Produk::find($item['produk_id']);

            if (!$produk) {
                return back()->withErrors([
                    'items' => 'Produk tidak ditemukan.'
                ])->withInput();
            }

            // Pastikan produk milik toko yang dipilih
            if ((int) $produk->toko_id !== (int) $toko->id) {
                return back()->withErrors([
                    'items' => 'Produk "' . $produk->nama_produk . '" tidak milik toko ini.'
                ])->withInput();
            }

            // Pastikan produk tersedia dan stok cukup
            if (!$produk->in_stock) {
                return back()->withErrors([
                    'items' => 'Produk "' . $produk->nama_produk . '" saat ini tidak tersedia.'
                ])->withInput();
            }

            if ((int) $produk->stok < (int) $item['jumlah']) {
                return back()->withErrors([
                    'items' => 'Stok "' . $produk->nama_produk . '" tidak cukup (tersedia: ' . $produk->stok . ').'
                ])->withInput();
            }

            // Ambil harga dari database, tidak dipercaya dari frontend
            $hargaSatuan = (float) $produk->harga;
            $subtotal    = $hargaSatuan * (int) $item['jumlah'];
            $totalHarga  += $subtotal;

            $items[] = [
                'produk_id'   => $produk->id,
                'jumlah'      => (int) $item['jumlah'],
                'harga_satuan'=> $hargaSatuan,
                'total_harga' => $subtotal,
            ];
        }

        // Generate kode pesanan unik
        do {
            $kodePesanan = 'FDR' . date('Ymd') . strtoupper(Str::random(6));
        } while (Pesanan::where('kode_pesanan', $kodePesanan)->exists());

        // Simpan pesanan dan detail dalam satu transaksi
        DB::transaction(function () use ($user, $toko, $kodePesanan, $tipe, $totalHarga, $items) {
            $pesanan = Pesanan::create([
                'user_id'      => $user->id,
                'toko_id'      => $toko->id,
                'kode_pesanan' => $kodePesanan,
                'tipe_pesanan' => $tipe,
                'status'       => 'menunggu konfirmasi',
                'total_harga'  => $totalHarga,
            ]);

            foreach ($items as $item) {
                DetailPesanan::create([
                    'pesanan_id'  => $pesanan->id,
                    'produk_id'   => $item['produk_id'],
                    'jumlah'      => $item['jumlah'],
                    'harga_satuan'=> $item['harga_satuan'],
                    'total_harga' => $item['total_harga'],
                ]);
            }
        });

        $request->session()->forget('customer_cart');

        return redirect()->route('customer.pesanan.index')
            ->with('success', 'Pesanan berhasil dibuat. Kode pesanan: ' . $kodePesanan);
    }

    /**
     * Menampilkan detail satu pesanan milik customer yang login.
     */
    public function show(string $id)
    {
        $this->authorizeCustomer();

        $pesanan = Pesanan::with(['detailPesanan.produk', 'toko'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$pesanan) {
            abort(404, 'Pesanan tidak ditemukan atau bukan milik Anda.');
        }

        return view('customer.pesanan.show', compact('pesanan'));
    }

    /**
     * Memastikan hanya customer yang dapat mengakses fitur ini.
     */
    private function authorizeCustomer(): void
    {
        if (!auth()->check() || auth()->user()->role !== 'customer') {
            abort(403, 'Akses hanya untuk customer.');
        }
    }
}
