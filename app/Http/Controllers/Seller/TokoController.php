<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    public function show(Request $request)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        return view('seller.toko.show', compact('toko'));
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
            'jam_buka' => ['nullable', 'date_format:H:i'],
            'jam_tutup' => ['nullable', 'date_format:H:i'],
        ]);

        $toko->update($data);

        return back()->with('success', 'Data toko berhasil diperbarui.');
    }
}
