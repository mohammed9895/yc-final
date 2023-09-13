<?php

namespace App\Filament\Resources\TalentRequestResource\Pages;

use App\Filament\Resources\TalentRequestResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTalentRequest extends EditRecord
{
    protected static string $resource = TalentRequestResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
