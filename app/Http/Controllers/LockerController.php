<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LockerUsage;
use App\Services\LockerService;
use Illuminate\View\View;

class LockerController extends Controller
{
    // My Locker: only the lockers this user is using right now
    public function index(): View
    {
        $myActive = LockerUsage::with('locker.location')
            ->where('user_id', auth()->id())
            ->whereNull('end_time')
            ->latest('start_time')
            ->get();

        return view('user.lockers.index', compact('myActive'));
    }

    public function staff(): View
    {
        return view('staff.lockers.index');
    }

    // Location Details + Locker List (all lockers at one location)
    public function byLocation(Location $location, LockerService $lockerService): View
    {
        abort_if($location->status !== 'active', 404);

        $lockers = $lockerService->allByLocation($location->id);

        $counts = [
            'available'   => $lockers->where('status', 'available')->count(),
            'in_use'      => $lockers->where('status', 'occupied')->count(),
            'maintenance' => $lockers->where('status', 'maintenance')->count(),
        ];

        return view('user.lockers.by-location', compact('location', 'lockers', 'counts'));
    }
}