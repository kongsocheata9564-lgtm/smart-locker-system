<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Location::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('address', 'ilike', "%{$search}%")
                    ->orWhere('type', 'ilike', "%{$search}%");
            });
        }

        $locations = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('staff.locations.index', compact('locations'));
    }

    public function create(): View
    {
        return view('staff.locations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'type' => [
                'required',
                'in:library,shopping_mall,sports_center,building,public_place',
            ],
            'status' => ['required', 'in:active,inactive'],
            'map' => ['nullable', 'string', 'max:255'],
        ]);

        Location::create($validated);

        return redirect()
            ->route('staff.locations.index')
            ->with('success', 'Location created successfully.');
    }

    public function edit(Location $location): View
    {
        return view('staff.locations.edit', compact('location'));
    }

    public function update(
        Request $request,
        Location $location
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'type' => [
                'required',
                'in:library,shopping_mall,sports_center,building,public_place',
            ],
            'status' => ['required', 'in:active,inactive'],
            'map' => ['nullable', 'string', 'max:255'],
        ]);

        $location->update($validated);

        return redirect()
            ->route('staff.locations.index')
            ->with('success', 'Location updated successfully.');
    }

    public function destroy(Location $location): RedirectResponse
    {
        $location->delete();

        return redirect()
            ->route('staff.locations.index')
            ->with('success', 'Location deleted successfully.');
    }

    public function place(): View
    {
        $locations = Location::where('status', 'active')
            ->latest()
            ->get();

        return view('location', compact('locations'));
    }

    public function location(): View
    {
        $locations = Location::where('status', 'active')
            ->latest()
            ->get();

        return view('user.locations.index', compact('locations'));
    }
}