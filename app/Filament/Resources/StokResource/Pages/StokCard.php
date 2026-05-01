<?php

namespace App\Filament\Resources\StokResource\Pages;

use App\Filament\Resources\StokResource;
use Filament\Resources\Pages\Page;
use App\Models\Produk;

class StokCard extends Page
{
    protected static string $resource = StokResource::class;

    protected static string $view = 'filament.stok-card';

    public string $search = '';

    public function getViewData(): array
    {
        return [
            'produks' => Produk::query()
                ->when($this->search, fn ($q) =>
                    $q->where('nama_produk', 'like', '%' . $this->search . '%')
                )
                ->orderBy('nama_produk')
                ->get(),
        ];
    }
}
