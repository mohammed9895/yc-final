<?php

namespace App\Filament\Resources\HallResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\HallResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHall extends CreateRecord
{
    protected static string $resource = HallResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $name_json = ['en' => $data['name_en'], 'ar' => $data['name_ar']];
        $data['name'] = $name_json;

        $description_json = ['en' => $data['description_en'], 'ar' => $data['description_ar']];
        $data['description'] = $description_json;

        $conditions_json = ['en' => $data['conditions_en'], 'ar' => $data['conditions_ar']];
        $data['conditions'] = $conditions_json;

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'conditions' => $data['conditions'],
            'capacity' => $data['capacity'],
            'backgroundColor' => $data['backgroundColor'],
            'status' => $data['status']
        ]);
    }
}
