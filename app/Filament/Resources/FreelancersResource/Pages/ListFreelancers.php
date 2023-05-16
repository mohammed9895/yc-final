<?php

namespace App\Filament\Resources\FreelancersResource\Pages;

use App\Filament\Resources\FreelancersResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFreelancers extends ListRecords
{
    protected static string $resource = FreelancersResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
