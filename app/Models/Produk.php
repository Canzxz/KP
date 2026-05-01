<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\FileUpload;

class Produk extends Model
{
   protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'nama_produk',
        'satuan',
        'harga',
        'stok',
        'gambar',
        'kategori_id'
    ];

    protected $casts = [
        'gambar' => 'array',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id_kategori');
    }

    public function riwayatStoks()
    {
        return $this->hasMany(RiwayatStok::class, 'produk_id', 'id_produk');
    }

    public function transaksiItems()
    {
        return $this->hasMany(TransaksiItem::class, 'produk_id', 'id_produk');
    }
    
}
