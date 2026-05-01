<?php

use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Support\Str;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$kasir = User::first();
if (!$kasir) {
    echo "User not found. Please run seeder first.";
    exit;
}

$produks = Produk::all();
if ($produks->isEmpty()) {
    echo "Products not found. Please run seeder first.";
    exit;
}

for ($i = 0; $i < 8; $i++) {
    $total = 0;
    $items = [];
    
    // Pick 1-3 random products
    $selected = $produks->random(rand(1, 4));
    
    foreach ($selected as $p) {
        $qty = rand(1, 5);
        $subtotal = $p->harga * $qty;
        $total += $subtotal;
        $items[] = [
            'id_produk' => $p->id_produk,
            'qty' => $qty,
            'harga' => $p->harga,
            'subtotal' => $subtotal
        ];
    }
    
    $t = Transaksi::create([
        'kode_transaksi' => 'TRX-' . date('Ymd') . strtoupper(Str::random(4)),
        'total' => $total,
        'bayar' => $total + 50000,
        'kembalian' => 50000,
        'kasir_id' => $kasir->id,
        'metode_pembayaran' => 'Cash',
        'created_at' => now(),
    ]);
    
    foreach ($items as $item) {
        $item['id_transaksi'] = $t->id_transaksi;
        TransaksiItem::create($item);
    }
}
echo "Berhasil membuat 8 transaksi hari ini.\n";
