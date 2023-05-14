<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\VonageMessage;

class SendVerifySMS extends Notification
{
    public function __construct()
    {
        //
    }

    public function via($notifiable): array
    {
        return [SmsChannel::class];
    }

    public function toSms($notifiable)
    {
        return (new SmsMessage())
            ->to($notifiable->phone)
            ->message("Your verification code is {$notifiable->phone_verified_code}");
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
