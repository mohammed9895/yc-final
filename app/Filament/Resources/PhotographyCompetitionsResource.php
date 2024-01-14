<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhotographyCompetitionsResource\Pages;
use App\Filament\Resources\PhotographyCompetitionsResource\RelationManagers;
use App\Models\PhotographyCompetition;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PhotographyCompetitionsResource extends Resource
{
    protected static ?string $model = PhotographyCompetition::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('images')->enableDownload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->url(fn($record) => UserResource::getUrl('view', $record->user_id))
                    ->openUrlInNewTab(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPhotographyCompetitions::route('/'),
            'create' => Pages\CreatePhotographyCompetitions::route('/create'),
            'edit' => Pages\EditPhotographyCompetitions::route('/{record}/edit'),
        ];
    }
}
