<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStok extends Model
{
    use HasFactory;

    protected $table = 'riwayat_stok';
    protected $primaryKey = 'id_riwayat';
    
    protected $fillable = [
        'produk_id',
        'jenis', // masuk, keluar
        'jumlah',
        'keterangan',
        'user_id'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id_produk');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
