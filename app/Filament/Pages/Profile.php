<?php

namespace App\Filament\Pages;


use App\Models\State;
use App\Models\Country;
use App\Models\Province;
use App\Models\Disability;
use App\Models\EmployeeType;
use App\Models\EducationType;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use JeffGreco13\FilamentBreezy\Pages\MyProfile as BaseProfile;

class Profile extends BaseProfile
{

    protected function getUpdateProfileFormSchema(): array
    {
        return array_merge(parent::getUpdateProfileFormSchema(), [
            FileUpload::make('avatar')->label(__('filament::users.avatar'))->avatar(),
            TextInput::make('phone')->label(__('filament::users.phone'))
                ->tel()
                ->required()
                ->maxLength(255),

            Radio::make('citizen')->label(__('filament::users.citizin'))->options([
                0 => __('filament::users.citizin'),
                1 => __('filament::users.foreigner'),
            ])->required(),
            Radio::make('gender')->label(__('filament::users.sex'))
                ->options([
                    0 => __('filament::users.male'),
                    1 => __('filament::users.female'),
                ])->required(),

            TextInput::make('civil_no')->label(__('filament::users.id_number'))->maxLength(255)->required(),

            DatePicker::make('birth_date')
                ->label('Birth Date')
                ->required(),

            Select::make('disability_id')->label(__('filament::users.disability'))->options(Disability::all()->pluck('name', 'id'))->searchable()->required(),
            Select::make('country_id')->label(__('filament::users.coutry'))
                ->options(Country::all()->pluck('name', 'id'))->searchable()->required(),

            Select::make('province_id')
                ->label('Province')
                ->required()
                ->options(Province::all()->pluck('name', 'id'))
                ->searchable()
                ->reactive()
                ->afterStateUpdated(fn (callable $set) => $set('state_id', null)),
            Select::make('state_id')
                ->label('State')
                ->required()
                ->options(function (callable $get) {
                    $province = Province::find($get('province_id'));
                    if (!$province) {
                        return State::all()->pluck('name', 'id');
                    }
                    return $province->state->pluck('name', 'id');
                })
                ->searchable(),
            Select::make('education_type_id')->label(__('filament::users.degree'))->options(EducationType::all()->pluck('name', 'id'))->searchable()->required(),
            Select::make('employee_type_id')->label(__('filament::users.work'))->options(EmployeeType::all()->pluck('name', 'id'))->searchable()->required(),
            Select::make('preferred_language')
                ->label('Preferred Communication Language')
                ->options(
                    [
                        'en' => 'English',
                        'ar' => 'Arabic'
                    ]
                ),
        ]);
    }
}
