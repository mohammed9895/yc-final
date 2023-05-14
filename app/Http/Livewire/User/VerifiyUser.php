<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Filament\Notifications\Notification;

class VerifiyUser extends Component
{
    public $code;
    public function verifiy()
    {
        if ($this->code == auth()->user()->phone_verified_code) {
            auth()->user()->markPhoneAsVerified();
            Notification::make()
                ->title('You have Verified your account!')
                ->success()
                ->send();
            return redirect()->route('filament.pages.dashboard')->with('verified', 'You have Verified your account!');
        }
    }

    public function resend()
    {
        $user = Auth::user();

        $phone_verified_code =  random_int(10000, 99999);

        $user->update([
            'phone_verified_code' => $phone_verified_code,
        ]);

        $messageSms = '';

        if (Config::get('app.locale') == 'ar') {
            $messageSms = "رمز التأكيد الخاص بك هو: " . $phone_verified_code;
        } else {
            $messageSms = "Your Verifcation code is " . $phone_verified_code;
        }

        $lang = Config::get('app.locale') == 'ar' ? '64' : '0';
        $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=' . env('User_ID_OTP', 'youthsmsweb') . '&Password=' . env('OTP_Password', 'L!ulid80') . '&MobileNo=' . Auth::user()->phone . '&Message=' . $messageSms . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $lang . '&FLashSMS=N');

        Notification::make()
            ->title('Code resent successfuly!')
            ->success()
            ->send();
    }
    public function render()
    {
        return view('livewire.user.verifiy-user');
    }
}
