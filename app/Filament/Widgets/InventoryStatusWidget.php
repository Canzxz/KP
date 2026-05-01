<?php

namespace App\Filament\Widgets;

use App\Models\Produk;
use Filament\Widgets\Widget;

class InventoryStatusWidget extends Widget
{
    protected static string $view = 'filament.widgets.inventory-status-widget';

    protected int | string | array $columnSpan = 1;

    protected static ?int $sort = 4;

    public function getInventoryData(): \Illuminate\Support\Collection
    {
        return Produk::orderBy('stok', 'asc')
            ->take(5)
            ->get();
    }
}
