<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Log::with('user.role')->latest();

        if (! $user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($user->isAdmin() && $request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(30)->withQueryString();

        $statsQuery = fn () => $user->isAdmin() ? Log::query() : Log::where('user_id', $user->id);

        return view('logs.index', [
            'logs' => $logs,
            'isAdmin' => $user->isAdmin(),
            'today_actions' => $statsQuery()->whereDate('created_at', today())->count(),
            'week_actions' => $statsQuery()->where('created_at', '>=', now()->startOfWeek())->count(),
            'month_actions' => $statsQuery()->where('created_at', '>=', now()->startOfMonth())->count(),
        ]);
    }
}
