<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\CatchTheFlagCompetitionResource\Pages;
use App\Filament\Resources\CatchTheFlagCompetitionResource\RelationManagers;
use App\Models\CatchTheFlagCompetition;
use Carbon\Carbon;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class CatchTheFlagCompetitionResource extends Resource
{
    protected static ?string $model = CatchTheFlagCompetition::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
                Tables\Columns\TextColumn::make('user.phone')->searchable()->label('Phone'),
                Tables\Columns\TextColumn::make('user.email')->searchable()->label('Email'),
                Tables\Columns\BadgeColumn::make('user.gender')
                    ->enum([
                        0 => 'Male',
                        1 => 'Female'
                    ])->searchable()
                    ->label(__('filament::users.sex'))->sortable(),
                TextColumn::make('user.birth_date')->label(__('Age'))->formatStateUsing(fn(string $state): string => Carbon::parse($state)->age),
                Tables\Columns\TextColumn::make('previous_participation'),
                Tables\Columns\TextColumn::make('open_source_usage'),
                Tables\Columns\TextColumn::make('kali_linux_usage'),
                Tables\Columns\TextColumn::make('ethical_hacking_definition'),
                Tables\Columns\TextColumn::make('network_scanning_tool'),
                Tables\Columns\TextColumn::make('password_cracking_tool'),
                Tables\Columns\TextColumn::make('cyber_attack_type'),
                Tables\Columns\TextColumn::make('metasploit_usage'),
                Tables\Columns\TextColumn::make('other_os_for_pentesting'),
                Tables\Columns\TextColumn::make('hashing_algorithm'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                FilamentExportBulkAction::make('export'),
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
            'index' => Pages\ListCatchTheFlagCompetitions::route('/'),
            'create' => Pages\CreateCatchTheFlagCompetition::route('/create'),
            'edit' => Pages\EditCatchTheFlagCompetition::route('/{record}/edit'),
        ];
    }
}
