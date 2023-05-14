<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use App\Models\Slot;
use Filament\Tables;
use App\Models\Workshop;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SlotResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use App\Filament\Resources\SlotResource\RelationManagers;

class SlotResource extends Resource
{
    // use HasPageShield;
    protected static ?string $model = Slot::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationGroup(): ?string
    {
        return   __('workshops');
    }

    public static function getModelLabel(): string
    {
        return   __('slots');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('slots');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('workshop_id')
                    ->label(__('Workshop'))
                    ->options(Workshop::all()->pluck('title', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('start_date')
                    ->label(__('start_date'))
                    ->minDate(now()->today())
                    ->weekStartsOnSunday()
                    ->reactive()
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->label(__('end_date'))
                    ->minDate(function (callable $get) {
                        return Carbon::parse($get('start_date'));
                    })
                    ->weekStartsOnSunday()
                    ->required(),
                Forms\Components\TimePicker::make('start_time')
                    ->label(__('start_time'))
                    ->minDate(function (callable $get) {
                        if (Carbon::parse($get('start_date'))->isToday()) {
                            return now();
                        } else {
                            return null;
                        }
                    })
                    ->reactive()
                    ->required(),
                Forms\Components\TimePicker::make('end_time')
                    ->label(__('end_time'))
                    ->required()
                    ->minDate(function (callable $get) {
                        return Carbon::parse($get('start_time'));
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('workshop.title')->label(__('Workshop')),
                Tables\Columns\TextColumn::make('name')->label(__('Name')),
                Tables\Columns\TextColumn::make('start_date')->label(__('start_date'))
                    ->date(),
                Tables\Columns\TextColumn::make('end_date')->label(__('end_date'))
                    ->date(),
                Tables\Columns\TextColumn::make('start_time')->label(__('start_time')),
                Tables\Columns\TextColumn::make('end_time')->label(__('end_time')),
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
            RelationManagers\BookingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSlots::route('/'),
            'create' => Pages\CreateSlot::route('/create'),
            'edit' => Pages\EditSlot::route('/{record}/edit'),
        ];
    }
}
