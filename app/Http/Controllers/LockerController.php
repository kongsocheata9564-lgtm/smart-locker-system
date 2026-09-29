<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Locker;
use App\Models\UsageHistory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LockerController extends Controller
{
    // 'occupied' (not 'in_use') because assign() and the staff filter both use 'occupied'
    private const STATUSES = ['available', 'occupied', 'maintenance'];

    private const TYPES = ['small', 'medium', 'large'];

    private const MAX_LOCKER_NAME_NUMBER = 10;

    // ---------- user: my lockers (/user/lockers) ----------

    public function index(Request $request): View
    {
        $user = $request->user();

        abort_unless($user instanceof User, 403);

        // only the lockers this user is using right now
        // AFTER
        $myActive = UsageHistory::query()
            ->with('locker.location')
            ->where('user_id', $user->id)
            ->whereNull('end_time')
            ->latest('start_time')
            ->get();

        return view('user.lockers.index', compact('myActive'));
    }

    // ---------- helpers ----------

    // The open (not yet released) usage of this locker. Staff can see anyone's.
    private function activeUsage(Locker $locker, User $user): ?UsageHistory
    {
        return UsageHistory::query()
            ->where('locker_id', $locker->id)
            ->whereNull('end_time')
            ->when(! $user->isStaff(), fn ($q) => $q->where('user_id', $user->id))
            ->latest('start_time')
            ->first();
    }

    // 6 characters, without look-alikes such as 0/O and 1/I
    private function newCode(): string
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return $code;
    }

    // after staff create/update/delete, go back to the right list
    private function backToList(Request $request): RedirectResponse
    {
        return redirect()->route(
            $request->routeIs('staff.*') ? 'staff.lockers.index' : 'user.lockers.index'
        );
    }

    /**
     * @return array<int, string>
     */
    private function availableLockerNames(?Locker $locker = null): array
    {
        $usedNames = Locker::query()
            ->when($locker !== null, fn ($query) => $query->where('id', '!=', $locker->id))
            ->pluck('name')
            ->all();
        $usedNames = array_fill_keys($usedNames, true);
        $names = [];

        for ($number = 1; $number <= self::MAX_LOCKER_NAME_NUMBER; $number++) {
            $name = sprintf('L-%03d', $number);

            if (! isset($usedNames[$name])) {
                $names[] = $name;
            }
        }

        if ($locker !== null && ! in_array($locker->name, $names, true)) {
            $names[] = $locker->name;
        }

        return $names;
    }

    // ---------- staff table: /staff/lockers ----------

    public function staff(Request $request): View
    {
        $request->validate([
            'q' => ['nullable', 'string', 'max:50'],
            'location' => ['nullable', 'integer'],
            'status' => ['nullable', 'in:'.implode(',', self::STATUSES)],
        ]);

        $lockers = Locker::query()
            ->with('location')
            ->withMax('usages', 'start_time')
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'ilike', '%'.$request->input('q').'%'))
            ->when($request->filled('location'), fn ($q) => $q->where('location_id', $request->input('location')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->orderBy('location_id')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('staff.lockers.index', [
            'lockers' => $lockers,
            'locations' => Location::orderBy('name')->get(['id', 'name']),
            'statuses' => self::STATUSES,
        ]);
    }

    // ---------- staff CRUD (cheata) ----------

    // GET /staff/lockers/create
    // NOTE: view name 'lockers.create' comes from your teammate's code.
    // If your file is resources/views/staff/lockers/create.blade.php, change it.
    public function create(): View
    {
        return view('lockers.create', [
            'locations' => Location::orderBy('name')->get(),
            'lockerNames' => $this->availableLockerNames(),
            'statuses' => self::STATUSES,
            'types' => self::TYPES,
        ]);
    }

    // POST /staff/lockers
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('lockers', 'name')],
            'location_id' => ['required', 'exists:locations,id'],
            'price_per_hour' => ['required', 'numeric', 'min:0'],
            'password' => ['nullable', 'string', 'min:4'],
            'status' => ['required', 'in:'.implode(',', self::STATUSES)],
            'type' => ['required', 'in:'.implode(',', self::TYPES)],
        ]);

        // the table has a password column: hash it, or make a random one if left empty
        $data['password'] = Hash::make($data['password'] ?? $this->newCode());

        $locker = Locker::create($data);
        $locker->syncLocationCounts();

        return $this->backToList($request)->with('success', 'Locker created successfully.');
    }

    // GET /staff/lockers/{locker}/edit
    public function edit(Locker $locker): View
    {
        return view('lockers.edit', [
            'locker' => $locker,
            'locations' => Location::orderBy('name')->get(),
            'lockerNames' => $this->availableLockerNames($locker),
            'statuses' => self::STATUSES,
            'types' => self::TYPES,
        ]);
    }

    // PUT /staff/lockers/{locker}
    public function update(Request $request, Locker $locker): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('lockers', 'name')->ignore($locker->id)],
            'location_id' => ['required', 'exists:locations,id'],
            'price_per_hour' => ['required', 'numeric', 'min:0'],
            'password' => ['nullable', 'string', 'min:4'],
            'status' => ['required', 'in:'.implode(',', self::STATUSES)],
            'type' => ['required', 'in:'.implode(',', self::TYPES)],
        ]);

        // empty password box = keep the old password
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $locker->update($data);
        $locker->syncLocationCounts();

        return $this->backToList($request)->with('success', 'Locker updated successfully.');
    }

    // DELETE /staff/lockers/{locker}
    public function destroy(Request $request, Locker $locker): RedirectResponse
    {
        $locker->delete();

        return $this->backToList($request)->with('success', 'Locker deleted successfully.');
    }

    // ---------- user flow ----------

    // GET /lockers/{locker}
    public function show(Locker $locker): View
    {
        $locker->load('location');

        return view('lockers.show', compact('locker'));
    }

    // POST /lockers/{locker}/assign
    public function assign(Request $request, Locker $locker): RedirectResponse
    {
        $code = $this->newCode();

        // lockForUpdate stops two people from taking the same locker at the same moment
        $usage = DB::transaction(function () use ($request, $locker, $code) {
            $fresh = Locker::query()->whereKey($locker->id)->lockForUpdate()->first();

            if (! $fresh || $fresh->status !== 'available') {
                return null;
            }

            $usage = UsageHistory::create([
                'locker_id' => $fresh->id,
                'user_id' => $request->user()->id,
                'one_time_password' => Hash::make($code),
                'start_time' => now(),
                'status' => 'active',
            ]);

            $fresh->update(['status' => 'occupied', 'user_id' => $request->user()->id]);

            return $usage;
        });

        if (! $usage) {
            return redirect()->route('locker.show', $locker)
                ->with('error', 'Sorry, this locker was just taken. Please choose another one.');
        }

        $locker->refresh()->syncLocationCounts();

        // Kept in the session so the code page can show it (only the hash is stored in the database)
        session(['locker_code_'.$usage->id => $code]);

        return redirect()->route('locker.code', $locker);
    }

    // GET /lockers/{locker}/assigned (not needed any more, sends people to the code page)
    public function assigned(Locker $locker): RedirectResponse
    {
        return redirect()->route('locker.code', $locker);
    }

    // GET /lockers/{locker}/code
    public function code(Request $request, Locker $locker): View|RedirectResponse
    {
        $usage = $this->activeUsage($locker, $request->user());

        if (! $usage) {
            return redirect()->route('locker.show', $locker);
        }

        $locker->load('location');

        return view('lockers.code', [
            'locker' => $locker,
            'usage' => $usage,
            'code' => session('locker_code_'.$usage->id),
        ]);
    }

    // GET /lockers/{locker}/close
    public function close(Request $request, Locker $locker): View|RedirectResponse
    {
        if (! $this->activeUsage($locker, $request->user())) {
            return redirect()->route('locker.show', $locker);
        }

        return view('lockers.close', compact('locker'));
    }

    // POST /lockers/{locker}/close
    public function closeStore(Locker $locker): RedirectResponse
    {
        return redirect()->route('locker.inUse', $locker);
    }

    // GET /lockers/{locker}/in-use
    public function inUse(Request $request, Locker $locker): View|RedirectResponse
    {
        if (! $this->activeUsage($locker, $request->user())) {
            return redirect()->route('locker.show', $locker);
        }

        return view('lockers.in-use', compact('locker'));
    }

    // GET /lockers/{locker}/release
    public function release(Request $request, Locker $locker): View|RedirectResponse
    {
        $usage = $this->activeUsage($locker, $request->user());

        if (! $usage) {
            return redirect()->route('locker.show', $locker);
        }

        $locker->load('location');

        return view('lockers.release', [
            'locker' => $locker,
            'usage' => $usage,
            'isStaff' => $request->user()->isStaff(),
        ]);
    }

    // GET /lockers/{locker}/release/confirm
    public function releaseConfirm(Locker $locker): RedirectResponse
    {
        return redirect()->route('locker.release', $locker);
    }

    // POST /lockers/{locker}/release
    public function releaseStore(Request $request, Locker $locker): RedirectResponse
    {
        $user = $request->user();
        $usage = $this->activeUsage($locker, $user);

        if (! $usage) {
            return redirect()->route('locker.show', $locker)
                ->with('error', 'There is no active session for this locker.');
        }

        // Staff can release without the code; everyone else must type it
        if (! $user->isStaff()) {
            $request->validate(['code' => ['required', 'string', 'size:6']]);

            if (! Hash::check(strtoupper(trim($request->input('code'))), $usage->one_time_password ?? '')) {
                return back()->withErrors(['code' => 'That code is not correct.']);
            }
        }

        DB::transaction(function () use ($usage, $locker) {
            $usage->update(['end_time' => now(), 'status' => 'completed']);
            $locker->update(['status' => 'available', 'user_id' => null]);
        });

        session()->forget('locker_code_'.$usage->id);
        $locker->refresh()->syncLocationCounts();

        return redirect()->route('locker.released', $locker);
    }

    // GET /lockers/{locker}/released
    public function released(Locker $locker): View
    {
        $locker->load('location');

        return view('lockers.released', compact('locker'));
    }
}
