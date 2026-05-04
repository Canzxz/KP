<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi — {{ $transaksi->kode_transaksi }}</title>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-print: #ffffff;
            --text-dark: #1a202c;
            --text-muted: #718096;
            --border-color: #e2e8f0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f7fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            color: var(--text-dark);
        }

        .struk-container {
            width: 380px;
            background: white;
            padding: 30px;
            border-radius: 4px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            position: relative;
        }

        /* Dekorasi Struk Thermal */
        .struk-container::before, .struk-container::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            height: 8px;
            background-size: 16px 8px;
            background-repeat: repeat-x;
        }
        .struk-container::before {
            top: -8px;
            background-image: radial-gradient(circle at 8px -4px, transparent 10px, white 11px);
        }
        .struk-container::after {
            bottom: -8px;
            background-image: radial-gradient(circle at 8px 12px, transparent 10px, white 11px);
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 20px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.4;
        }

        .divider {
            border-top: 1px dashed var(--border-color);
            margin: 15px 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 80px 10px auto;
            font-size: 12px;
            gap: 4px;
            margin-bottom: 20px;
        }

        .info-grid label { color: var(--text-muted); }
        .info-grid span { font-weight: 600; }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
        }

        .items-table th {
            text-align: left;
            border-bottom: 2px solid var(--text-dark);
            padding-bottom: 8px;
            font-size: 11px;
            color: var(--text-muted);
        }

        .items-table td {
            padding: 10px 0;
            vertical-align: top;
        }

        .item-row .name {
            font-weight: 700;
            display: block;
            margin-bottom: 2px;
        }

        .item-row .details {
            font-size: 11px;
            color: var(--text-muted);
        }

        .item-row .subtotal {
            text-align: right;
            font-weight: 700;
        }

        .summary {
            margin-top: 15px;
            font-size: 13px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
        }

        .summary-row.total {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid var(--text-dark);
            font-weight: 800;
        }

        .summary-row.total span:last-child {
            color: var(--text-dark);
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 11px;
            color: var(--text-muted);
        }

        .footer .thank-you {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .barcode {
            margin: 20px auto 0;
            width: 80%;
            height: 40px;
            background: repeating-linear-gradient(90deg, #000, #000 2px, #fff 2px, #fff 4px);
            opacity: 0.7;
        }

        @media print {
            body { background: white; padding: 0; }
            .struk-container {
                box-shadow: none;
                width: 100%;
                max-width: 100%;
                padding: 10px;
            }
            .struk-container::before, .struk-container::after { display: none; }
        }
    </style>
</head>

<body>
    <div class="struk-container">
        <div class="header">
            <h1>Toko Bangunan Hadi</h1>
            <p>Sedia Bahan Bangunan & Alat Pertukangan Lengkap</p>
            <p>Jl. Jend. Sudirman No. 45, Telp: (021) 555-0123</p>
        </div>

        <div class="divider"></div>

        <div class="info-grid">
            <label>No. Nota</label> <div>:</div> <span>{{ $transaksi->kode_transaksi }}</span>
            <label>Tanggal</label> <div>:</div> <span>{{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
            <label>Kasir</label> <div>:</div> <span>{{ strtoupper(optional($transaksi->kasir)->name ?? 'Admin') }}</span>
            <label>Metode</label> <div>:</div> <span>{{ strtoupper($transaksi->metode_pembayaran) }}</span>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>ITEM / QTY</th>
                    <th style="text-align: right;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->items as $item)
                <tr class="item-row">
                    <td>
                        <span class="name">{{ optional($item->produk)->nama_produk ?? 'Produk ID: '.$item->id_produk }}</span>
                        <span class="details">{{ $item->qty }} x Rp{{ number_format($item->harga, 0, ',', '.') }}</span>
                    </td>
                    <td class="subtotal">
                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="divider"></div>

        <div class="summary">
            <div class="summary-row">
                <span>Subtotal Item ({{ $transaksi->items->sum('qty') }})</span>
                <span>Rp{{ number_format($transaksi->total, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Pembayaran</span>
                <span>Rp{{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row total">
                <span>KEMBALI</span>
                <span>Rp{{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer">
            <p class="thank-you">TERIMA KASIH</p>
            <p>Barang yang sudah dibeli tidak dapat ditukar</p>
            <p>atau dikembalikan. Periksa kembali belanjaan Anda.</p>
            <div class="barcode"></div>
            <p style="margin-top: 10px; font-size: 9px;">Powered by POS Hadi System</p>
        </div>
    </div>

    <script>
        window.onload = function () {
            window.print();
            setTimeout(() => {
                window.close();
            }, 500);
        }
    </script>
</body>

</html>