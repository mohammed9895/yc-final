<?php

namespace App\Filament\Resources\CybersecurityResource\Pages;

use App\Filament\Resources\CybersecurityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCybersecurity extends EditRecord
{
    protected static string $resource = CybersecurityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
