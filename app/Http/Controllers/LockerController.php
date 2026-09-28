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
        return view('locker.create', [ // CHANGED
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

        return redirect()->route('lockers.index')->with('success', 'Locker created successfully.');
    }

    public function edit(Locker $locker): View
    {
        return view('locker.edit', [ // CHANGED
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

        // Keep the old password if the field is left empty
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $locker->update($data);

        return redirect()->route('lockers.index')->with('success', 'Locker updated successfully.');
    }

    public function destroy(Locker $locker): RedirectResponse
    {
        $locker->delete();

        return redirect()->route('lockers.index')->with('success', 'Locker deleted successfully.');
    }
    public function show($locker)
    {
        return view('lockers.show', compact('locker'));
    }
    public function assign($locker)
    {
        return redirect()->route('locker.assigned', $locker);
    }

    public function assigned($locker)
    {
        return view('lockers.assigned', compact('locker'));
    }

    public function code($locker)
    {
        return view('lockers.code', compact('locker'));
    }
    public function close($locker)
{
    return view('lockers.close', compact('locker'));
}

public function closeStore($locker)
{
    return redirect()->route('locker.inUse', $locker);
}

public function inUse($locker)
{
    return view('lockers.in-use', compact('locker'));
}

public function release($locker)
{
    return view('lockers.release', compact('locker'));
}

public function releaseConfirm($locker)
{
    return view('lockers.release-confirm', compact('locker'));
}

public function releaseStore($locker)
{
    return redirect()->route('locker.released', $locker);
}

public function released($locker)
{
    return view('lockers.released', compact('locker'));
}
}
