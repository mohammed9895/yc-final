<?php

namespace App\Filament\Resources\HallResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\HallResource;
use Filament\Resources\Pages\EditRecord;

class EditHall extends EditRecord
{
    protected static string $resource = HallResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {

        $titles = $data['name'];
        $data['name_en'] = $titles['en'];
        $data['name_ar'] = $titles['ar'];

        $descriptions = $data['description'];
        $data['description_en'] = $descriptions['en'];
        $data['description_ar'] = $descriptions['ar'];

        $conditions = $data['conditions'];
        $data['conditions_en'] = $conditions['en'];
        $data['conditions_ar'] = $conditions['ar'];

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $name_json = ['en' => $data['name_en'], 'ar' => $data['name_ar']];
        $data['name'] = $name_json;

        $description_json = ['en' => $data['description_en'], 'ar' => $data['description_ar']];
        $data['description'] = $description_json;

        $conditions_json = ['en' => $data['conditions_en'], 'ar' => $data['conditions_ar']];
        $data['conditions'] = $conditions_json;


        $record->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'conditions' => $data['conditions'],
            'capacity' => $data['capacity'],
            'backgroundColor' => $data['backgroundColor'],
            'status' => $data['status'],
        ]);

        return $record;
    }
}
