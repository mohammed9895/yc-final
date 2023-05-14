<?php

namespace App\Filament\Resources\SlotResource\RelationManagers;

use Filament\Forms;
use App\Models\Slot;
use App\Models\User;
use Filament\Tables;
use App\Models\Workshop;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class BookingsRelationManager extends RelationManager
{
    protected static string $relationship = 'bookings';

    protected static ?string $recordTitleAttribute = 'user_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('workshop_id')->options(Workshop::all()->pluck('title', 'id'))->searchable()->label('Workshop')
                    ->required(),
                Forms\Components\Select::make('slot_id')->options(Slot::all()->pluck('name', 'id'))->searchable()->label('Slot')
                    ->required(),
                Forms\Components\Select::make('user_id')->options(User::all()->pluck('name', 'id'))->searchable()->label('User')
                    ->required(),
                Forms\Components\TextInput::make('reasone')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('rejection_message')
                    ->maxLength(255),
                Forms\Components\Select::make('status')->options([
                    0 => 'Waiting',
                    1 => 'Rejected',
                    2 => 'Approvied'
                ])->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('workshop.title'),
                Tables\Columns\TextColumn::make('slot.name'),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('reasone'),
                Tables\Columns\TextColumn::make('rejection_message'),
                Tables\Columns\BadgeColumn::make('status')->enum([
                    0 => 'Waiting',
                    1 => 'Rejected',
                    2 => 'Approvied'
                ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
