<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminActivityLogController extends Controller
{
    /**
     * GET /admin/activity-logs
     * Full paginated log page.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::latest('logged_at');

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) =>
                $q->where('full_name', 'like', "%{$s}%")
                  ->orWhere('email',    'like', "%{$s}%")
                  ->orWhere('ip_address','like', "%{$s}%")
            );
        }

        $logs  = $query->paginate(30)->withQueryString();
        $stats = [
            'total_today'  => ActivityLog::whereDate('logged_at', today())->count(),
            'logins_today' => ActivityLog::whereDate('logged_at', today())->where('event', 'login')->count(),
            'active_now'   => $this->activeNow(),
        ];

        return view('admin.activity-logs.index', compact('logs', 'stats'));
    }

    /**
     * GET /admin/activity-logs/live  (JSON — polled by JS every 5 s)
     * Returns the last 50 events and live stats.
     */
    public function live(): JsonResponse
    {
        $logs = ActivityLog::latest('logged_at')
            ->limit(50)
            ->get()
            ->map(fn($l) => [
                'id'        => $l->id,
                'event'     => $l->event,
                'full_name' => $l->full_name ?? '—',
                'email'     => $l->email    ?? '—',
                'role'      => $l->role     ?? '—',
                'ip'        => $l->ip_address ?? '—',
                'time'      => $l->logged_at
                                  ? \Carbon\Carbon::parse($l->logged_at)->diffForHumans()
                                  : '—',
                'time_full' => $l->logged_at
                                  ? \Carbon\Carbon::parse($l->logged_at)->format('M d, Y H:i:s')
                                  : '—',
            ]);

        return response()->json([
            'logs'          => $logs,
            'active_now'    => $this->activeNow(),
            'logins_today'  => ActivityLog::whereDate('logged_at', today())->where('event', 'login')->count(),
            'total_today'   => ActivityLog::whereDate('logged_at', today())->count(),
            'timestamp'     => now()->format('H:i:s'),
        ]);
    }

    /**
     * Estimate currently active sessions:
     * users who logged in but have no subsequent logout event today.
     */
    private function activeNow(): int
    {
        // Get all user_ids who logged in today
        $loggedInIds = ActivityLog::whereDate('logged_at', today())
            ->where('event', 'login')
            ->whereNotNull('user_id')
            ->pluck('user_id')
            ->unique();

        // Subtract those who have logged out after their last login
        $loggedOutIds = ActivityLog::whereDate('logged_at', today())
            ->where('event', 'logout')
            ->whereNotNull('user_id')
            ->whereIn('user_id', $loggedInIds)
            ->pluck('user_id')
            ->unique();

        return max(0, $loggedInIds->count() - $loggedOutIds->count());
    }
}
