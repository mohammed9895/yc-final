<?php

namespace App\Filament\Resources\ThreeDResource\Pages;

use App\Filament\Resources\ThreeDResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListThreeDS extends ListRecords
{
    protected static string $resource = ThreeDResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
