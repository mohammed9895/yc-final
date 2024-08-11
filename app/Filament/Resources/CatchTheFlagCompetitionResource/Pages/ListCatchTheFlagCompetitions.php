<?php

namespace App\Filament\Resources\CatchTheFlagCompetitionResource\Pages;

use App\Filament\Resources\CatchTheFlagCompetitionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCatchTheFlagCompetitions extends ListRecords
{
    protected static string $resource = CatchTheFlagCompetitionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
