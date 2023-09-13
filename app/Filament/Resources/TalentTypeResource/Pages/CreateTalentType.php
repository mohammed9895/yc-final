<?php

namespace App\Filament\Resources\TalentTypeResource\Pages;

use App\Filament\Resources\TalentTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTalentType extends CreateRecord
{
    protected static string $resource = TalentTypeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $input_json = ['en' => $data['name_en'], 'ar' => $data['name_ar']];

        $data['name'] = $input_json;
        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create([
            'name' => $data['name'],
            'icon' => $data['icon'],
        ]);
    }
}
