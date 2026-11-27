<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $query = Pesanan::where('toko_id', $toko->id)
            ->whereNotIn('status', ['selesai', 'dibatalkan'])
            ->whereHas('pembayaran', fn ($q) => $q->where('status', 'paid'))
            ->with(['user', 'detailPesanan.produk', 'antrian', 'pembayaran']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = Str::lower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(kode_pesanan) LIKE ?', ["%{$search}%"])
                  ->orWhereHas('user', fn ($u) => $u->whereRaw('LOWER(nama) LIKE ?', ["%{$search}%"]));
            });
        }

        $pesanan = $query->latest()->paginate(10)->withQueryString();
        $base = $toko->pesanan()
            ->whereNotIn('status', ['selesai', 'dibatalkan'])
            ->whereHas('pembayaran', fn ($q) => $q->where('status', 'paid'));
        $countSemua = (clone $base)->count();
        $countMenunggu = (clone $base)->where('status', 'menunggu konfirmasi')->count();
        $countDiproses = (clone $base)->whereIn('status', ['diproses', 'diprosses'])->count();
        $countSiap = (clone $base)->where('status', 'siap diambil')->count();

        return view('seller.pesanan.index', compact('pesanan', 'countSemua', 'countMenunggu', 'countDiproses', 'countSiap'));
    }

    public function show(Request $request, $id)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko, 403, 'Anda tidak memiliki toko.');

        $pesanan = $toko->pesanan()->findOrFail($id);

        return view('seller.pesanan.show', compact('pesanan'));
    }

    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $toko = $request->user()->toko;
        abort_if(!$toko || $pesanan->toko_id !== $toko->id, 403);

        $data = $request->validate([
            'status' => ['required', Rule::in(['diprosses', 'siap diambil', 'selesai', 'dibatalkan'])],
        ]);

        $pesanan->update(['status' => $data['status']]);

        return back()->with('ok', 'Status pesanan berhasil diperbarui.');
    }
}
