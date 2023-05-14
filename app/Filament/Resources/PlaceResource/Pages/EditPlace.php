<?php

namespace App\Filament\Resources\PlaceResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PlaceResource;

class EditPlace extends EditRecord
{
    protected static string $resource = PlaceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $names = $data['name'];
        $data['name_en'] = $names['en'];
        $data['name_ar'] = $names['ar'];
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $input_json = ['en' => $data['name_en'], 'ar' => $data['name_ar']];

        $data['name'] = $input_json;
        $record->update([
            'name' => $data['name']
        ]);

        return $record;
    }
}
