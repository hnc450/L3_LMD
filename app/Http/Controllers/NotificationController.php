<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Rapport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::with('plainte')
            ->where('id_user', Auth::id())
            ->latest();

        if ($request->filter === 'unread') {
            $query->where('status', 'sent');
        } elseif ($request->filter === 'read') {
            $query->where('status', 'read');
        }

        $notifications = $query->paginate(20)->withQueryString();

        return view('notifications.index', compact('notifications'));
    }

    public function markRead(Notification $notification)
    {
        if ($notification->id_user !== Auth::id()) {
            abort(403);
        }

        $notification->update(['status' => 'read']);

        return back();
    }

    public function markAllRead()
    {
        Notification::where('id_user', Auth::id())
            ->where('status', 'sent')
            ->update(['status' => 'read']);

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    public function getUnreadCount()
    {
        $count = Notification::where('id_user', Auth::id())
            ->where('status', 'sent')
            ->count();

        if (Auth::user()->isResponsable()) {
            $rapportCount = Rapport::where('responsable_id', Auth::id())
                ->where('is_read', false)
                ->count();
            $count += $rapportCount;
        }

        return $count;
    }
}
