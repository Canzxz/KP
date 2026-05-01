<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardStatsOverview;
use App\Filament\Widgets\InventoryStatusWidget;
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
            DashboardStatsOverview::class,
            TransaksiChart::class,
            RecentSalesWidget::class,
            InventoryStatusWidget::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return [
            'sm' => 1,
            'md' => 3,
            'xl' => 3,
        ];
    }
}
