<?php
$sourceDir = 'C:/Users/HP/.gemini/antigravity/brain/29b9232c-529e-4ffa-8ddf-7e27baa22ab2/';
$destDir = 'e:/KP/filament-app/storage/app/public/produks/';

if (!is_dir($destDir)) {
    mkdir($destDir, 0777, true);
}

$files = [
    'semen_bag_plain_1777040302428.png' => 'semen.png',
    'paint_can_plain_1777040341350.png' => 'cat_kaleng.png',
    'closet_toto_1777037163005.png' => 'closet.png'
];

foreach ($files as $source => $dest) {
    if (file_exists($sourceDir . $source)) {
        if (copy($sourceDir . $source, $destDir . $dest)) {
            echo "Copied $source to $dest\n";
        } else {
            echo "Failed to copy $source\n";
        }
    } else {
        echo "Source file not found: $source\n";
    }
}
