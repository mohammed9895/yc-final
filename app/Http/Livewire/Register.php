<?php

namespace App\Http\Livewire;

use App\Models\Country;
use App\Models\Disability;
use App\Models\EducationType;
use App\Models\EmployeeType;
use App\Models\Province;
use App\Models\State;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;
use Livewire\Component;


class Register extends Component implements HasForms
{
    use InteractsWithForms;

    public User $user;

    public $name = '';
    public $email = '';
    public $password = '';
    public $passwordConfirmation = '';


    public function mount(): void
    {
        $locale = session()->get('locale', 'ar');
        app()->setLocale($locale);
        $this->form->fill();
    }

    public function register()
    {
        $phone_verified_code = random_int(10000, 99999);
        $orginal = $this->form->getState();

        if ($orginal['agreed_on_terms']) {
            $orginal['phone_verified_code'] = $phone_verified_code;

            // Combine first, middle, and family names to create the full name
            $fullname = trim("{$orginal['first_name']} {$orginal['middle_name']} {$orginal['family_name']}");

            // Remove first, middle, and family name attributes
            unset($orginal['first_name'], $orginal['middle_name'], $orginal['family_name']);

            // Set the full name attribute
            $orginal['name'] = $fullname;

            $messageSms = '';

            if (Config::get('app.locale') == 'ar') {
                $messageSms = "رمز التأكيد الخاص بك هو: ".$phone_verified_code;
            } else {
                $messageSms = "Your Verifcation code is ".$phone_verified_code;
            }

            $lang = Config::get('app.locale') == 'ar' ? '64' : '0';
            $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId='.env('User_ID_OTP',
                    'youthsmsweb').'&Password='.env('OTP_Password',
                    'L!ulid80').'&MobileNo='.$orginal['phone'].'&Message='.$messageSms.'&PushDateTime=10/12/2022 02:03:00&Lang='.$lang.'&FLashSMS=N');

            $user = User::create($orginal);
            $user->assignRole('filament_user');
            Filament::auth()->login(user: $user, remember: true);
            return redirect()->intended(Filament::getUrl('filament.pages.dashboard'));
        } else {
            return redirect()->back();
        }
    }

    public function render(): View
    {
        return view('livewire.register');
    }

    protected function getFormSchema(): array
    {
        return [
            Wizard::make([
                Wizard\Step::make(__('Step 1'))
                    ->schema([
                        TextInput::make('first_name')
                            ->label(__('First Name'))
                            ->required()
                            ->maxLength(50)->columnSpan(1),
                        TextInput::make('middle_name')
                            ->label(__('Middle Name'))
                            ->required()
                            ->maxLength(50)->columnSpan(1),
                        TextInput::make('family_name')
                            ->label(__('Family Name'))
                            ->required()
                            ->maxLength(50)
                            ->columnSpan(1),
                        TextInput::make('email')
                            ->label(__('filament::users.email'))
                            ->email()
                            ->required()
                            ->maxLength(50)
                            ->unique(User::class),
                        TextInput::make('password')
                            ->label(__('filament::users.password'))
                            ->password()
                            ->required()
                            ->maxLength(50)
                            ->minLength(8)
                            ->same('passwordConfirmation')
                            ->dehydrateStateUsing(fn($state) => Hash::make($state)),
                        TextInput::make('passwordConfirmation')
                            ->label(__('passwordConfirmation'))
                            ->password()
                            ->required()
                            ->maxLength(50)
                            ->minLength(8)
                            ->dehydrated(false),
                        TextInput::make('phone')
                            ->label(__('filament::users.phone'))
                            ->maxLength(8)
                            ->required()
                            ->minLength(8),
                        DatePicker::make('birth_date')
                            ->label(__('Birth Date'))
                            ->required(),
                        Select::make('disability_id')
                            ->label(__('disability'))
                            ->required()
                            ->options(Disability::all()->pluck('name', 'id'))
                            ->searchable(),
                        Radio::make('gender')
                            ->label(__('sex'))
                            ->options([
                                0 => __('filament::users.male'),
                                1 => __('filament::users.female'),
                            ])->required(),
                    ])
                    ->columns([
                        'sm' => '1',
                        'lg' => 2,
                    ])
                    ->columnSpan([
                        'sm' => 'full',
                        'lg' => 2,
                    ]),
                Wizard\Step::make(__('Step 2'))
                    ->schema([
                        Radio::make('citizen')
                            ->label(__('filament::users.citizin'))
                            ->options([
                                0 => __('filament::users.citizin'),
                                1 => __('filament::users.foreigner'),
                            ])->required(),
                        TextInput::make('civil_no')->label(__('Civil Number'))->maxLength(10)->required(),
                        Select::make('country_id')
                            ->label(__('filament::users.coutry'))
                            ->required()
                            ->options(Country::all()->pluck('name', 'id'))
                            ->searchable(),
                        Select::make('province_id')
                            ->label(__('province'))
                            ->required()
                            ->options(Province::all()->pluck('name', 'id'))
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('state_id', null)),
                        Select::make('state_id')
                            ->label(__('state'))
                            ->required()
                            ->options(function (callable $get) {
                                $province = Province::find($get('province_id'));
                                if (!$province) {
                                    return State::all()->pluck('name', 'id');
                                }
                                return $province->state->pluck('name', 'id');
                            })
                            ->searchable(),
                        Select::make('permanent_residence_state_id')
                            ->label(__('permanent_residence_state'))
                            ->required()
                            ->options(State::all()->pluck('name', 'id'))
                            ->searchable(),
                    ]),
                Wizard\Step::make(__('Step 3'))
                    ->schema([
                        Select::make('education_type_id')
                            ->label(__('filament::users.degree'))
                            ->required()
                            ->searchable()
                            ->options(EducationType::all()->pluck('name', 'id')),
                        Select::make('employee_type_id')
                            ->label(__('filament::users.work'))
                            ->required()
                            ->searchable()
                            ->options(EmployeeType::all()->pluck('name', 'id')),
                        Select::make('preferred_language')
                            ->label(__('Preferred Communication Language'))
                            ->searchable()
                            ->options(
                                [
                                    'en' => 'English',
                                    'ar' => 'Arabic'
                                ]
                            ),
                        Checkbox::make('agreed_on_terms')->label(new HtmlString(''.__('I agree with the').' <a href="/termsandconditions" target="_blank" class="text-primary-600">'.__('terms and conditions').'</a>'))->inline()->required()
                    ])
            ])
                ->columns([
                    'sm' => 1,
                ])
                ->columnSpan([
                    'sm' => 1,
                ])
                ->submitAction(new HtmlString(html: '
                        <button type="submit" class="filament-button filament-button-size-sm inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2rem] px-3 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">Register
                        </button>'))

        ];
    }
}
