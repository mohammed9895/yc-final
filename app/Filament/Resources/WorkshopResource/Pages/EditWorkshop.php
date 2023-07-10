<?php

namespace App\Filament\Resources\WorkshopResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\WorkshopResource;
use Guava\FilamentDrafts\Admin\Resources\Pages\Edit\Draftable;

class EditWorkshop extends EditRecord
{

    protected static string $resource = WorkshopResource::class;

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
            $data['title_en'] = $titles['en'] ?? '';
            $data['title_ar'] = $titles['ar'] ?? '';
        }

        $slugs = $data['slug'];
        if ($slugs) {
            $data['slug'] = $slugs['en'] ?? '';
        }

        $descriptions = $data['description'];
        if ($descriptions) {
            $data['description_en'] = $descriptions['en'] ?? '';
            $data['description_ar'] = $descriptions['ar'] ?? '';
        }

        $conditions = $data['conditions'];
        if ($conditions) {
            $data['conditions_en'] = $conditions['en'] ?? '';
            $data['conditions_ar'] = $conditions['ar'] ?? '';
        }


        $covers = $data['cover'];
        if ($covers) {
            $data['cover_en'] = $covers['en'] ?? '';
            $data['cover_ar'] = $covers['ar'] ?? '';
        }

        $questions = $data['questions'];
        if ($questions !== NULL) {
            $data['question_en'] = $questions['en'] ?? '';
            $data['question_ar'] = $questions['ar'] ?? '';
        }
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $title_json = ['en' => $data['title_en'], 'ar' => $data['title_ar']];
        $data['title'] = $title_json;

        $description_json = ['en' => $data['description_en'], 'ar' => $data['description_ar']];
        $data['description'] = $description_json;

        $conditions_json = ['en' => $data['conditions_en'], 'ar' => $data['conditions_ar']];
        $data['conditions'] = $conditions_json;

        $slug_json = ['en' => $data['slug'], 'ar' => $data['slug']];
        $data['slug'] = $slug_json;

        $cover_json = ['en' => $data['cover_en'], 'ar' => $data['cover_ar']];
        $data['cover'] = $cover_json;

        $questions_json = ['en' => $data['question_en'], 'ar' => $data['question_ar']];
        $data['questions'] = $questions_json;

        $record->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'conditions' => $data['conditions'],
            'slug' => $data['slug'],
            'cover' => $data['cover'],
            'days' => $data['days'],
            'questions' => $data['questions'],
            'has_questions' => $data['has_questions'],
            'capacity' => $data['capacity'],
            'place_id' => $data['place_id'],
            'user_id' => $data['user_id'],
            'path_id' => $data['path_id'],
            'hall_id' => $data['hall_id'],
            'status' => $data['status'],
        ]);

        return $record;
    }
}
