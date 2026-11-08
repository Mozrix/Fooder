<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $produk = Produk::where('toko_id', $toko->id)
            ->when($request->search, function ($query, $search) {
                $query->whereLike('nama_produk', "%{$search}%");
            })
            ->latest()
            ->paginate(10)  //Fungsi pembagi halaman yang ditampilkan
            ->withQueryString()
        ;

        return view('seller.produk.index', compact('produk'));
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
            'tipe' => 'required|in:makanan berat,makanan ringan,minuman',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

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
            ->route('seller.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function edit(Request $request, Produk $produk)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Toko tidak terdaftar');

        return view('seller.produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Toko tidak terdaftar');

        $data = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:makanan berat,makanan ringan,minuman',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

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
