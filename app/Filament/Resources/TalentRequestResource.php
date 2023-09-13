<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TalentRequestResource\Pages;
use App\Filament\Resources\TalentRequestResource\RelationManagers;
use App\Models\TalentRequest;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class TalentRequestResource extends Resource
{
    protected static ?string $model = TalentRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required(),
                Forms\Components\TextInput::make('talent_id')
                    ->required(),
                Forms\Components\TextInput::make('reason')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        0 => 'Waiting',
                        1 => 'Approved',
                        2 => 'Rejected',
                    ])
                    ->searchable()
                    ->required(),
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
                Tables\Columns\TextColumn::make('talent.user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->url(fn($record) => TalentResource::getUrl('edit', $record->talent_id))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('reason'),
                Tables\Columns\TextColumn::make('status')->enum([
                    0 => 'Waiting',
                    1 => 'Approved',
                    2 => 'Rejected',
                ]),
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
            'index' => Pages\ListTalentRequests::route('/'),
            'create' => Pages\CreateTalentRequest::route('/create'),
            'edit' => Pages\EditTalentRequest::route('/{record}/edit'),
        ];
    }
}
