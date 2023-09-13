<?php

namespace App\Filament\Resources\TalentRequestResource\Pages;

use App\Filament\Resources\TalentRequestResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTalentRequests extends ListRecords
{
    protected static string $resource = TalentRequestResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
