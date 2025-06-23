<?php
// filepath: c:\laragon\www\jastipku\app\Filament\Widgets\StatsOverview.php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pesanan', Order::count())
                ->description('Semua pesanan')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),

            Stat::make('Pesanan Pending', Order::where('status', 'pending')->count())
                ->description('Menunggu traveler')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Pesanan Aktif', Order::whereIn('status', ['accepted', 'in_progress'])->count())
                ->description('Sedang diproses')
                ->descriptionIcon('heroicon-m-cog-6-tooth')
                ->color('info'),

            Stat::make('Pesanan Selesai', Order::where('status', 'completed')->count())
                ->description('Berhasil diselesaikan')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Users', User::count())
                ->description('Semua pengguna')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Total Travelers', User::where('role', 'traveler')->count())
                ->description('Traveler aktif')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Total Customers', User::where('role', 'penitip')->count())
                ->description('Customer terdaftar')
                ->descriptionIcon('heroicon-m-user-circle')
                ->color('info'),

            Stat::make('Total Revenue', 'Rp ' . number_format(Order::where('status', 'completed')->sum('ongkos_jasa') ?? 0, 0, ',', '.'))
                ->description('Total ongkos jasa')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
