<?php

namespace App\Filament\Resources\GCCCampResource\Pages;

use App\Filament\Resources\GCCCampResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGCCCamp extends EditRecord
{
    protected static string $resource = GCCCampResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
