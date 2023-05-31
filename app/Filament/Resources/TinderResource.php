<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TinderResource\Pages;
use App\Filament\Resources\TinderResource\RelationManagers;
use App\Models\Tender;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TinderResource extends Resource
{
    protected static ?string $model = Tender::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Heading')
                    ->tabs([
                        Tabs\Tab::make(__('english'))
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\TextInput::make('title_en')
                                    ->label(__('Title')),
                                Forms\Components\MarkdownEditor::make('description_en')
                                    ->label(__('description_en')),
                                Forms\Components\TextInput::make('value')->label(__('value_en')),
                                Forms\Components\FileUpload::make('document_en')->label(__('document_en'))->enableDownload()
                                    ->multiple(),
                                Forms\Components\DatePicker::make('tinder_date')->label(__('tinder_date')),
                                Toggle::make('status')->label(__('status'))
                            ]),
                        Tabs\Tab::make(__('arabic'))
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\TextInput::make('title_ar')
                                    ->label(__('title_ar')),
                                Forms\Components\MarkdownEditor::make('description_ar')
                                    ->label(__('description_ar')),
                                Forms\Components\FileUpload::make('document_ar')->label(__('document_ar'))->enableDownload()
                                    ->multiple(),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('value'),
//                Tables\Columns\TextColumn::make('document'),
                Tables\Columns\TextColumn::make('tinder_date'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListTinders::route('/'),
            'create' => Pages\CreateTinder::route('/create'),
            'edit' => Pages\EditTinder::route('/{record}/edit'),
        ];
    }
}
