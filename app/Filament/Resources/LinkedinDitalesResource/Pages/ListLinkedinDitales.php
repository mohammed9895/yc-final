<?php

namespace App\Filament\Resources\LinkedinDitalesResource\Pages;

use App\Filament\Resources\LinkedinDitalesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLinkedinDitales extends ListRecords
{
    protected static string $resource = LinkedinDitalesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
