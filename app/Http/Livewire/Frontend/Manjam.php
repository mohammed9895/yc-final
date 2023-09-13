<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Talent;
use App\Models\TalentType;
use App\Notifications\SmsMessage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class Manjam extends Component implements HasForms
{
    use InteractsWithForms;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function save()
    {

        if (auth()->check()) {
            $talent = Talent::where('user_id', auth()->id())->count();
            if ($talent > 0) {
                session()->flash('error', __('You have already registered!'));
            } else {
                $orginal = $this->form->getState();
                $orginal['user_id'] = auth()->id();
                $booking = Talent::create($orginal);

                $user = auth()->user();
                $sms = new SmsMessage;
                if ($user->preferred_language == 'ar') {
                    $sms->to($user->phone)
                        ->message("شكرَا لك، تم تسجيلك في منجم المواهب بنجاح")
                        ->lang($user->preferred_language)
                        ->send();
                } else {
                    $sms->to($user->phone)
                        ->message("Thank you, You have been registered in Talent Manjam successfully")
                        ->lang($user->preferred_language)
                        ->send();
                }
                session()->flash('success', __('You have been registered successfully!'));
            }
        } else {
            session()->flash('error',
                __('You have to be logged in to register! <a href="'.route('filament.auth.login').'" class="font-bold">Login Now</a>'));
        }
    }

    public function render()
    {
        return view('livewire.frontend.manjam');
    }

    protected function getFormSchema(): array
    {
        return [
            Wizard::make([
                Wizard\Step::make(__('General Information'))
                    ->schema([
                        Select::make('talent_type_id')
                            ->label(__('Talent Type'))
                            ->searchable()
                            ->options(TalentType::pluck('name', 'id'))
                            ->required(),
                        TextInput::make('talent_sub_type')
                            ->label(__('Talent Sub Type'))
                            ->required(),
                        TextInput::make('purpose')
                            ->label(__('purpose'))
                            ->required(),
                        Textarea::make('bio')
                            ->label(__('Bio'))
                            ->required(),
                        TagsInput::make('certificates')
                            ->label(__('Certificates'))
                            ->placeholder(__('certificate of achievement, completion certificates, or even appreciation certificate...')),
                    ]),
                Wizard\Step::make(__('Video and Images'))
                    ->schema([
                        FileUpload::make('video')
                            ->label(__('video'))
                            ->panelAspectRatio('2:1')
                            ->required(),
                        FileUpload::make('personal_image')
                            ->label(__('personal_image'))
                            ->required()
                            ->image(),
                    ]),
                Wizard\Step::make(__('Contact Information'))
                    ->schema([
                        TextInput::make('phone')
                            ->label(__('phone'))
                            ->required()
                            ->tel(),
                        TextInput::make('email')
                            ->label(__('email'))
                            ->required()
                            ->email(),
                        TagsInput::make('social_media_links')
                            ->label(__('social_media_links'))
                            ->required()
                            ->placeholder(__('Instagram, Twitter, Behance ...')),
                    ]),
            ])
                ->submitAction(new HtmlString(html: '
                        <button type="submit" class="filament-button filament-button-size-sm inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2rem] px-3 text-sm text-white shadow focus:ring-white border-transparent bg-manjam_primary hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700" style="background: #684e9a;">'.__('Register Now').'</button>')),
        ];
    }
}
