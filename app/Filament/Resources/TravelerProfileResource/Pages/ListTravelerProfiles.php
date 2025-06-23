<?php

namespace App\Filament\Resources\TravelerProfileResource\Pages;

use App\Filament\Resources\TravelerProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTravelerProfiles extends ListRecords
{
    protected static string $resource = TravelerProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
