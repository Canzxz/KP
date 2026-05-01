<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'kode_transaksi',
        'total',
        'bayar',
        'kembalian',
        'kasir_id',
        'metode_pembayaran',
    ];

    public function items()
    {
        return $this->hasMany(
            \App\Models\TransaksiItem::class,
            'id_transaksi',   // FK di transaksi_items
            'id_transaksi'   // PK di transaksi
        );
    }



    public function kasir()
    {
        return $this->belongsTo(
            \App\Models\User::class,
            'kasir_id',
            'id'
        );
    }
}