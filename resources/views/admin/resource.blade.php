@extends('layouts.admin')

@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h2 style="margin:0; font-size:18px;">{{ $title }}</h2>
            <p style="margin:4px 0 0 0; color:var(--m); font-size:13px;">Total data tercatat: <b>{{ $items->total() }}</b></p>
        </div>
    </div>
    @if(in_array($type, ['orders', 'payments', 'queues']))
        <form method="get" style="display:flex; gap:10px; align-items:end; margin-bottom:18px; flex-wrap:wrap;">
            <label style="font-size:12px; color:var(--m);">Dari<input class="input" type="date" name="from" value="{{ request('from') }}" style="display:block; margin:4px 0 0;"></label>
            <label style="font-size:12px; color:var(--m);">Sampai<input class="input" type="date" name="to" value="{{ request('to') }}" style="display:block; margin:4px 0 0;"></label>
            <input class="input" name="status" placeholder="Status" value="{{ request('status') }}" style="margin:0;">
            <button class="btn" type="submit">Filter</button>
        </form>
    @endif

    <table class="table">
        @if($type === 'stores')
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Toko</th>
                    <th>Pemilik Toko</th>
                    <th>Email Pemilik</th>
                    <th>Total Produk Menu</th>
                    <th>Tanggal Terdaftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $toko)
                    <tr>
                        <td>{{ $items->firstItem() + $i }}</td>
                        <td style="font-weight:600;">{{ $toko->nama_toko }}</td>
                        <td>{{ $toko->user->nama ?? '-' }}</td>
                        <td>{{ $toko->user->email ?? '-' }}</td>
                        <td>
                            <span class="badge" style="background:#f1f5f9; color:#475569; font-weight:600;">
                                {{ $toko->produk_count ?? 0 }} Produk
                            </span>
                        </td>
                        <td>{{ $toko->created_at?->format('d M Y, H:i') ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center; padding:30px; color:var(--m);">Belum ada data toko.</td></tr>
                @endforelse
            </tbody>

        @elseif($type === 'products')
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Toko</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status Stok</th>
                    <th>Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $prod)
                    <tr>
                        <td>{{ $items->firstItem() + $i }}</td>
                        <td style="font-weight:600;">{{ $prod->nama_produk }}</td>
                        <td>{{ $prod->toko->nama_toko ?? '-' }}</td>
                        <td><span class="badge" style="background:#f3e8ff; color:#7e22ce;">{{ $prod->kategori->nama_kategori ?? '-' }}</span></td>
                        <td style="font-weight:600; color:#0f766e;">Rp {{ number_format($prod->harga, 0, ',', '.') }}</td>
                        <td>{{ $prod->stok }}</td>
                        <td>
                            @if($prod->stok > 0)
                                <span class="badge" style="background:#dcfce7; color:#15803d; font-weight:600;">Tersedia</span>
                            @else
                                <span class="badge" style="background:#fee2e2; color:#b91c1c; font-weight:600;">Habis</span>
                            @endif
                        </td>
                        <td>{{ $prod->created_at?->format('d M Y') ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" style="text-align:center; padding:30px; color:var(--m);">Belum ada produk menu.</td></tr>
                @endforelse
            </tbody>

        @elseif($type === 'orders')
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Order</th>
                    <th>Pelanggan</th>
                    <th>Toko</th>
                    <th>Tipe Pesanan</th>
                    <th>Total Bayar</th>
                    <th>Status Pesanan</th>
                    <th>Waktu Pesan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $ord)
                    <tr>
                        <td>{{ $items->firstItem() + $i }}</td>
                        <td><code style="background:#f1f5f9; padding:3px 7px; border-radius:6px; font-weight:600;">{{ $ord->kode_pesanan }}</code></td>
                        <td>{{ $ord->user->nama ?? '-' }}</td>
                        <td>{{ $ord->toko->nama_toko ?? '-' }}</td>
                        <td><span class="badge" style="background:#e0f2fe; color:#0369a1; text-transform:capitalize;">{{ $ord->tipe_pesanan ?? 'Dine In' }}</span></td>
                        <td style="font-weight:700; color:var(--c);">Rp {{ number_format($ord->total_harga, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $statusColors = [
                                    'selesai' => 'background:#dcfce7; color:#15803d',
                                    'diproses' => 'background:#fef3c7; color:#b45309',
                                    'menunggu' => 'background:#f1f5f9; color:#475569',
                                    'dibatalkan' => 'background:#fee2e2; color:#b91c1c'
                                ];
                                $color = $statusColors[strtolower($ord->status)] ?? 'background:#edf4ff; color:#1e40af';
                            @endphp
                            <span class="badge" style="{{ $color }}; font-weight:600; text-transform:capitalize;">
                                {{ $ord->status }}
                            </span>
                        </td>
                        <td>{{ $ord->created_at?->format('d M Y, H:i') ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" style="text-align:center; padding:30px; color:var(--m);">Belum ada riwayat pesanan.</td></tr>
                @endforelse
            </tbody>

        @elseif($type === 'payments')
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Pesanan</th>
                    <th>Toko Tujuan</th>
                    <th>Metode Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Waktu Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $pay)
                    <tr>
                        <td>{{ $items->firstItem() + $i }}</td>
                        <td><code style="background:#f1f5f9; padding:3px 7px; border-radius:6px; font-weight:600;">{{ $pay->pesanan->kode_pesanan ?? '-' }}</code></td>
                        <td>{{ $pay->pesanan->toko->nama_toko ?? '-' }}</td>
                        <td style="text-transform:uppercase; font-weight:600;">{{ $pay->metode_pembayaran }}</td>
                        <td>
                            @if(str_contains(strtolower($pay->status), 'sudah') || str_contains(strtolower($pay->status), 'lunas') || strtolower($pay->status) === 'paid')
                                <span class="badge" style="background:#dcfce7; color:#15803d; font-weight:600;">Lunas / Berhasil</span>
                            @else
                                <span class="badge" style="background:#fef3c7; color:#b45309; font-weight:600;">{{ $pay->status }}</span>
                            @endif
                        </td>
                        <td>{{ $pay->created_at?->format('d M Y, H:i') ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center; padding:30px; color:var(--m);">Belum ada transaksi pembayaran.</td></tr>
                @endforelse
            </tbody>

        @elseif($type === 'queues')
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Antrean</th>
                    <th>Kode Pesanan</th>
                    <th>Toko</th>
                    <th>Pelanggan</th>
                    <th>Status Antrean</th>
                    <th>Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $q)
                    <tr>
                        <td>{{ $items->firstItem() + $i }}</td>
                        <td><span style="font-size:16px; font-weight:800; color:var(--c);">#{{ $q->nomor_antrian }}</span></td>
                        <td><code style="background:#f1f5f9; padding:3px 7px; border-radius:6px;">{{ $q->pesanan->kode_pesanan ?? '-' }}</code></td>
                        <td>{{ $q->pesanan->toko->nama_toko ?? '-' }}</td>
                        <td>{{ $q->pesanan->user->nama ?? '-' }}</td>
                        <td>
                            <span class="badge" style="background:#e0f2fe; color:#0369a1; font-weight:600; text-transform:capitalize;">
                                {{ $q->status }}
                            </span>
                        </td>
                        <td>{{ $q->created_at?->format('d M Y, H:i') ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center; padding:30px; color:var(--m);">Belum ada antrean aktif.</td></tr>
                @endforelse
            </tbody>

        @elseif($type === 'stock-history')
            <thead>
                <tr>
                    <th>No</th>
                    <th>Menu Produk</th>
                    <th>Toko</th>
                    <th>Pengubah</th>
                    <th>Tipe Perubahan</th>
                    <th>Stok Sebelum</th>
                    <th>Perubahan</th>
                    <th>Stok Setelah</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $st)
                    <tr>
                        <td>{{ $items->firstItem() + $i }}</td>
                        <td style="font-weight:600;">{{ $st->produk->nama_produk ?? '-' }}</td>
                        <td>{{ $st->produk->toko->nama_toko ?? '-' }}</td>
                        <td>{{ $st->user->nama ?? '-' }}</td>
                        <td><span class="badge" style="background:#f1f5f9; color:#475569; text-transform:uppercase; font-size:11px;">{{ $st->tipe }}</span></td>
                        <td>{{ $st->jumlah_sebelum }}</td>
                        <td style="font-weight:700; color: {{ $st->jumlah_perubahan >= 0 ? '#15803d' : '#b91c1c' }};">
                            {{ $st->jumlah_perubahan > 0 ? '+'.$st->jumlah_perubahan : $st->jumlah_perubahan }}
                        </td>
                        <td style="font-weight:600;">{{ $st->jumlah_setelah }}</td>
                        <td>{{ $st->keterangan ?? '-' }}</td>
                        <td>{{ $st->created_at?->format('d M Y, H:i') ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="10" style="text-align:center; padding:30px; color:var(--m);">Belum ada riwayat mutasi stok.</td></tr>
                @endforelse
            </tbody>
        @endif
    </table>

    <div style="margin-top:20px;">
        {{ $items->links() }}
    </div>
</div>
@endsection
