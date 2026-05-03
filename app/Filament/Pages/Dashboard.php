<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardStatsOverview;
use App\Filament\Widgets\InventoryStatusWidget;
use App\Filament\Widgets\KasirWidget;
use App\Filament\Widgets\RecentSalesWidget;
use App\Filament\Widgets\TransaksiChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static string $view = 'filament.pages.dashboard';

    public static function getDefaultWidgets(): array
    {
        return [];
    }

    public function getHeaderWidgets(): array
    {
        return [];
    }

    public function getWidgets(): array
    {
        return [
            DashboardStatsOverview::class, // sort 0 - full width di atas
            KasirWidget::class,            // sort 1 - kolom kiri (7/12)
            TransaksiChart::class,         // sort 2 - kolom kanan (5/12)
            RecentSalesWidget::class,      // sort 3 - kolom kanan (5/12)
            InventoryStatusWidget::class,  // sort 4 - kolom kanan (5/12)
        ];
    }

    public function getColumns(): int | string | array
    {
        return 1; // Layout dikendalikan oleh custom blade view
    }
}
