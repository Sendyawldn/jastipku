<?php

namespace App\Filament\Resources\TravelerProfileResource\Pages;

use App\Filament\Resources\TravelerProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTravelerProfile extends EditRecord
{
    protected static string $resource = TravelerProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
