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
use Illuminate\View\View;

class LockerController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        abort_unless($user instanceof User, 403);

        $lockers = Locker::query()
            ->with('location')
            ->whereBelongsTo($user, 'user')
            ->latest('updated_at')
            ->get();

        return view('user.lockers.index', compact('lockers'));
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

    // ---------- staff table: /staff/lockers ----------

    public function staff(Request $request): View
    {
        $request->validate([
            'q' => ['nullable', 'string', 'max:50'],
            'location' => ['nullable', 'integer'],
            'status' => ['nullable', 'in:available,occupied,maintenance'],
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
        ]);
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

    // GET /lockers/{locker}/assigned  (not needed any more, sends people to the code page)
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
