<?php

namespace App\Filament\Resources\FreelancersResource\Pages;

use App\Filament\Resources\FreelancersResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFreelancers extends EditRecord
{
    protected static string $resource = FreelancersResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
