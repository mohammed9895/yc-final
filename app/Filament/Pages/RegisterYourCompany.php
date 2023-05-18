<?php

namespace App\Filament\Pages;

use Closure;
use App\Models\Field;
use App\Models\Company;
use Filament\Pages\Page;
use App\Notifications\SmsMessage;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\UserResource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Notifications\Notification;

class RegisterYourCompany extends Page implements HasForms, HasTable

{
    use InteractsWithForms, HasPageShield, InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.register-your-company';

    protected static function getNavigationGroup(): ?string
    {
        return   __('companies');
    }

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
    public $others;
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
                            ->searchable()
                            ->options(Field::where('type', 'compnay')
                                ->pluck('name', 'id'))
                            ->required()
                            ->reactive(),
                        TextInput::make('others')->label(__('Others'))->visible(function (callable $get) {
                            if ($get('filed') == 14) {
                                return true;
                            }
                        }),
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
                            ->enableDownload()
                            ->label(__('cr_copy'))
                            ->required(),
                        FileUpload::make('VAT_ceritifcate_copy')->label(__('VAT_ceritifcate_copy'))->enableDownload(),
                        FileUpload::make('readah_ceritifcate_copy')->label(__('readah_ceritifcate_copy'))->enableDownload(),
                    ]),
            ])->submitAction(new HtmlString(html: '<button type="submit" class="filament-button filament-button-size-sm inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2rem] px-3 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">Register</button>'))
        ];
    }

    protected function getTableQuery(): Builder
    {
        return Company::query()->where('user_id', auth()->id());
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('user.name')
                ->label(__('User'))
                ->url(fn ($record) => UserResource::getUrl('view', $record->user_id))
                ->openUrlInNewTab(),
            TextColumn::make('name')->label(__('Name')),
            TextColumn::make('cr_number')->label(__('cr_number')),
            TextColumn::make('about')->label(__('about')),
            TextColumn::make('field.name')->label(__('Field')),
            TextColumn::make('others')->label(__('Others'))->visible(14 || 24),
            TextColumn::make('owner_fullname')->label(__('owner_fullname')),
            TextColumn::make('owner_phone')->label(__('owner_phone')),
            TextColumn::make('owner_email')->label(__('owner_email')),
            TextColumn::make('owner_civil_id')->label(__('owner_civil_id')),
            TextColumn::make('created_at')->label(__('created_at'))
                ->dateTime(),
            TextColumn::make('updated_at')->label(__('updated_at'))
                ->dateTime(),
        ];
    }


    public function register()
    {
        $orginal = $this->form->getState();
        $orginal['user_id'] = auth()->id();
        $orginal['field_id'] = $orginal['filed'];
        if ($orginal['filed'] == 14) {
            $orginal['others'] = $orginal['others'];
        }
        $compnay = Company::create($orginal);
        if ($compnay) {
            $sms = new SmsMessage;
            if (auth()->user()->preferred_language == 'ar') {
                $sms->to(auth()->user()->phone)
                    ->message('شكراً لك، تم تسجيل شركتك في مركز الشباب')
                    ->lang(auth()->user()->preferred_language)
                    ->send();
            } else {
                $sms->to(auth()->user()->phone)
                    ->message('Thank you, your compnay have been successfuly registered successfuly')
                    ->lang(auth()->user()->preferred_language)
                    ->send();
            }
            return Notification::make()
                ->title(__('Company Registered Successfuly'))
                ->success()
                ->send();
        }
    }
}
