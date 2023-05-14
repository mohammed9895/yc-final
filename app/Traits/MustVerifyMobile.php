<?php

namespace App\Traits;

use App\Notifications\SendVerifySMS;

trait MustVerifyMobile
{
    public function hasVerifiedMobile(): bool
    {
        return !is_null($this->phone_verified_at);
    }

    public function markMobileAsVerified(): bool
    {
        return $this->forceFill([
            'phone_verified_code' => NULL,
            'phone_verified_at' => $this->freshTimestamp(),
            'phone_attempts_left' => 0,
        ])->save();
    }

    public function sendMobileVerificationNotification(bool $newData = false): void
    {
        if ($newData) {
            $this->forceFill([
                'phone_verified_code' => random_int(111111, 999999),
                'phone_attempts_left' => config('mobile.max_attempts'),
                'phone_verified_code_sent_at' => now(),
            ])->save();
        }
        $this->notify(new SendVerifySMS);
    }
}
