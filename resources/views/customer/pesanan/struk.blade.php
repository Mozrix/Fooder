<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $pesanan->kode_pesanan }} - Fooder</title>
    <link rel="stylesheet" href="{{ asset('css/customer-receipt.css') }}">
</head>
<body class="receipt-page">

    <div class="receipt-action-bar">
        <a href="{{ route('customer.pesanan.show', $pesanan->id) }}" class="receipt-btn">
            ← Kembali
        </a>
        <button type="button" onclick="window.print()" class="receipt-btn receipt-btn-primary">
            Simpan PDF / Cetak Struk
        </button>
    </div>

    <div class="receipt-paper">
        <div class="receipt-meta-row">
            <span>{{ ($pesanan->pembayaran->updated_at ?? $pesanan->created_at)->format('d/m/y H:i') }}</span>
            <strong>Struk #{{ $pesanan->kode_pesanan }}</strong>
        </div>
        <div class="receipt-meta-row receipt-meta-row--sub">
            <span>Tipe: {{ ucfirst($pesanan->tipe_pesanan) }}</span>
            <span>Antrean: <strong>{{ $pesanan->antrian ? '#' . $pesanan->antrian->nomor_antrian : '-' }}</strong></span>
        </div>

        <div class="receipt-store-header">
            <h1 class="receipt-store-name">{{ $pesanan->toko->nama_toko ?? 'FOODER MERCHANT' }}</h1>
            @if (!empty($pesanan->toko->alamat))
                <div class="receipt-store-detail">{{ $pesanan->toko->alamat }}</div>
            @endif
            @if (!empty($pesanan->toko->no_telp) || !empty($pesanan->toko->nomor_telepon))
                <div class="receipt-store-detail">{{ $pesanan->toko->no_telp ?? $pesanan->toko->nomor_telepon }}</div>
            @else
                <div class="receipt-store-detail">Fooder Campus Ordering</div>
            @endif
        </div>

        <div class="receipt-customer-line">
            Customer: {{ strtoupper($pesanan->user->name ?? auth()->user()->name) }}
        </div>

        <table class="receipt-items">
            <thead>
                <tr>
                    <th class="receipt-col-item">Item</th>
                    <th class="receipt-col-qty receipt-text-center">Qty</th>
                    <th class="receipt-col-price receipt-text-right">Harga</th>
                    <th class="receipt-col-sub receipt-text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanan->detailPesanan as $detail)
                    <tr>
                        <td>{{ strtoupper($detail->produk->nama_produk ?? '-') }}</td>
                        <td class="receipt-text-center">{{ $detail->jumlah }}</td>
                        <td class="receipt-text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        <td class="receipt-text-right">Rp {{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="receipt-summary-section">
            <div class="receipt-summary-left">
                Metode: {{ strtoupper($pesanan->pembayaran->metode_pembayaran ?? 'QRIS') }}
            </div>
            <div class="receipt-summary-right">
                <table>
                    <tr>
                        <td>Subtotal:</td>
                        <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Biaya Layanan:</td>
                        <td>+ Rp 0</td>
                    </tr>
                    <tr class="receipt-total-row">
                        <td>TOTAL STRUK:</td>
                        <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="receipt-paid-amount">
            Dibayar ({{ strtoupper($pesanan->pembayaran->metode_pembayaran ?? 'QRIS') }}): Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
        </div>

        <div class="receipt-status-box">
            Status Pembayaran: {{ strtoupper($pesanan->pembayaran->status ?? 'PAID') }}
        </div>

        <div class="receipt-thanks-text">
            Terima kasih telah berbelanja di Fooder!
        </div>

        <div class="receipt-barcode-box">
            <svg viewBox="0 0 210 44" xmlns="http://www.w3.org/2000/svg" shape-rendering="crispEdges">
                <rect x="4" y="0" width="3" height="44" fill="#111827"/>
                <rect x="9" y="0" width="1" height="44" fill="#111827"/>
                <rect x="13" y="0" width="4" height="44" fill="#111827"/>
                <rect x="20" y="0" width="2" height="44" fill="#111827"/>
                <rect x="25" y="0" width="1" height="44" fill="#111827"/>
                <rect x="29" y="0" width="3" height="44" fill="#111827"/>
                <rect x="35" y="0" width="2" height="44" fill="#111827"/>
                <rect x="40" y="0" width="4" height="44" fill="#111827"/>
                <rect x="47" y="0" width="1" height="44" fill="#111827"/>
                <rect x="51" y="0" width="3" height="44" fill="#111827"/>
                <rect x="57" y="0" width="2" height="44" fill="#111827"/>
                <rect x="62" y="0" width="1" height="44" fill="#111827"/>
                <rect x="66" y="0" width="4" height="44" fill="#111827"/>
                <rect x="73" y="0" width="2" height="44" fill="#111827"/>
                <rect x="78" y="0" width="3" height="44" fill="#111827"/>
                <rect x="84" y="0" width="1" height="44" fill="#111827"/>
                <rect x="88" y="0" width="2" height="44" fill="#111827"/>
                <rect x="93" y="0" width="4" height="44" fill="#111827"/>
                <rect x="100" y="0" width="1" height="44" fill="#111827"/>
                <rect x="104" y="0" width="3" height="44" fill="#111827"/>
                <rect x="110" y="0" width="2" height="44" fill="#111827"/>
                <rect x="115" y="0" width="4" height="44" fill="#111827"/>
                <rect x="122" y="0" width="1" height="44" fill="#111827"/>
                <rect x="126" y="0" width="3" height="44" fill="#111827"/>
                <rect x="132" y="0" width="2" height="44" fill="#111827"/>
                <rect x="137" y="0" width="1" height="44" fill="#111827"/>
                <rect x="141" y="0" width="4" height="44" fill="#111827"/>
                <rect x="148" y="0" width="2" height="44" fill="#111827"/>
                <rect x="153" y="0" width="3" height="44" fill="#111827"/>
                <rect x="159" y="0" width="1" height="44" fill="#111827"/>
                <rect x="163" y="0" width="4" height="44" fill="#111827"/>
                <rect x="170" y="0" width="2" height="44" fill="#111827"/>
                <rect x="175" y="0" width="1" height="44" fill="#111827"/>
                <rect x="179" y="0" width="3" height="44" fill="#111827"/>
                <rect x="185" y="0" width="2" height="44" fill="#111827"/>
                <rect x="190" y="0" width="1" height="44" fill="#111827"/>
                <rect x="194" y="0" width="4" height="44" fill="#111827"/>
                <rect x="201" y="0" width="3" height="44" fill="#111827"/>
            </svg>
            <div class="receipt-barcode-number">{{ $pesanan->kode_pesanan }}</div>
        </div>
    </div>

</body>
</html>