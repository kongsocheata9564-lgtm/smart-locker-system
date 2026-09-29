<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Locker;

class DashboardController extends Controller
{
    public function user()
    {
        $userId = auth()->id();

        $totalBookings = Assignment::where('user_id', $userId)->count();
        $weekBookings  = Assignment::where('user_id', $userId)
                            ->where('created_at', '>=', now()->startOfWeek())->count();
        $activeLockers = Assignment::where('user_id', $userId)->where('status', 'active')->count();
        $available     = Locker::where('status', 'available')->count();

        $recent = Assignment::with('locker.location')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard.index', compact(
            'totalBookings', 'weekBookings', 'activeLockers', 'available', 'recent'
        ));
    }
}