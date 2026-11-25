<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;

class OrderStatusChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Status Pesanan';

    protected static ?string $description = 'Sebaran seluruh pesanan berdasarkan tahapan pengerjaan saat ini.';

    protected static ?int $sort = 3;

    protected static ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $counts = Booking::selectRaw('status_order, COUNT(*) as total')
            ->groupBy('status_order')
            ->pluck('total', 'status_order');

        $statuses = [
            'pending_payment' => ['label' => 'Menunggu Bayar', 'color' => '#F9C744'],
            'paid' => ['label' => 'Lunas (Siap OTW)', 'color' => '#B1BA67'],
            'otw' => ['label' => 'Teknisi OTW', 'color' => '#9CAA52'],
            'working' => ['label' => 'Sedang Dikerjakan', 'color' => '#7F8F3C'],
            'completed' => ['label' => 'Selesai', 'color' => '#4E5E24'],
            'cancelled' => ['label' => 'Dibatalkan', 'color' => '#DC2626'],
        ];

        $labels = [];
        $data = [];
        $colors = [];

        foreach ($statuses as $key => $meta) {
            $val = (int) ($counts[$key] ?? 0);
            if ($val > 0) {
                $labels[] = $meta['label'] . " ({$val})";
                $data[] = $val;
                $colors[] = $meta['color'];
            }
        }

        if (empty($data)) {
            $labels = ['Belum ada pesanan'];
            $data = [1];
            $colors = ['#E2E8F0'];
        }

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
