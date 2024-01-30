<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookConferenceResource\Pages;
use App\Filament\Resources\BookConferenceResource\RelationManagers;
use App\Models\BookConference;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class BookConferenceResource extends Resource
{
    protected static ?string $model = BookConference::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $slug = 'book-conference-resource';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('file')
                    ->required()
                    ->enableDownload(),
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
            'index' => Pages\ListBookConferences::route('/'),
            'create' => Pages\CreateBookConference::route('/create'),
            'edit' => Pages\EditBookConference::route('/{record}/edit'),
        ];
    }
}
