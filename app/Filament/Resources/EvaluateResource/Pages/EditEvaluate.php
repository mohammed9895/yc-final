<?php

namespace App\Filament\Resources\EvaluateResource\Pages;

use App\Filament\Resources\EvaluateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvaluate extends EditRecord
{
    protected static string $resource = EvaluateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
