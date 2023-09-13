<?php

namespace App\Filament\Resources\TalentResource\Pages;

use App\Filament\Resources\TalentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTalent extends EditRecord
{
    protected static string $resource = TalentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
