<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TokoController extends Controller
{
    public function index(Request $request)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        return view('seller.toko.index', compact('toko'));
    }

    public function edit(Request $request)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        return view('seller.toko.edit', compact('toko'));
    }

    function update(Request $request)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $data = $request->validate([
            'nama_toko' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'jam_buka' => ['nullable', 'date_format:H:i'],
            'jam_tutup' => ['nullable', 'date_format:H:i'],
        ]);

        if ($request->hasFile('gambar')) {
            if ($toko->gambar) {
                Storage::disk('public')->delete($toko->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('toko', 'public');
        }

        $toko->update($data);

        return view('seller.toko.index', compact('toko'))->with('success', 'Data toko berhasil diperbarui.');
    }
}
