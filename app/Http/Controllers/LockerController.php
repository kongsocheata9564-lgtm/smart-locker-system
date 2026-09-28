<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Locker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LockerController extends Controller
{
    private const STATUSES = ['available', 'in_use', 'maintenance'];
    private const TYPES = ['small', 'medium', 'large'];

    public function index(Request $request): View
    {
        return view('user.lockers.index');
    }

    public function create(): View
    {
        return view('lockers.create', [
            'locations' => Location::orderBy('name')->get(),
            'statuses' => self::STATUSES,
            'types' => self::TYPES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'locker_name' => ['required', 'string', 'max:255'],
            'location_id' => ['required', 'exists:locations,id'],
            'password' => ['required', 'string', 'min:4'],
            'status' => ['required', 'in:' . implode(',', self::STATUSES)],
            'type' => ['required', 'in:' . implode(',', self::TYPES)],
        ]);

        Locker::create($data);

        return redirect()->route(
            $request->routeIs('staff.*') ? 'staff.lockers.index' : 'user.lockers.index'
        )->with('success', 'Locker created successfully.');
    }

    public function edit(Locker $locker): View
    {
        return view('lockers.edit', [
            'locker' => $locker,
            'locations' => Location::orderBy('name')->get(),
            'statuses' => self::STATUSES,
            'types' => self::TYPES,
        ]);
    }

    public function update(Request $request, Locker $locker): RedirectResponse
    {
        $data = $request->validate([
            'locker_name' => ['required', 'string', 'max:255'],
            'location_id' => ['required', 'exists:locations,id'],
            'password' => ['nullable', 'string', 'min:4'],
            'status' => ['required', 'in:' . implode(',', self::STATUSES)],
            'type' => ['required', 'in:' . implode(',', self::TYPES)],
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $locker->update($data);

        return redirect()->route(
            $request->routeIs('staff.*') ? 'staff.lockers.index' : 'user.lockers.index'
        )->with('success', 'Locker updated successfully.');
    }

    public function destroy(Request $request, Locker $locker): RedirectResponse
    {
        $locker->delete();

        return redirect()->route(
            $request->routeIs('staff.*') ? 'staff.lockers.index' : 'user.lockers.index'
        )->with('success', 'Locker deleted successfully.');
    }
}