<?php

namespace App\Filament\Resources\StatisticeResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\StatisticeResource;

class CreateStatistice extends CreateRecord
{
    protected static string $resource = StatisticeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $title_json = ['en' => $data['title_en'], 'ar' => $data['title_ar']];
        $data['title'] = $title_json;

        $number_json = ['en' => $data['number_en'], 'ar' => $data['number_ar']];
        $data['number'] = $number_json;

        $icon_json = ['en' => $data['icon_en'], 'ar' => $data['icon_ar']];
        $data['icon'] = $icon_json;

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create([
            'title' => $data['title'],
            'number' => $data['number'],
            'icon' => $data['icon'],
            'status' => $data['status']
        ]);
    }
}
