<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Widgets\ChartWidget;

class TransaksiChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Omzet (Rupiah)';
    protected static ?string $description = 'Laporan omzet transaksi bulanan';
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = null;
    protected static ?string $maxHeight = '240px';
    protected int | string | array $columnSpan = 5;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = Transaksi::selectRaw('
                MONTH(created_at) as bulan,
                SUM(total) as total
            ')
            ->whereYear('created_at', now()->year)
            ->whereNotNull('total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $totals = [];

        foreach (range(1, 12) as $monthNumber) {
            $totals[] = isset($data[$monthNumber]) ? ((float) $data[$monthNumber]->total) / 1000000 : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Omzet Bulanan (Juta Rp)',
                    'data' => $totals,
                    'backgroundColor' => 'rgba(17, 82, 212, 0.3)',
                    'borderColor' => '#1152d4',
                    'borderWidth' => 2,
                    'borderRadius' => 8,
                    'borderSkipped' => false,
                    'hoverBackgroundColor' => '#1152d4',
                ],
            ],
            'labels' => $labels,
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
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(255, 255, 255, 0.05)',
                    ],
                    'ticks' => [
                        'stepSize' => 5,
                        'color' => 'rgba(148, 163, 184, 1)',
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
