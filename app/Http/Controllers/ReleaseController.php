<?php

namespace App\Http\Controllers;

use App\Models\LockerUsage;
use App\Services\AssignmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReleaseController extends Controller
{
    // Release Locker -> Confirm Release page
    public function confirm(LockerUsage $assignment): View|RedirectResponse
    {
        abort_if($assignment->user_id !== auth()->id(), 403);

        if ($assignment->end_time) {
            return redirect()->route('user.assignments.released', $assignment);
        }

        $assignment->load('locker.location');

        return view('user.assignments.release-confirm', compact('assignment'));
    }

    // Confirm Release
    public function store(LockerUsage $assignment, AssignmentService $assignmentService): RedirectResponse
    {
        abort_if($assignment->user_id !== auth()->id(), 403);

        $assignmentService->release($assignment);

        return redirect()->route('user.assignments.released', $assignment);
    }

    // Locker -> Available
    public function released(LockerUsage $assignment): View
    {
        abort_if($assignment->user_id !== auth()->id(), 403);

        $assignment->load('locker.location');

        return view('user.assignments.released', compact('assignment'));
    }
}