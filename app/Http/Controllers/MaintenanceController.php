<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Locker;
use App\Models\Maintenance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    // User: my own maintenance reports
    public function index(Request $request): View
    {
        $maintenances = Maintenance::with('locker.location')
            ->where('reported_by_user_id', Auth::id())   // CHANGED (was reportByUser_id)
            ->latest('reported_at')                      // CHANGED (was report_at)
            ->paginate(10)
            ->withQueryString();

        $lockers = Locker::with('location')
            ->where('status', '!=', 'maintenance')
            ->orderBy('name')
            ->get();

        return view(
            'user.maintenance.index',
            compact('maintenances', 'lockers')
        );
    }

    // User: report a broken locker
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'locker_id' => 'required|exists:lockers,id',
            'reason' => 'required|string|max:255',
        ]);

        $locker = Locker::findOrFail($validated['locker_id']);

        // only one open request per locker
        $hasOpenRequest = Maintenance::where('locker_id', $locker->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->exists();

        if ($hasOpenRequest) {
            return back()
                ->withInput()
                ->with('error', 'This locker already has an active maintenance request.');
        }

        Maintenance::create([
            'locker_id' => $locker->id,
            'reason' => $validated['reason'],
            'reported_by_user_id' => Auth::id(),   // CHANGED
            'solved_by_user_id' => null,           // CHANGED
            'status' => 'pending',
            'reported_at' => now(),                // CHANGED
            'solved_at' => null,                   // CHANGED
        ]);

        $locker->update(['status' => 'maintenance']);

        return back()->with('success', 'Maintenance issue reported successfully.');
    }

    // Staff: list with filters + stats
    public function staff(Request $request): View
    {
        $query = Maintenance::with([
            'locker.location',
            'reporter',
            'solver',
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('location_id')) {
            $query->whereHas('locker', function ($q) use ($request) {
                $q->where('location_id', $request->location_id);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('reason', 'ilike', "%{$search}%")
                    ->orWhereHas('locker', function ($lockerQuery) use ($search) {
                        $lockerQuery->where('name', 'ilike', "%{$search}%");
                    });
            });
        }

        $maintenances = $query
            ->latest('reported_at')   // CHANGED (was report_at)
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'pending' => Maintenance::where('status', 'pending')->count(),

            'in_progress' => Maintenance::where('status', 'in_progress')->count(),

            // CHANGED: solved_at (was solve_at, this caused your error)
            'resolved_this_week' => Maintenance::where('status', 'resolved')
                ->where('solved_at', '>=', now()->startOfWeek())
                ->count(),

            'out_of_service' => Locker::where('status', 'maintenance')->count(),
        ];

        $locations = Location::orderBy('name')->get();

        return view(
            'staff.maintenance.index',
            compact('maintenances', 'stats', 'locations')
        );
    }

    // Staff: show the create form
    public function create(): View
    {
        $lockers = Locker::with('location')
            ->where('status', '!=', 'maintenance')
            ->orderBy('name')
            ->get();

        return view('staff.maintenance.create', compact('lockers'));
    }

    // Staff: save a new maintenance report
    public function storeStaff(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'locker_id' => 'required|exists:lockers,id',
            'reason' => 'required|string|max:255',
        ]);

        $locker = Locker::findOrFail($validated['locker_id']);

        $hasOpenRequest = Maintenance::where('locker_id', $locker->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->exists();

        if ($hasOpenRequest) {
            return back()
                ->withInput()
                ->with('error', 'This locker already has an active maintenance request.');
        }

        Maintenance::create([
            'locker_id' => $locker->id,
            'reason' => $validated['reason'],
            'reported_by_user_id' => Auth::id(),   // CHANGED
            'solved_by_user_id' => null,           // CHANGED
            'status' => 'pending',
            'reported_at' => now(),                // CHANGED
            'solved_at' => null,                   // CHANGED
        ]);

        $locker->update(['status' => 'maintenance']);

        return redirect()
            ->route('staff.maintenance.index')
            ->with('success', 'Maintenance issue reported successfully.');
    }

    // Staff: show the edit form
    public function edit(Maintenance $maintenance): View
    {
        $maintenance->load([
            'locker.location',
            'reporter',
            'solver',
        ]);

        return view('staff.maintenance.edit', compact('maintenance'));
    }

    // Staff: change the status
    public function update(Request $request, Maintenance $maintenance): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
        ]);

        $newStatus = $validated['status'];

        // becoming resolved: record who and when, free the locker
        if ($newStatus === 'resolved' && $maintenance->status !== 'resolved') {
            $validated['solved_by_user_id'] = Auth::id();   // CHANGED
            $validated['solved_at'] = now();                // CHANGED

            $hasOtherOpenRequests = Maintenance::where('locker_id', $maintenance->locker_id)
                ->where('id', '!=', $maintenance->id)
                ->whereIn('status', ['pending', 'in_progress'])
                ->exists();

            if (! $hasOtherOpenRequests) {
                Locker::where('id', $maintenance->locker_id)
                    ->update(['status' => 'available']);
            }
        }

        // reopened: clear who/when, put the locker back in maintenance
        if ($newStatus !== 'resolved' && $maintenance->status === 'resolved') {
            $validated['solved_by_user_id'] = null;   // CHANGED
            $validated['solved_at'] = null;           // CHANGED

            Locker::where('id', $maintenance->locker_id)
                ->update(['status' => 'maintenance']);
        }

        $maintenance->update($validated);

        return redirect()
            ->route('staff.maintenance.index')
            ->with('success', 'Maintenance request updated successfully.');
    }

    // Staff: delete a report
    public function destroy(Maintenance $maintenance): RedirectResponse
    {
        $lockerId = $maintenance->locker_id;

        $maintenance->delete();

        // no open requests left: the locker can be used again
        $hasOpenRequests = Maintenance::where('locker_id', $lockerId)
            ->whereIn('status', ['pending', 'in_progress'])
            ->exists();

        if (! $hasOpenRequests) {
            Locker::where('id', $lockerId)
                ->where('status', 'maintenance')
                ->update(['status' => 'available']);
        }

        return redirect()
            ->route('staff.maintenance.index')
            ->with('success', 'Maintenance request deleted successfully.');
    }
}