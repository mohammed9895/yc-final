<?php

namespace App\Filament\Resources\TamkeenResource\Pages;

use App\Filament\Resources\TamkeenResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTamkeen extends EditRecord
{
    protected static string $resource = TamkeenResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
