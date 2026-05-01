<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Widgets\Widget;

class RecentSalesWidget extends Widget
{
    protected static string $view = 'filament.widgets.recent-sales-widget';

    protected int | string | array $columnSpan = 1;

    protected static ?int $sort = 3;

    public function getRecentSales(): \Illuminate\Support\Collection
    {
        return Transaksi::with(['kasir', 'items.produk'])
            ->latest()
            ->take(5)
            ->get();
    }
}
