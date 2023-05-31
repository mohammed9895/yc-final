<?php

namespace App\Http\Livewire\User;

use App\Models\Company;
use App\Models\Field;
use App\Models\Submission;
use App\Models\Tender;
use App\Notifications\SmsMessage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class SubmissionModel extends ModalComponent implements HasForms, HasTable
{
    use InteractsWithForms,  InteractsWithTable;

    public $tender;

    public function mount(Tender $tender)
    {
        $this->form->fill();
        $this->tender = $tender;
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('company_id')
                ->options(Company::where('user_id', auth()->id())->pluck('name', 'id'))->searchable(),
            FileUpload::make('submitted_file')
                ->required()
                ->label(__('tender_file')),
        ];
    }

    public function submit()
    {
        $orginal = $this->form->getState();
        $orginal['user_id'] = auth()->id();

        $submission = Submission::create($orginal);

        if ($submission) {
//            $sms = new SmsMessage;
//            if (auth()->user()->preferred_language == 'ar') {
//                $sms->to(auth()->user()->phone)
//                    ->message('شكرًا لك، تم ارسال طلب تقدم للمناقصة بنجاح')
//                    ->lang(auth()->user()->preferred_language)
//                    ->send();
//            } else {
//                $sms->to(auth()->user()->phone)
//                    ->message('Thank you, Your Request have been sent successfuly')
//                    ->lang(auth()->user()->preferred_language)
//                    ->send();
//            }
            return Notification::make()
                ->title(__('Applied Successfuly'))
                ->success()
                ->send();
            $this->closeModal();
        }
    }

    public function render()
    {
        return view('livewire.user.submission-model');
    }
}
