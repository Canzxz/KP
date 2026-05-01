<?php
// Script Pembuat Admin Darurat
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

echo "Mendeteksi database yang aktif: " . DB::connection()->getDatabaseName() . "\n";

try {
    $email = 'admin@gmail.com';
    $password = 'mamimumemo';

    // Hapus jika ada user lama dengan email yang sama di database aktif
    User::where('email', $email)->delete();

    // Buat New User
    $user = User::create([
        'name' => 'Super Admin',
        'email' => $email,
        'password' => Hash::make($password),
        'role' => 'superadmin'
    ]);

    echo "\n[BERHASIL!] Akun Admin telah dibuat ulang di database aktif.\n";
    echo "Email: " . $email . "\n";
    echo "Password: " . $password . "\n\n";
    echo "Silakan coba login kembali di browser.";

} catch (\Exception $e) {
    echo "\n[ERROR] Gagal membuat user: " . $e->getMessage();
}
