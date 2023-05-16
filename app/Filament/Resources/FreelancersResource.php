<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Freelancers;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FreelancersResource\Pages;
use App\Filament\Resources\FreelancersResource\RelationManagers;
use App\Models\Field;

class FreelancersResource extends Resource
{
    protected static ?string $model = Freelancers::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationGroup(): ?string
    {
        return   __('companies');
    }

    public static function getModelLabel(): string
    {
        return   __('freelancers');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('freelancers');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label(__('User'))
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\FileUpload::make('civil_copy')
                    ->label(__('Civil Copy'))
                    ->enableDownload()
                    ->required(),
                Select::make('field_id')
                    ->label(__('Field'))
                    ->options(Field::where('type', 'freelancer')
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\FileUpload::make('cr_copy')
                    ->enableDownload()
                    ->label(__('cr_copy')),
                Forms\Components\FileUpload::make('profile_file')
                    ->label(__('Work Files'))
                    ->enableDownload()
                    ->multiple(),
                Forms\Components\TextInput::make('profile_link')
                    ->label(__('Profile Link')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label(__('User')),
                Tables\Columns\TextColumn::make('field.name')->label(__('Field')),
                Tables\Columns\TextColumn::make('profile_link')->label(__('Profile Link')),
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
            'index' => Pages\ListFreelancers::route('/'),
            'create' => Pages\CreateFreelancers::route('/create'),
            'edit' => Pages\EditFreelancers::route('/{record}/edit'),
        ];
    }
}
