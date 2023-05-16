<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Statistice;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StatisticeResource\Pages;
use App\Filament\Resources\StatisticeResource\RelationManagers;

class StatisticeResource extends Resource
{
    protected static ?string $model = Statistice::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationGroup(): ?string
    {
        return   __('settings');
    }

    public static function getModelLabel(): string
    {
        return   __('statistices');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('statistices');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('About')
                    ->tabs([
                        Tabs\Tab::make(__('english'))
                            ->schema([
                                Forms\Components\TextInput::make('title_en')
                                    ->label(__('title_en'))
                                    ->required(),
                                Forms\Components\TextInput::make('number_en')
                                    ->label(__('number_en'))
                                    ->required(),
                                Forms\Components\FileUpload::make('icon_en')
                                    ->label(__('icon_en'))
                                    ->required(),
                                Forms\Components\Toggle::make('status')
                                    ->label(__('status'))
                                    ->required(),
                            ]),
                        Tabs\Tab::make(__('arabic'))
                            ->schema([
                                Forms\Components\TextInput::make('title_ar')
                                    ->label(__('title_ar'))
                                    ->required(),
                                Forms\Components\TextInput::make('number_ar')
                                    ->label(__('number_ar'))
                                    ->required(),
                                Forms\Components\FileUpload::make('icon_ar')
                                    ->label(__('icon_ar'))
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label(__('title')),
                Tables\Columns\TextColumn::make('number')->label(__('number')),
                Tables\Columns\ImageColumn::make('icon')->label(__('icon')),
                Tables\Columns\TextColumn::make('status')->label(__('status')),
                Tables\Columns\TextColumn::make('created_at')->label(__('created_at'))
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->label(__('updated_at'))
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
            'index' => Pages\ListStatistices::route('/'),
            'create' => Pages\CreateStatistice::route('/create'),
            'edit' => Pages\EditStatistice::route('/{record}/edit'),
        ];
    }
}
