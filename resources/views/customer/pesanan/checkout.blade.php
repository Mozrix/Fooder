@extends('customer.layouts.app')

@section('title', '')

@section('content')
    @if (empty($items))
        <div class="cust-card">
            <p class="cust-muted">Belum ada item yang dipesan.</p>
            <a href="{{ route('customer.menu.index') }}" class="cust-btn cust-btn-sm">Pilih menu</a>
        </div>
    @else
        <form action="{{ route('customer.pesanan.store') }}" method="POST">
            @csrf

            <input type="hidden" name="toko_id" value="{{ $toko_id }}">
            <input type="hidden" name="tipe_pesanan" value="online">

            <div class="cust-table-wrap">
                <table class="cust-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item['nama_produk'] }}</td>
                                <td>
                                    <input type="hidden" name="items[{{ $item['produk_id'] }}][produk_id]" value="{{ $item['produk_id'] }}">
                                    <input type="number" class="cust-input" name="items[{{ $item['produk_id'] }}][jumlah]" min="1" value="{{ $item['jumlah'] }}">
                                </td>
                                <td class="cust-price">Rp {{ number_format($item['harga_satuan'], 0, ',', '.') }}</td>
                                <td class="cust-price">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <td class="cust-price">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <label class="cust-label" for="catatan">Catatan Pesanan:</label>
            <textarea id="catatan" class="cust-input" name="catatan" rows="3"></textarea>

            <button type="submit" class="cust-btn">Konfirmasi Pesanan</button>
        </form>
    @endif
@endsection
