<?php

namespace App\Filament\Resources\TinderResource\Pages;

use App\Filament\Resources\TinderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTinder extends EditRecord
{
    protected static string $resource = TinderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {

        $titles = $data['title'];
        if ($titles) {
            $data['title_en'] = $titles['en'];
            $data['title_ar'] = $titles['ar'];
        }


        $descriptions = $data['description'];
        if ($descriptions) {
            $data['description_en'] = $descriptions['en'];
            $data['description_ar'] = $descriptions['ar'];
        }


        $document = $data['document'];
        if ($document) {
            $data['document_en'] = $document['en'];
            $data['document_ar'] = $document['ar'];
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $title_json = ['en' => $data['title_en'], 'ar' => $data['title_ar']];
        $data['title'] = $title_json;

        $description_json = ['en' => $data['description_en'], 'ar' => $data['description_ar']];
        $data['description'] = $description_json;


        $document_json = ['en' => $data['document_en'], 'ar' => $data['document_ar']];
        $data['document'] = $document_json;


        $record->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'value' => $data['value'],
            'document' => $data['document'],
            'tender_date' => $data['tinder_date'],
            'status' => $data['status'],
        ]);

        return $record;
    }
}
