<?php

namespace App\Http\Livewire\Frontend;

use Carbon\Carbon;
use App\Models\Slot;
use App\Models\Booking;
use Livewire\Component;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use LivewireUI\Modal\ModalComponent;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Config;
use Filament\Notifications\Notification;

class WorkshopsBookingModel extends ModalComponent
{
    use WithFileUploads;
    public $workshop;
    public $slots;
    public $slot_id;
    public $user;
    public $reasone;

    public $answers = [];

    public $questions;

    public function mount(Workshop $workshop)
    {
        $this->workshop = $workshop;
    }
    public function render()
    {
        $this->slots = Slot::where('start_date', '>=', date('Y-m-d'))->where('workshop_id', '=', $this->workshop->id)->with('bookings')->get();
        $this->questions = Workshop::all()->where('id', $this->workshop->id);

        return view('livewire.frontend.workshops-booking-model');
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function book(Request $request)
    {
        $bookings_count = Booking::where('workshop_id', '=', $this->workshop->id)->where('status', 2)->where('slot_id', '=', $this->slot_id)->count();
        if ($bookings_count < $this->workshop->capacity) {
            $if_user_booked = Booking::where('workshop_id', '=', $this->workshop->id)->where('user_id', '=', Auth::id())->count();
            if ($if_user_booked == 0) {
                $slot = Slot::where('id', '=', $this->slot_id)->first();
                // if ($request->hasFile('myArray')) {
                //     dd('sssss');
                // }
                Booking::create([
                    'workshop_id' => $this->workshop->id,
                    'slot_id' => $this->slot_id,
                    'user_id' => Auth::id(),
                    'answers' => $this->answers,
                    'reasone' => $this->reasone
                ]);
                $this->closeModal();
                Notification::make()
                    ->title('You have booked your seat!')
                    ->success()
                    ->send();

                $messageSms = '';

                if (Config::get('app.locale') == 'ar') {
                    $messageSms = "تم استلام طلبك للالتحاق ببرنامج " . $this->workshop->title . ' سنقوم بالتواصل معك بعد عملية الفرز ';
                } else {
                    $messageSms = "Your enrolment request have been recived for " . $this->workshop->title . 'we will contact you after the screening process';
                }

                $lang = Config::get('app.locale') == 'ar' ? '64' : '0';
                $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=' . env('User_ID_OTP', 'youthsmsweb') . '&Password=' . env('OTP_Password', 'L!ulid80') . '&MobileNo=' . Auth::user()->phone . '&Message=' . $messageSms . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $lang . '&FLashSMS=N');
            } else {
                $this->closeModal();
                Notification::make()
                    ->title('You are alrady booked you seat!')
                    ->danger()
                    ->send();
            }
        } else {
            $this->closeModal();
            Notification::make()
                ->title('Workshop is fully booked!')
                ->danger()
                ->send();
        }
    }
}
