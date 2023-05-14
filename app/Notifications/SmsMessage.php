<?php

namespace App\Notifications;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SmsMessage
{

    protected string $user;
    protected string $password;
    protected string $to;
    protected string $lang;
    protected string $baseUrl;
    protected string $message;
    protected string $dryrun = 'no';

    /**
     * SmsMessage constructor.
     * @param array $lines
     */
    public function __construct($message = '')
    {
        $this->message = $message;

        // Pull in config from the config/services.php file.
        $this->baseUrl = config('services.omantel.base_url');
        $this->user = config('services.omantel.user');
        $this->password = config('services.omantel.password');
    }

    public function message($message): self
    {
        $this->message = $message;

        return $this;
    }

    public function to($to): self
    {
        $this->to = $to;

        return $this;
    }

    public function lang($lang): self
    {
        if ($lang == 'ar') {
            $this->lang = '64';
        } else {
            $this->lang = '0';
        }

        return $this;
    }

    public function send(): mixed
    {
        if (!$this->to || !$this->message) {
            throw new \Exception('SMS not correct.');
        }

        return Http::post('' . $this->baseUrl . '?UserId=' . $this->user . '&Password=' . $this->password . '&MobileNo=' . $this->to . '&Message=' . $this->message . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $this->lang . '&FLashSMS=N');
    }

    public function dryrun($dry = 'yes'): self
    {
        $this->dryrun = $dry;

        return $this;
    }
}
