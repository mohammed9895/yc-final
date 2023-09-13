<?php

namespace App\Filament\Resources\TalentTypeResource\Pages;

use App\Filament\Resources\TalentTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTalentTypes extends ListRecords
{
    protected static string $resource = TalentTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
