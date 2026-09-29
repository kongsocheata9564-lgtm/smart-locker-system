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
    public function index(Request $request): View
    {
        $maintenances = Maintenance::with('locker.location')
            ->where('reportByUser_id', Auth::id())
            ->latest('report_at')
            ->paginate(10)
            ->withQueryString();

        $lockers = Locker::with('location')
            ->where('status', '!=', 'maintenance')
            ->orderBy('locker_name')
            ->get();

        return view(
            'user.maintenance.index',
            compact('maintenances', 'lockers')
        );
    }

    public function store(Request $request): RedirectResponse
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
            'reportByUser_id' => Auth::id(),
            'solveByUser_id' => null,
            'status' => 'pending',
            'report_at' => now(),
            'solve_at' => null,
        ]);

        $locker->update([
            'status' => 'maintenance',
        ]);

        return back()->with(
            'success',
            'Maintenance issue reported successfully.'
        );
    }

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
                        $lockerQuery->where(
                            'locker_name',
                            'ilike',
                            "%{$search}%"
                        );
                    });
            });
        }

        $maintenances = $query
            ->latest('report_at')
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'pending' => Maintenance::where(
                'status',
                'pending'
            )->count(),

            'in_progress' => Maintenance::where(
                'status',
                'in_progress'
            )->count(),

            'resolved_this_week' => Maintenance::where(
                'status',
                'resolved'
            )
                ->where(
                    'solve_at',
                    '>=',
                    now()->startOfWeek()
                )
                ->count(),

            'out_of_service' => Locker::where(
                'status',
                'maintenance'
            )->count(),
        ];

        $locations = Location::orderBy('name')->get();

        return view(
            'staff.maintenance.index',
            compact(
                'maintenances',
                'stats',
                'locations'
            )
        );
    }

    public function create(): View
    {
        $lockers = Locker::with('location')
            ->where('status', '!=', 'maintenance')
            ->orderBy('locker_name')
            ->get();

        return view(
            'staff.maintenance.create',
            compact('lockers')
        );
    }

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
            'reportByUser_id' => Auth::id(),
            'solveByUser_id' => null,
            'status' => 'pending',
            'report_at' => now(),
            'solve_at' => null,
        ]);

        $locker->update([
            'status' => 'maintenance',
        ]);

        return redirect()
            ->route('staff.maintenance.index')
            ->with('success', 'Maintenance issue reported successfully.');
    }

    public function edit(Maintenance $maintenance): View
    {
        $maintenance->load([
            'locker.location',
            'reporter',
            'solver',
        ]);

        return view(
            'staff.maintenance.edit',
            compact('maintenance')
        );
    }

    public function update(
        Request $request,
        Maintenance $maintenance
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
        ]);

        $newStatus = $validated['status'];

        if (
            $newStatus === 'resolved'
            && $maintenance->status !== 'resolved'
        ) {
            $validated['solveByUser_id'] = Auth::id();
            $validated['solve_at'] = now();

            $hasOtherOpenRequests = Maintenance::where(
                'locker_id',
                $maintenance->locker_id
            )
                ->where('id', '!=', $maintenance->id)
                ->whereIn('status', ['pending', 'in_progress'])
                ->exists();

            if (! $hasOtherOpenRequests) {
                Locker::where(
                    'id',
                    $maintenance->locker_id
                )->update([
                    'status' => 'available',
                ]);
            }
        }

        if (
            $newStatus !== 'resolved'
            && $maintenance->status === 'resolved'
        ) {
            $validated['solveByUser_id'] = null;
            $validated['solve_at'] = null;

            Locker::where(
                'id',
                $maintenance->locker_id
            )->update([
                'status' => 'maintenance',
            ]);
        }

        $maintenance->update($validated);

        return redirect()
            ->route('staff.maintenance.index')
            ->with('success', 'Maintenance request updated successfully.');
    }

    public function destroy(
        Maintenance $maintenance
    ): RedirectResponse {
        $lockerId = $maintenance->locker_id;

        $maintenance->delete();

        $hasOpenRequests = Maintenance::where(
            'locker_id',
            $lockerId
        )
            ->whereIn('status', ['pending', 'in_progress'])
            ->exists();

        if (! $hasOpenRequests) {
            Locker::where(
                'id',
                $lockerId
            )
                ->where(
                    'status',
                    'maintenance'
                )
                ->update([
                    'status' => 'available',
                ]);
        }

        return redirect()
            ->route('staff.maintenance.index')
            ->with(
                'success',
                'Maintenance request deleted successfully.'
            );
    }
}