<?php

namespace App\Http\Controllers;

use App\Models\Locker;
use App\Models\LockerUsage;
use App\Models\User;
use App\Services\AssignmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('user.lockers.index');
    }

    // Confirm Locker
    public function confirm(Locker $locker): View|RedirectResponse
    {
        if ($locker->status !== 'available') {
            return redirect()
                ->route('user.locations.lockers', $locker->location_id)
                ->withErrors(['locker' => 'This locker is no longer available.']);
        }

        $locker->load('location');

        return view('user.lockers.confirm', compact('locker'));
    }

    // Locker Assigned
    public function store(Locker $locker, AssignmentService $assignmentService): RedirectResponse
    {
        // [TEMP] delete these lines when friend's login is merged
        $testUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'Test User', 'password' => 'password', 'role' => 'user']
        );
        Auth::login($testUser);

        if ($locker->status !== 'available') {
            return back()->withErrors(['locker' => 'This locker is no longer available.']);
        }

        $usage = $assignmentService->reserve($testUser, $locker);

        return redirect()->route('user.assignments.show', $usage);
    }

    // Display Locker Information
    public function show(LockerUsage $assignment): View
    {
        abort_if($assignment->user_id !== auth()->id(), 403);

        $assignment->load('locker.location');
    

        return view('user.assignments.show', compact('assignment'));
    }
}