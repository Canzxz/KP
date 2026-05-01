<?php

$sourceDir = 'C:/Users/HP/.gemini/antigravity/brain/ee09e8e4-7a42-4ff6-8db6-0c9b59976aff/';
$destDir = __DIR__ . '/storage/app/public/produks/';

if (!is_dir($destDir)) {
    mkdir($destDir, 0777, true);
}

$files = [
    'besi_beton_1776610788292.png' => 'besi_beton.png',
    'cat_tembok_1776610807157.png' => 'cat_dulux.png',
    'pipa_pvc_1776610860888.png'   => 'pipa_pvc.png',
    'closet_toto_1776610886675.png' => 'closet.png',
    'baja_ringan_1776610931585.png' => 'baja_ringan.png',
    'triplek_meranti_1776611019053.png' => 'triplek.png',
    'semen_bag_1776611046162.png'  => 'semen.png',
    'pasir_cor_1776611075775.png'  => 'pasir.png',
    'paku_kayu_1776611105436.png'  => 'paku.png',
    'keramik_lantai_1776611135245.png' => 'keramik.png',
    'bor_listrik_1776611174620.png' => 'bor.png',
    'kabel_listrik_1776611204689.png' => 'kabel.png',
];

echo "--- Memulai Sinkronisasi Gambar Custom --- \n";

foreach ($files as $source => $dest) {
    if (copy($sourceDir . $source, $destDir . $dest)) {
        echo "✅ Berhasil: $dest \n";
    } else {
        echo "❌ Gagal menyalin: $source \n";
    }
}

echo "--- Selesai! Silakan jalankan 'php artisan migrate:fresh --seed' --- \n";
