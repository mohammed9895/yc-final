<?php

namespace App\Filament\Resources\BookConferenceResource\Pages;

use App\Filament\Resources\BookConferenceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookConferences extends ListRecords
{
    protected static string $resource = BookConferenceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
