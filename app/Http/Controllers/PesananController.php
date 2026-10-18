<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
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
    public function menu()
    {
        $this->authorizeCustomer();

        $produk = Produk::with(['toko', 'kategori'])
            ->where('in_stock', true)
            ->orderBy('nama_produk')
            ->get();

        return view('customer.menu.index', compact('produk'));
    }

    /**
     * Menampilkan halaman checkout untuk konfirmasi pesanan.
     */
    public function checkout(Request $request)
    {
        $this->authorizeCustomer();

        $produkId = $request->query('produk_id');
        $jumlah   = $request->query('jumlah', 1);

        $items = [];
        $totalHarga = 0;
        $tokoId = null;

        if ($produkId) {
            $produk = Produk::with('toko')->find($produkId);

            if ($produk) {
                $hargaSatuan = (float) $produk->harga;
                $subtotal    = $hargaSatuan * (int) $jumlah;
                $totalHarga  = $subtotal;
                $tokoId      = $produk->toko_id;

                $items[] = [
                    'produk_id'      => $produk->id,
                    'nama_produk'    => $produk->nama_produk,
                    'jumlah'         => (int) $jumlah,
                    'harga_satuan'   => $hargaSatuan,
                    'subtotal'       => $subtotal,
                ];
            }
        }

        return view('customer.pesanan.checkout', compact('items', 'tokoId', 'totalHarga'));
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
