<?php
// filepath: app/Filament/Widgets/OrderStatusChart.php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrderStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Status Pesanan';

    protected static ?int $sort = 2; // Adjust sort order as needed

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getData(): array
    {
        $data = Order::query()
            ->selectRaw("COUNT(*) as count, status")
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Prepare data for Chart.js
        $labels = [];
        $counts = [];
        $colors = [];

        $statusMapping = [
            'pending' => ['Pending', '#f0b429'], // Warning
            'accepted' => ['Diterima', '#3b82f6'], // Primary
            'in_progress' => ['Diproses', '#6366f1'], // Info
            'completed' => ['Selesai', '#10b981'], // Success
            'cancelled' => ['Dibatalkan', '#ef4444'], // Danger
        ];

        foreach ($statusMapping as $statusKey => $statusInfo) {
            $labels[] = $statusInfo[0];
            $counts[] = $data[$statusKey] ?? 0;
            $colors[] = $statusInfo[1];
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Pesanan',
                    'data' => $counts,
                    'backgroundColor' => $colors,
                    'hoverOffset' => 4,
                ],
            ],
        ];
    }
}
