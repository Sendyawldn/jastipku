<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'penitip' => Tab::make('Penitip')
                ->icon('heroicon-o-user-group')
                ->badge(fn() => User::where('role', 'penitip')->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('role', 'penitip')),
            'traveler' => Tab::make('Traveler')
                ->icon('heroicon-o-truck')
                ->badge(fn() => User::where('role', 'traveler')->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('role', 'traveler')),
        ];
    }
}
