<?php

namespace App\Filament\Pages;

use App\Models\Field;
use App\Models\Company;
use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class RegisterYourCompany extends Page implements HasForms

{
    use InteractsWithForms, HasPageShield;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.register-your-company';


    public function getTitle(): string
    {
        return   __('filament::company.registeration');
    }

    protected static function getNavigationLabel(): string
    {
        return   __('filament::company.registeration');
    }

    public $name;
    public $cr_number;
    public $about;
    public $filed;
    public $owner_fullname;
    public $owner_phone;
    public $owner_email;
    public $owner_civil_id;
    public $cr_copy;
    public $chamber_ceritifcate_copy;
    public $VAT_ceritifcate_copy;
    public $readah_ceritifcate_copy;

    protected function getFormSchema(): array
    {
        return [
            Wizard::make([
                Wizard\Step::make(__('filament::company.information'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('cr_number')
                            ->required()
                            ->label(__('cr_number'))
                            ->maxLength(255),
                        TextArea::make('about')
                            ->label(__('about'))
                            ->required()
                            ->maxLength(255),
                        Select::make('filed')
                            ->label(__('filed'))
                            ->options(Field::all()->pluck('name', 'id'))
                            ->required(),
                    ]),
                Wizard\Step::make(__('companyـowner'))
                    ->schema([
                        TextInput::make('owner_fullname')
                            ->required()
                            ->label(__('owner_fullname'))
                            ->maxLength(255),
                        TextInput::make('owner_phone')
                            ->tel()
                            ->label(__('owner_phone'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('owner_email')
                            ->label(__('owner_email'))
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('owner_civil_id')
                            ->label(__('owner_civil_id'))
                            ->required()
                            ->maxLength(255),
                    ]),
                Wizard\Step::make(__('companyـdocument'))
                    ->schema([
                        FileUpload::make('cr_copy')
                            ->label(__('cr_copy'))
                            ->required(),
                        FileUpload::make('chamber_ceritifcate_copy')
                            ->label(__('chamber_ceritifcate_copy'))
                            ->required(),
                        FileUpload::make('VAT_ceritifcate_copy')->label(__('VAT_ceritifcate_copy')),
                        FileUpload::make('readah_ceritifcate_copy')->label(__('readah_ceritifcate_copy')),
                    ]),
            ])
        ];
    }


    public function register()
    {
        $orginal = $this->form->getState();
        $orginal['user_id'] = auth()->id();
        $compnay = Company::create($orginal);
        return redirect()->route('filament.pages.register-your-company');
    }
}
