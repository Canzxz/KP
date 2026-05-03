<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Widgets\ChartWidget;

class TransaksiChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Omzet (Rupiah)';
    protected static ?string $description = 'Laporan omzet transaksi mingguan';
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = null;
    protected static ?string $maxHeight = '240px';
    protected int | string | array $columnSpan = 5;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $data = Transaksi::selectRaw('
                YEAR(created_at) as tahun,
                WEEK(created_at, 1) as minggu,
                SUM(total) as total
            ')
            ->whereNotNull('total')
            ->groupBy('tahun', 'minggu')
            ->orderBy('tahun')
            ->orderBy('minggu')
            ->take(7)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Omzet Mingguan (Rp)',
                    'data' => $data->pluck('total')->map(fn ($v) => (float) $v),
                    'backgroundColor' => 'rgba(17, 82, 212, 0.3)',
                    'borderColor' => '#1152d4',
                    'borderWidth' => 2,
                    'borderRadius' => 8,
                    'borderSkipped' => false,
                    'hoverBackgroundColor' => '#1152d4',
                ],
            ],
            'labels' => $data->map(function ($item) {
                return 'Minggu ke-' . $item->minggu;
            }),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) {
                            return "Rp " + context.raw.toLocaleString();
                        }',
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(255, 255, 255, 0.05)',
                    ],
                    'ticks' => [
                        'color' => 'rgba(148, 163, 184, 1)',
                        'callback' => 'function(value) {
                            return "Rp " + (value / 1000000).toFixed(1) + "M";
                        }',
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'color' => 'rgba(148, 163, 184, 1)',
                    ],
                ],
            ],
        ];
    }
}
