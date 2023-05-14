<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\ThreeD;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ThreeDResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ThreeDResource\RelationManagers;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;

class ThreeDResource extends Resource
{
    protected static ?string $model = ThreeD::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label(__('User'))
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Textarea::make('file_description')
                    ->label(__('File Description'))
                    ->required(),
                TimePicker::make('duration')->label(__('duration'))->required(),
                TextInput::make('weight')->label('weight')->required(),
                TextInput::make('purpose')->label('purpose')->required(),
                Select::make('status')
                    ->options([
                        0 => __('Waiting'),
                        1 => __('Rejected'),
                        2 => __('Approvied')
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label(__('User')),
                TextColumn::make('file_description')->label(__('File Description')),
                TextColumn::make('duration')->label(__('File Description')),
                TextColumn::make('weight')->label('weight'),
                TextColumn::make('purpose')->label('purpose'),
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
            'index' => Pages\ListThreeDS::route('/'),
            'create' => Pages\CreateThreeD::route('/create'),
            'edit' => Pages\EditThreeD::route('/{record}/edit'),
        ];
    }
}
