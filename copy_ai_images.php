<?php
/**
 * Script untuk menyalin gambar AI ke folder storage produk
 * Jalankan: php copy_ai_images.php
 */

$source = 'C:\\Users\\HP\\.gemini\\antigravity\\brain\\ee09e8e4-7a42-4ff6-8db6-0c9b59976aff';
$dest = __DIR__ . '/storage/app/public/produks';

// Pastikan folder tujuan ada
if (!is_dir($dest)) {
    mkdir($dest, 0755, true);
}

$images = [
    'semen_pasir_1777212036254.png' => 'semen_pasir.png',
    'besi_baja_1777212337198.png' => 'besi_baja.png',
    'cat_cairan_1777212466112.png' => 'cat_cairan.png',
    'paku_hardware_1777212671816.png' => 'paku_hardware.png',
    'plumbing_pipa_1777212776220.png' => 'plumbing_pipa.png',
];

$success = 0;
foreach ($images as $from => $to) {
    $srcPath = $source . '\\' . $from;
    $dstPath = $dest . '/' . $to;
    
    if (file_exists($srcPath)) {
        if (copy($srcPath, $dstPath)) {
            echo "✅ $to berhasil disalin\n";
            $success++;
        } else {
            echo "❌ Gagal menyalin $to\n";
        }
    } else {
        echo "⚠️ File tidak ditemukan: $from\n";
    }
}

echo "\nSelesai! $success dari " . count($images) . " gambar berhasil disalin.\n";
