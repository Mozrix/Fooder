<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $kategoriList = Kategori::all();

        $totalMenu = $toko->produk()->count();
        $aktifMenu = $toko->produk()
                        ->where('in_stock', true)
                        ->where('stok', '>', 0)
                        ->count();
        $habisMenu = $toko->produk()->where(function ($q) {
            $q->where('in_stock', false)->orWhere('stok', '<=', 0);
        })->count();

        $query = $toko->produk()->with('kategori');

        if ($request->filled('search')) {
            $search = Str::lower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama_produk) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(deskripsi) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->status === 'aktif') {
            $query->where('in_stock', true)->where('stok', '>', 0);
        } elseif ($request->status === 'habis') {
            $query->where(function ($q) {
                $q->where('in_stock', false)->orWhere('stok', '<=', 0);
            });
        }

        $produk = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('seller.produk.index', compact(
            'produk',
            'kategoriList',
            'totalMenu',
            'aktifMenu',
            'habisMenu'
        ));
    }

    public function store(Request $request)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Toko tidak terdaftar');

        

        $data = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tipe' => 'required|in:makanan berat,makanan ringan,minuman',
        ]);

        $data['in_stock'] = ($data['stok'] > 0);

        $data['kategori_id'] = Kategori::firstOrCreate(['nama_kategori' => $data['tipe']])->id;

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $toko->produk()->create($data);

        return redirect()
            ->route('seller.produk')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function destroy(Request $request, Produk $produk)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Toko tidak terdaftar');

        abort_if($produk->toko_id !== $toko->id, 403, 'Anda tidak memiliki akses untuk menghapus produk ini.');

        $produk->delete();

        return redirect()
            ->route('seller.produk')
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function edit(Request $request, Produk $produk)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Toko tidak terdaftar');

        $kategoriList = Kategori::all();

        return view('seller.produk.edit', compact('produk', 'kategoriList'));
    }

    public function update(Request $request, Produk $produk)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Toko tidak terdaftar');

        $data = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tipe' => 'required|in:makanan berat,makanan ringan,minuman',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update($data);

        return redirect()
            ->route('seller.produk')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function show(Request $request, Produk $produk)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Toko tidak terdaftar');

        return view('seller.produk.index', compact('produk'));
    }
}
