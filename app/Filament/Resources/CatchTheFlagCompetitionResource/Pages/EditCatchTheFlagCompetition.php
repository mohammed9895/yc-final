<?php

namespace App\Filament\Resources\CatchTheFlagCompetitionResource\Pages;

use App\Filament\Resources\CatchTheFlagCompetitionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatchTheFlagCompetition extends EditRecord
{
    protected static string $resource = CatchTheFlagCompetitionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
