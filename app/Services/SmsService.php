<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{
    public static function send(?string $phone, string $message): bool
    {
        if (! $phone) {
            return false;
        }

        Log::channel('single')->info('[SMS] → ' . $phone . ' : ' . $message);

        return true;
    }
}
