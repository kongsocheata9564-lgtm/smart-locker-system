<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LocationController extends Controller
{
    private const LOCATION_OPTIONS = [
        [
            'name' => 'Central Library',
            'address' => 'Phnom Penh',
        ],
        [
            'name' => 'Olympic Stadium',
            'address' => 'Phnom Penh',
        ],
        [
            'name' => 'AEON Mall Sen Sok',
            'address' => 'Phnom Penh',
        ],
    ];

    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $locations = Location::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%")
                        ->orWhere('address', 'ilike', "%{$search}%")
                        ->orWhere('type', 'ilike', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('staff.locations.index', compact('locations', 'search'));
    }

    public function create(): View
    {
        $locationOptions = self::LOCATION_OPTIONS;

        return view(
            'staff.locations.create',
            compact('locationOptions')
        );
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
        $locationOptions = self::LOCATION_OPTIONS;

        return view(
            'staff.locations.edit',
            compact('location', 'locationOptions')
        );
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
            ->orderBy('name')
            ->get();

        return view('location', compact('locations'));
    }

    public function location(): View
    {
        $locations = Location::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('user.locations.index', compact('locations'));
    }
}
