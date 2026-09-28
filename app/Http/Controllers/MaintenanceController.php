<?php

namespace App\Http\Controllers;

use App\Models\Locker;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    // ---------- User side ----------

    public function index(Request $request): View
    {
        $maintenances = Maintenance::with('locker.location')
            ->where('reportByUser_id', auth()->id())
            ->latest('report_at')
            ->paginate(10);

        $lockers = Locker::orderBy('locker_name')->get();

        return view('user.maintenance.index', compact('maintenances', 'lockers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'locker_id' => 'required|exists:lockers,id',
            'reason' => 'required|string|max:255',
        ]);

        Maintenance::create($validated + [
            'reportByUser_id' => auth()->id(),
            'status' => 'pending',
            'report_at' => now(),
        ]);

        Locker::where('id', $validated['locker_id'])->update(['status' => 'maintenance']);

        return back()->with('success', 'Issue reported.');
    }

    // ---------- Staff side ----------

    public function staff(Request $request): View
    {
        $query = Maintenance::with(['locker.location', 'reporter', 'solver']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('location_id')) {
            $query->whereHas('locker', fn ($q) => $q->where('location_id', $request->location_id));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reason', 'like', "%{$search}%")
                  ->orWhereHas('locker', fn ($lq) => $lq->where('locker_name', 'like', "%{$search}%"));
            });
        }

        $maintenances = $query->latest('report_at')->paginate(15)->withQueryString();

        $stats = [
            'pending' => Maintenance::where('status', 'pending')->count(),
            'in_progress' => Maintenance::where('status', 'in_progress')->count(),
            'resolved_this_week' => Maintenance::where('status', 'resolved')
                ->where('solve_at', '>=', now()->startOfWeek())
                ->count(),
            'out_of_service' => Locker::where('status', 'maintenance')->count(),
        ];

        $locations = \App\Models\Location::orderBy('name')->get();

        return view('staff.maintenance.index', compact('maintenances', 'stats', 'locations'));
    }

    public function create(): View
    {
        $lockers = Locker::orderBy('locker_name')->get();

        return view('staff.maintenance.create', compact('lockers'));
    }

    public function storeStaff(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'locker_id' => 'required|exists:lockers,id',
            'reason' => 'required|string|max:255',
        ]);

        Maintenance::create($validated + [
            'reportByUser_id' => auth()->id(),
            'status' => 'pending',
            'report_at' => now(),
        ]);

        Locker::where('id', $validated['locker_id'])->update(['status' => 'maintenance']);

        return redirect()->route('staff.maintenance.index')->with('success', 'Issue reported.');
    }

    public function edit(Maintenance $maintenance): View
    {
        return view('staff.maintenance.edit', compact('maintenance'));
    }

    public function update(Request $request, Maintenance $maintenance): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
        ]);

        if ($validated['status'] === 'resolved' && $maintenance->status !== 'resolved') {
            $validated['sovleByUser_id'] = auth()->id();
            $validated['solve_at'] = now();
            Locker::where('id', $maintenance->locker_id)->update(['status' => 'available']);
        }

        $maintenance->update($validated);

        return redirect()->route('staff.maintenance.index')->with('success', 'Request updated.');
    }
}