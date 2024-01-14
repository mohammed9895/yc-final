<?php

namespace App\Filament\Resources\PhotographyCompetitionsResource\Pages;

use App\Filament\Resources\PhotographyCompetitionsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPhotographyCompetitions extends ListRecords
{
    protected static string $resource = PhotographyCompetitionsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
