<?php
// filepath: app/Filament/Widgets/UserRoleChart.php

namespace App\Filament\Widgets;

use App\Models\User; // Import model User
use Filament\Widgets\ChartWidget;

class UserRoleChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Peran Pengguna'; // Judul chart
    protected static ?int $sort = 3; // Urutan di dashboard, setelah OrderStatusChart

    protected function getType(): string
    {
        return 'pie'; // Tipe chart: pie
    }

    protected function getData(): array
    {
        // Ambil data jumlah user berdasarkan peran (role)
        $data = User::query()
            ->selectRaw("COUNT(*) as count, role")
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();

        // Siapkan data untuk Chart.js
        $labels = [];
        $counts = [];
        $colors = [];

        // Definisikan mapping untuk peran pengguna dan warna
        $roleMapping = [
            'penitip' => ['Customer', '#3b82f6'], // Biru untuk Customer
            'traveler' => ['Traveler', '#10b981'], // Hijau untuk Traveler
        ];

        foreach ($roleMapping as $roleKey => $roleInfo) {
            $labels[] = $roleInfo[0];
            $counts[] = $data[$roleKey] ?? 0; // Ambil count, jika tidak ada, set 0
            $colors[] = $roleInfo[1];
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Pengguna',
                    'data' => $counts,
                    'backgroundColor' => $colors,
                    'hoverOffset' => 4,
                ],
            ],
        ];
    }
}
