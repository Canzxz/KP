<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class StrukController extends Controller
{
    /**
     * Tampilkan struk transaksi (HTML)
     * Otomatis memanggil window.print()
     */
    public function print(Transaksi $transaksi)
    {
        // Pastikan relasi ter-load
        $transaksi->load([
            'items',
            'items.produk',
            'kasir',
        ]);

        return view('struk', [
            'transaksi' => $transaksi,
        ]);
    }
}
