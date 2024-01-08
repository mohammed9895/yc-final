<?php

namespace App\Filament\Resources\CybersecurityResource\Pages;

use App\Filament\Resources\CybersecurityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCybersecurities extends ListRecords
{
    protected static string $resource = CybersecurityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
