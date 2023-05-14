<?php

namespace App\Filament\Resources\ThreeDResource\Pages;

use App\Filament\Resources\ThreeDResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditThreeD extends EditRecord
{
    protected static string $resource = ThreeDResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
