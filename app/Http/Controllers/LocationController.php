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
    // ---------- STAFF / ADMIN ----------

    // List of all locations (now reads from the database)
    public function index(): View
    {
        $locations = Location::latest()->paginate(10);

        return view('staff.locations.index', compact('locations'));
    }

    // Empty "Add Location" form
    public function create(): View
    {
        return view('staff.locations.create', [
            'categories' => Location::CATEGORIES,
        ]);
    }

    // Save the form into the database
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', Rule::in(Location::CATEGORIES)],
            'address' => ['required', 'string', 'max:255'],
            'price_per_hour' => ['required', 'numeric', 'min:0', 'max:999'],
            'total_lockers' => ['required', 'integer', 'min:0', 'max:1000'],
            'image' => ['nullable', 'image', 'max:2048'], // max 2MB
        ]);

        // Save the photo in storage/app/public/locations
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('locations', 'public');
        }

        // A new location starts with every locker free
        $data['free_lockers'] = $data['total_lockers'];

        Location::create($data);

        return redirect()
            ->route('staff.locations.index')
            ->with('success', 'Location created.');
    }

    // ---------- YOUR EXISTING METHODS (unchanged) ----------

    public function place(): View
    {
        $locations = Location::orderBy('name')->get();

        return view('locations.index', compact('locations'));
    }

    public function location(): View
    {
        return view('user.locations.index');
    }

    // ---------- PUBLIC ----------

    // daracook
    // Select Location page: send all locations from the database to the view
    public function select(): View
    {
        $locations = Location::latest()->get();

        return view('locations.select', compact('locations'));
    }

    // Location detail page: Laravel finds the location by its slug automatically
    public function show(Location $location): View
    {
        $location->load([
            'lockers' => fn (HasMany $query) => $query->orderBy('name'),
        ]);

        return view('locations.show', compact('location'));
    }
}
