<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingAlppicationResource\Pages;
use App\Filament\Resources\TrainingAlppicationResource\RelationManagers;
use App\Models\Booking;
use App\Models\Slot;
use App\Models\TrainingApplication;
use App\Models\User;
use App\Models\Workshop;
use App\Notifications\SmsMessage;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class TrainingAlppicationResource extends Resource
{
    protected static ?string $model = TrainingApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required(),
                Forms\Components\TextInput::make('province_id')
                    ->required(),
                Forms\Components\TextInput::make('education_type_id')
                    ->required(),
                Forms\Components\TextInput::make('employee_type_id')
                    ->required(),
                Forms\Components\TextInput::make('cv')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label(__('User'))
                    ->url(fn ($record) => UserResource::getUrl('view', $record->user_id))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('province.name'),
                Tables\Columns\TextColumn::make('educationType.name'),
                Tables\Columns\TextColumn::make('employeeType.name'),
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
                Action::make('download')->action('approve')
                    ->label(__('Download CV'))
                    ->action(function (TrainingApplication $record) {
                        $outputFile = Storage::disk('local')->path("/public/" .$record->cv);
                        return Response::download($outputFile, $record->user->name . '_cv.pdf');
                    }),
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
            'index' => Pages\ListTrainingAlppications::route('/'),
            'create' => Pages\CreateTrainingAlppication::route('/create'),
            'edit' => Pages\EditTrainingAlppication::route('/{record}/edit'),
        ];
    }
}
