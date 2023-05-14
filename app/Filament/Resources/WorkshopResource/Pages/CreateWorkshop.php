<?php

namespace App\Filament\Resources\WorkshopResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\WorkshopResource;
use Guava\FilamentDrafts\Admin\Resources\Pages\Create\Draftable;


class CreateWorkshop extends CreateRecord
{
    protected static string $resource = WorkshopResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'conditions' => $data['conditions'],
            'slug' => $data['slug'],
            'cover' => $data['cover'],
            'questions' => $data['questions'],
            'has_questions' => $data['has_questions'],
            'capacity' => $data['capacity'],
            'place_id' => $data['place_id'],
            'user_id' => $data['user_id'],
            'path_id' => $data['path_id'],
            'hall_id' => $data['hall_id'],
            'status' => $data['status'],
            // 'is_current' => $data['is_current'],
            // 'publisher_id' => $data['publisher_id'],
            // 'publisher_type' => $data['publisher_type'],
            // 'uuid' => $data['uuid'],
            // 'published_at' => $data['published_at'],
            // 'is_published' => $data['is_published'],
        ]);
    }
}
