<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LocationController extends Controller
{
    // Staff: list locations with search + pagination
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

    // Staff: show the create form
    public function create(): View
    {
        return view('staff.locations.create');
    }

    // Staff: save a new location
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

        // table needs a unique slug: build it from the name + random suffix
        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::lower(Str::random(5));

        // table needs category: "shopping_mall" becomes "Shopping Mall"
        $validated['category'] = Str::headline($validated['type']);

        Location::create($validated);

        return redirect()
            ->route('staff.locations.index')
            ->with('success', 'Location created successfully.');
    }

    // Staff: show the edit form
    public function edit(Location $location): View
    {
        return view('staff.locations.edit', compact('location'));
    }

    // Staff: save changes to a location
    public function update(Request $request, Location $location): RedirectResponse
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

        // keep category in sync with type (slug stays the same so links don't break)
        $validated['category'] = Str::headline($validated['type']);

        $location->update($validated);

        return redirect()
            ->route('staff.locations.index')
            ->with('success', 'Location updated successfully.');
    }

    // Staff: delete a location
    public function destroy(Location $location): RedirectResponse
    {
        $location->delete();

        return redirect()
            ->route('staff.locations.index')
            ->with('success', 'Location deleted successfully.');
    }

    // Public: list of all active locations
    // CHANGED BACK: send the models as they are.
    // locations/index.blade.php converts them to arrays by itself.
    public function place(): View
    {
        $locations = Location::where('status', 'active')
            ->latest()
            ->get();

        return view('locations.index', compact('locations'));
    }

    // Public: page for ONE location (found by slug from the route)
    public function show(Location $location): View
    {
        // inactive locations are hidden from the public
        abort_if($location->status !== 'active', 404);

        return view('locations.show', compact('location'));
    }

    // Logged-in user: list of active locations
    public function location(): View
    {
        $locations = Location::where('status', 'active')
            ->latest()
            ->get();

        return view('user.locations.index', compact('locations'));
    }
}