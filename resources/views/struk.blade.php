<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi — {{ $transaksi->kode_transaksi }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1152d4;
            --bg-dark: #101622;
            --bg-card: #1e2433;
            --border: rgba(255, 255, 255, 0.05);
            --text: #e2e8f0;
            --text-muted: #94a3b8;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .struk {
            max-width: 400px;
            width: 100%;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 1.5rem;
            padding: 2rem;
            color: var(--text);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        .struk-header {
            text-align: center;
            padding-bottom: 1.25rem;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
            margin-bottom: 1.25rem;
        }

        .struk-header .logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, var(--primary), #0a368c);
            border-radius: 0.75rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 4px 15px rgba(17, 82, 212, 0.3);
        }

        .struk-header .logo svg {
            width: 1.5rem;
            height: 1.5rem;
            color: white;
        }

        .struk-header h2 {
            font-size: 1.25rem;
            font-weight: 800;
            color: white;
            margin-bottom: 0.25rem;
        }

        .struk-header p {
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        .struk-meta {
            font-size: 0.75rem;
            color: var(--text-muted);
            padding-bottom: 1rem;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
            line-height: 1.8;
        }

        .struk-meta span {
            color: var(--text);
            font-weight: 600;
        }

        .struk-items { margin-bottom: 1rem; }

        .struk-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.625rem 0;
        }

        .struk-item + .struk-item {
            border-top: 1px solid rgba(255, 255, 255, 0.03);
        }

        .struk-item .item-name {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text);
        }

        .struk-item .item-detail {
            font-size: 0.6875rem;
            color: var(--text-muted);
            margin-top: 0.125rem;
        }

        .struk-item .item-price {
            font-size: 0.8125rem;
            font-weight: 700;
            color: var(--text);
            text-align: right;
        }

        .struk-total {
            border-top: 1px dashed rgba(255, 255, 255, 0.1);
            padding-top: 1rem;
        }

        .struk-row {
            display: flex;
            justify-content: space-between;
            padding: 0.25rem 0;
            font-size: 0.8125rem;
            color: var(--text-muted);
        }

        .struk-row span:last-child {
            color: var(--text);
            font-weight: 600;
        }

        .struk-row.grand {
            font-size: 1.5rem;
            font-weight: 800;
            padding-top: 0.75rem;
            margin-top: 0.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .struk-row.grand span:last-child {
            color: var(--primary);
        }

        .struk-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px dashed rgba(255, 255, 255, 0.1);
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        .struk-footer .emoji { font-size: 1.25rem; margin-bottom: 0.25rem; }

        /* Print Styles */
        @media print {
            body { background: white; padding: 0; }
            .struk {
                box-shadow: none;
                border: none;
                border-radius: 0;
                max-width: 100%;
                padding: 1rem;
                background: white;
                color: black;
            }
            .struk-header h2, .struk-row.grand span:last-child { color: black; }
            .struk-header p, .struk-meta, .struk-footer, .struk-row { color: #666; }
            .struk-item .item-name, .struk-item .item-price, .struk-row span:last-child { color: black; }
            .struk-item .item-detail { color: #888; }
            .struk-header, .struk-meta, .struk-total, .struk-footer,
            .struk-item + .struk-item, .struk-row.grand { border-color: #ccc; }
            .struk-header .logo { box-shadow: none; }
        }
    </style>
</head>

<body>
    <div class="struk">
        {{-- HEADER --}}
        <div class="struk-header">
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
            <h2>Toko Bangunan Hadi</h2>
            <p>Jl. Contoh No. 123</p>
        </div>

        {{-- META --}}
        <div class="struk-meta">
            Kode &nbsp;&nbsp;&nbsp;: <span>{{ $transaksi->kode_transaksi }}</span><br>
            Tanggal : <span>{{ $transaksi->created_at->format('d/m/Y H:i') }}</span><br>
            Kasir &nbsp;&nbsp;: <span>{{ optional($transaksi->kasir)->name ?? 'Kasir #' . $transaksi->kasir_id }}</span><br>
            Metode &nbsp;: <span>{{ $transaksi->metode_pembayaran }}</span>
        </div>

        {{-- ITEMS --}}
        <div class="struk-items">
            @if($transaksi->items && $transaksi->items->count())
                @foreach($transaksi->items as $item)
                    @php
                        $namaProduk = optional($item->produk)->nama_produk ?? 'Produk ID: ' . $item->id_produk;
                    @endphp
                    <div class="struk-item">
                        <div>
                            <div class="item-name">{{ $namaProduk }}</div>
                            <div class="item-detail">{{ $item->qty }} × Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                        </div>
                        <div class="item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                    </div>
                @endforeach
            @else
                <p style="text-align:center; color: var(--text-muted); padding: 1rem 0; font-size: 0.8125rem;">
                    <em>Tidak ada detail item transaksi</em>
                </p>
            @endif
        </div>

        {{-- TOTALS --}}
        <div class="struk-total">
            <div class="struk-row">
                <span>Total</span>
                <span>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
            </div>
            <div class="struk-row">
                <span>Bayar</span>
                <span>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
            </div>
            <div class="struk-row grand">
                <span>Kembali</span>
                <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="struk-footer">
            <div class="emoji">🙏</div>
            <p>Terima kasih atas kunjungan Anda!</p>
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