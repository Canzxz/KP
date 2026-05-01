<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    protected $table = 'transaksi_items';

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'qty',
        'harga',
        'subtotal',
    ];

    public function produk()
    {
        return $this->belongsTo(
            \App\Models\Produk::class,
            'id_produk',   // FK di transaksi_items
            'id_produk'   // PK di produk
        );
    }
}