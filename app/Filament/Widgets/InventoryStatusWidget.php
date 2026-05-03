<?php

namespace App\Filament\Widgets;

use App\Models\Produk;
use Filament\Widgets\Widget;

class InventoryStatusWidget extends Widget
{
    protected static string $view = 'filament.widgets.inventory-status-widget';

    protected int | string | array $columnSpan = 5;

    protected static ?int $sort = 4;

    public function getInventoryData(): \Illuminate\Support\Collection
    {
        return Produk::orderBy('stok', 'asc')
            ->take(4)
            ->get();
    }
}
