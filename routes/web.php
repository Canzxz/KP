<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StrukController;

/*
|--------------------------------------------------------------------------
| Transaksi
|--------------------------------------------------------------------------
*/
Route::get('/transaksi/{transaksi}/struk', [StrukController::class, 'print'])
    ->name('transaksi.struk');

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/buat-user', function () {
    $user = \App\Models\User::create([
        'name' => 'Admin Toko',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('password123'),
    ]);
    return 'User berhasil dibuat! Silakan login di /admin/login dengan email: admin@gmail.com dan password: password123';
});
