<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(string $action, ?string $details = null, ?int $userId = null): void
    {
        $uid = $userId ?? Auth::id();

        if (! $uid) {
            return;
        }

        Log::create([
            'user_id' => $uid,
            'ip_address' => Request::ip() ?? '127.0.0.1',
            'action' => $action,
            'details' => $details,
        ]);
    }
}
