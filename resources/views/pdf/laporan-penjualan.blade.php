<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
        }
        p.subtitle {
            text-align: center;
            margin-top: 0;
            color: #666;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #999;
        }
        th {
            background-color: #f2f2f2;
            padding: 8px;
            text-align: left;
        }
        td {
            padding: 6px 8px;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #e6f7ff;
        }
    </style>
</head>
<body>
    <h2>Laporan Penjualan Toko Bangunan</h2>
    <p class="subtitle">Dicetak pada: {{ $tanggal }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Trx</th>
                <th>Waktu</th>
                <th>Kasir</th>
                <th>Metode</th>
                <th class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $index => $trx)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $trx->kode_transaksi }}</td>
                <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ optional($trx->kasir)->name }}</td>
                <td>{{ $trx->metode_pembayaran }}</td>
                <td class="text-right">{{ number_format($trx->total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;">Tidak ada data transaksi.</td>
            </tr>
            @endforelse
            <tr class="total-row">
                <td colspan="5" class="text-right">GRAND TOTAL PENDAPATAN</td>
                <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
