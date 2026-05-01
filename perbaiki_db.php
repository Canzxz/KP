<?php
// Script Perbaikan Database Otomatis
echo "Sedang memproses perbaikan database...\n";

$dbPath = __DIR__ . '/database/database.sqlite';

// 1. Buat file sqlite jika belum ada
if (!file_exists($dbPath)) {
    file_put_contents($dbPath, "");
    echo "[OK] File database.sqlite berhasil dibuat.\n";
} else {
    echo "[OK] File database sudah ada.\n";
}

// 2. Jalankan migrasi dan seeding
echo "Sedang menjalankan migrasi dan seeding (ini mungkin memakan waktu beberapa detik)...\n";
passthru("php artisan migrate:fresh --seed");

echo "\n--- SELESAI ---\n";
echo "Silakan refresh browser Anda sekarang.";
unlink(__filename__); // Hapus script ini setelah selesai
