<?php

namespace App\Filament\Resources\PathResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\PathResource;
use Filament\Resources\Pages\EditRecord;

class EditPath extends EditRecord
{
    protected static string $resource = PathResource::class;

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

        $icon = $data['icon'];
        $data['icon_en'] = $icon['en'];
        $data['icon_ar'] = $icon['ar'];

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $name_json = ['en' => $data['name_en'], 'ar' => $data['name_ar']];
        $data['name'] = $name_json;

        $description_json = ['en' => $data['description_en'], 'ar' => $data['description_ar']];
        $data['description'] = $description_json;

        $icon_json = ['en' => $data['icon_en'], 'ar' => $data['icon_ar']];
        $data['icon'] = $icon_json;


        $record->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'icon' => $data['icon'],
            'status' => $data['status']
        ]);

        return $record;
    }
}
