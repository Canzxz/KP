<?php

namespace App\Filament\Widgets;

use App\Models\Produk;
use App\Models\Transaksi;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = -1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalProduk = Produk::count();
        $weeklyTransactions = Transaksi::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $weeklyRevenue = Transaksi::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total');

        return [
            Stat::make('Total Produk', $totalProduk . ' Item')
                ->description('Jumlah produk terdaftar')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info')
                ->chart([5, 8, 12, 10, 15, 18, 20]),

            Stat::make('Transaksi Minggu Ini', $weeklyTransactions . ' Order')
                ->description('Total order minggu ini')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary')
                ->chart([7, 3, 4, 5, 6, 3, 5]),

            Stat::make('Pendapatan Minggu Ini', 'Rp ' . number_format($weeklyRevenue, 0, ',', '.'))
                ->description('Estimasi pendapatan')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->chart([3, 5, 7, 4, 6, 8, 5]),
        ];
    }
}
