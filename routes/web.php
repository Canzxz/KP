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
