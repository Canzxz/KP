<?php

$host = 'switchyard.proxy.rlwy.net';
$user = 'root';
$pass = 'CwRlRbrCknmoWPFPpOzsCexjDwlJAeHT';
$dbName = 'railway';
$port = 35138;

echo "Menghubungkan ke Railway...\n";
$mysqli = new mysqli($host, $user, $pass, $dbName, $port);

if ($mysqli->connect_error) {
    die("Koneksi Gagal: " . $mysqli->connect_error);
}

echo "Membaca file data_asli.sql...\n";
if (!file_exists('data_asli.sql')) {
    die("Error: File data_asli.sql tidak ditemukan! Pastikan Anda sudah menjalankan perintah mysqldump sebelumnya.");
}

$sql = file_get_contents('data_asli.sql');

// Perbaikan untuk format UTF-16 dari PowerShell
if (strpos($sql, "\xFF\xFE") === 0) {
    $sql = mb_convert_encoding($sql, 'UTF-8', 'UTF-16LE');
    $sql = substr($sql, 3); // Hapus BOM
}

echo "Sedang mengimpor data ke Railway (mohon tunggu)...\n";
if ($mysqli->multi_query($sql)) {
    do {
        // Bebaskan hasil query sebelumnya
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
    } while ($mysqli->next_result());
    
    echo "\nBERHASIL! Semua data dari laptop Anda sudah pindah ke Railway.\n";
    echo "Silakan cek website Anda di HP sekarang.\n";
} else {
    echo "Error: " . $mysqli->error;
}

$mysqli->close();
