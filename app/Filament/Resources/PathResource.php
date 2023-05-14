<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PathResource\Pages;
use App\Filament\Resources\PathResource\RelationManagers;
use App\Models\Path;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PathResource extends Resource
{
    protected static ?string $model = Path::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';


    public static function getModelLabel(): string
    {
        return   __('paths');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('paths');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_en')
                    ->label(__('name_en'))
                    ->required(),
                Forms\Components\TextInput::make('name_ar')
                    ->label(__('name_ar'))
                    ->required(),
                Textarea::make('description_en')->required()->label(__('description_en')),
                Textarea::make('description_ar')->required()->label(__('description_ar')),
                Forms\Components\FileUpload::make('icon_en')
                    ->label(__('icon_en'))
                    ->directory('paths/en')
                    ->enableOpen()
                    ->enableDownload()
                    ->required(),
                Forms\Components\FileUpload::make('icon_ar')
                    ->label(__('icon_ar'))
                    ->directory('paths/ar')
                    ->enableOpen()
                    ->enableDownload()
                    ->required(),
                Forms\Components\Toggle::make('status')
                    ->label(__('status'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('Name')),
                Tables\Columns\ImageColumn::make('icon')->label(__('icon')),
                Tables\Columns\TextColumn::make('status')->label(__('status')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('updated_at'))
                    ->dateTime(),
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
            'index' => Pages\ListPaths::route('/'),
            'create' => Pages\CreatePath::route('/create'),
            'edit' => Pages\EditPath::route('/{record}/edit'),
        ];
    }
}
