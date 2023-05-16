<?php

namespace App\Filament\Resources;

use ZipArchive;
use Filament\Forms;
use Filament\Tables;
use App\Models\Field;
use App\Models\Company;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CompanyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CompanyResource\RelationManagers;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function getNavigationGroup(): ?string
    {
        return   __('companies');
    }

    public static function getModelLabel(): string
    {
        return   __('companies');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('companies');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make(__('filament::company.information'))
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->label(__('Name'))
                                ->reactive()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('cr_number')
                                ->required()
                                ->label(__('cr_number'))
                                ->maxLength(255),
                            Forms\Components\Textarea::make('about')
                                ->label(__('about'))
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('filed')
                                ->label(__('filed'))
                                ->options(Field::all()->pluck('name', 'id'))
                                ->required(),
                        ]),
                    Wizard\Step::make(__('companyـowner'))
                        ->schema([
                            Forms\Components\TextInput::make('owner_fullname')
                                ->required()
                                ->label(__('owner_fullname'))
                                ->maxLength(255),
                            Forms\Components\TextInput::make('owner_phone')
                                ->label(__('owner_phone'))
                                ->tel()
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('owner_email')
                                ->email()
                                ->label(__('owner_email'))
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('owner_civil_id')
                                ->required()
                                ->label(__('owner_civil_id'))
                                ->maxLength(255),
                        ]),
                    Wizard\Step::make('Document')
                        ->schema([
                            Forms\Components\FileUpload::make('cr_copy')
                                ->label(__('cr_copy'))
                                ->required(),
                            Forms\Components\FileUpload::make('chamber_ceritifcate_copy')
                                ->label(__('chamber_ceritifcate_copy'))
                                ->required(),
                            Forms\Components\FileUpload::make('VAT_ceritifcate_copy')->label(__('VAT_ceritifcate_copy')),
                            Forms\Components\FileUpload::make('readah_ceritifcate_copy')->label(__('readah_ceritifcate_copy')),
                        ]),
                ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User'))
                    ->url(fn ($record) => UserResource::getUrl('view', $record->user_id))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('name')->label(__('Name')),
                Tables\Columns\TextColumn::make('cr_number')->label(__('cr_number')),
                Tables\Columns\TextColumn::make('about')->label(__('about')),
                Tables\Columns\TextColumn::make('filed')->label(__('filed')),
                Tables\Columns\TextColumn::make('owner_fullname')->label(__('owner_fullname')),
                Tables\Columns\TextColumn::make('owner_phone')->label(__('owner_phone')),
                Tables\Columns\TextColumn::make('owner_email')->label(__('owner_email')),
                Tables\Columns\TextColumn::make('owner_civil_id')->label(__('owner_civil_id')),
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
                Tables\Actions\Action::make('exportAsJson')
                    ->label(__('Download attchments'))
                    ->action(function ($record) {
                        $files = [$record->cr_copy, $record->chamber_ceritifcate_copy, $record->VAT_ceritifcate_copy, $record->readah_ceritifcate_copy];
                        $zip = new ZipArchive();
                        $zip_name = time() . ".zip"; // Zip name
                        $zip->open($zip_name,  ZipArchive::CREATE);
                        foreach ($files as $file) {
                            $path = storage_path('app/public/') . $file;
                            if ($file !== null) {
                                if (file_exists($path) && is_file($path)) {
                                    $zip->addFile($path, $file);
                                } else {
                                    echo "file does not exist";
                                }
                            }
                        }
                        $zip->close();
                        $res = Response::download(public_path($zip_name), $zip_name, array('Content-Type: application/octet-stream', 'Content-Length: ' . filesize($zip_name)))->deleteFileAfterSend(true);
                        return $res;
                    })
                    ->tooltip(__('Download'))
                    ->icon('heroicon-s-download')
                    ->color('primary'),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
