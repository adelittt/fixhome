<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class RevenueChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Tren Transaksi Lunas (7 Hari Terakhir)';

    protected static ?string $description = 'Perbandingan total transaksi masuk dan komisi platform 5% per hari.';

    protected static ?int $sort = 2;

    protected static ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $start = now()->subDays(6)->startOfDay();
        $transactions = Transaksi::where('status_pembayaran', 'paid')
            ->where('created_at', '>=', $start)
            ->get(['gross_amount', 'komisi_admin', 'created_at']);

        $labels = [];
        $grossSeries = [];
        $komisiSeries = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $dayKey = $day->format('Y-m-d');
            $labels[] = $day->translatedFormat('d M');

            $dayItems = $transactions->filter(
                fn ($t) => $t->created_at && Carbon::parse($t->created_at)->format('Y-m-d') === $dayKey
            );

            $grossSeries[] = (float) $dayItems->sum('gross_amount');
            $komisiSeries[] = (float) $dayItems->sum('komisi_admin');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Transaksi (Rp)',
                    'data' => $grossSeries,
                    'backgroundColor' => 'rgba(156, 170, 82, 0.22)',
                    'borderColor' => '#7F8F3C',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.35,
                ],
                [
                    'label' => 'Komisi Platform 5% (Rp)',
                    'data' => $komisiSeries,
                    'backgroundColor' => 'rgba(249, 199, 68, 0.28)',
                    'borderColor' => '#E5A910',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
