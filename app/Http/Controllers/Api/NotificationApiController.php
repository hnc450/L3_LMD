<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Service;
use Illuminate\Http\Request;

class NotificationApiController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Notification::with('plainte')
            ->where('id_user', $request->user()->id)
            ->latest()
            ->paginate(30);

        return response()->json($notifications);
    }

    public function markRead(Request $request, Notification $notification)
    {
        if ($notification->id_user !== $request->user()->id) {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        $notification->update(['status' => 'read']);

        return response()->json(['message' => 'Notification lue.']);
    }
}
