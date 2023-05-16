<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Slot;
use Filament\Tables;
use App\Models\Evaluate;
use App\Models\Workshop;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EvaluateResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EvaluateResource\RelationManagers;

class EvaluateResource extends Resource
{
    protected static ?string $model = Evaluate::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationGroup(): ?string
    {
        return   __('workshops');
    }

    public static function getModelLabel(): string
    {
        return   __('evaluates');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('evaluates');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->label(__('User'))
                    ->required(),
                Forms\Components\TextInput::make('workshop_id')
                    ->label(__('Workshop'))
                    ->required(),
                Forms\Components\TextInput::make('rating')
                    ->label(__('rating'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('instructor')
                    ->label(__('instructor'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('duration')
                    ->label(__('duration'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sutsfing')
                    ->label(__('sutsfing'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('devloped')
                    ->label(__('devloped'))
                    ->required()
                    ->maxLength(65535),
                Forms\Components\Textarea::make('suggestions')
                    ->label(__('suggestions'))
                    ->required()
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->searchable()->label(__('User')),
                Tables\Columns\TextColumn::make('workshop.title')->searchable()->sortable()->label(__('Workshop')),
                Tables\Columns\TextColumn::make('rating')->searchable()->sortable()->label(__('rating')),
                Tables\Columns\TextColumn::make('instructor')->searchable()->sortable()->label(__('instructor')),
                Tables\Columns\TextColumn::make('duration')->searchable()->sortable()->label(__('duration')),
                Tables\Columns\TextColumn::make('sutsfing')->searchable()->sortable()->label(__('sutsfing')),
                Tables\Columns\TextColumn::make('devloped')->searchable()->label(__('devloped')),
                Tables\Columns\TextColumn::make('suggestions')->searchable()->label(__('suggestions')),
                Tables\Columns\TextColumn::make('created_at')->searchable()->sortable()->label(__('created_at'))
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('workshop_id')
                    ->multiple()
                    ->label(__('Workshop'))
                    ->options(Workshop::all()->pluck('title', 'id')),
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvaluates::route('/'),
        ];
    }
}
