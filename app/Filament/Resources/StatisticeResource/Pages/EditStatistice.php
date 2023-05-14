<?php

namespace App\Filament\Resources\StatisticeResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\StatisticeResource;

class EditStatistice extends EditRecord
{
    protected static string $resource = StatisticeResource::class;


    protected function mutateFormDataBeforeFill(array $data): array
    {

        $titles = $data['title'];
        $data['title_en'] = $titles['en'];
        $data['title_ar'] = $titles['ar'];

        $descriptions = $data['number'];
        $data['number_en'] = $descriptions['en'];
        $data['number_ar'] = $descriptions['ar'];

        $icon = $data['icon'];
        $data['icon_en'] = $icon['en'];
        $data['icon_ar'] = $icon['ar'];

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $title_json = ['en' => $data['title_en'], 'ar' => $data['title_ar']];
        $data['title'] = $title_json;

        $number_json = ['en' => $data['number_en'], 'ar' => $data['number_ar']];
        $data['number'] = $number_json;

        $icon_json = ['en' => $data['icon_en'], 'ar' => $data['icon_ar']];
        $data['icon'] = $icon_json;

        $record->update([
            'title' => $data['title'],
            'number' => $data['number'],
            'icon' => $data['icon'],
            'status' => $data['status']
        ]);

        return $record;
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
