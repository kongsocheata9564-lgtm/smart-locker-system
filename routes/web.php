<?php

use App\Http\Controllers\AccessCodeController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\UsageHistoryController;
use App\Http\Controllers\UserController;
use App\Models\Location;
use App\Models\Locker;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// ---------- Public (anyone can open these, no login needed) ----------
Route::get('/', function () {
    return view('index', [
        'popular' => Location::orderByRaw('rating desc nulls last')->orderBy('name')->take(8)->get(),
        'categoryCounts' => Location::selectRaw('category, count(*) as total')->groupBy('category')->pluck('total', 'category'),
        'lockerCount' => Locker::count(),
        'locationCount' => Location::count(),
    ]);
})->name('home');
Route::get('/select-location', [LocationController::class, 'select'])->name('location.select');
Route::get('/locations', [LocationController::class, 'place'])->name('location');
Route::get('/locations/{location:slug}', [LocationController::class, 'show'])->name('location.show');
Route::get('/profiles', [UserController::class, 'profile'])->name('profile');
Route::get('/activity',  [ActivityController::class, 'place'])->name('activity');
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard.index');
    })->name('index');
    Route::get('/profile', [UserController::class, 'staff'])->name('profile');
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
    // Route::get('/lockers', [LockerController::class, 'staff'])->name('lockers.index');
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::post('/assignments/{assignment}/release', [ReleaseController::class, 'store'])->name('assignments.release');
    Route::get('/access-codes', [AccessCodeController::class, 'index'])->name('access-codes.index');
    Route::get('/usage-history', [UsageHistoryController::class, 'staff'])->name('usage-history.index');
    // Route::get('/maintenance', [MaintenanceController::class, 'staff'])->name('maintenance.index');
    Route::get('/list', [UserController::class, 'userlist'])->name('list.index');

    // cheata route lockers
    Route::get('/lockers', [LockerController::class, 'staff'])->name('lockers.index');
    Route::get('/lockers/create', [LockerController::class, 'create'])->name('lockers.create');
    Route::post('/lockers', [LockerController::class, 'store'])->name('lockers.store');
    Route::get('/lockers/{locker}/edit', [LockerController::class, 'edit'])->name('lockers.edit');
    Route::put('/lockers/{locker}', [LockerController::class, 'update'])->name('lockers.update');
    Route::delete('/lockers/{locker}', [LockerController::class, 'destroy'])->name('lockers.destroy');
    // cheata end route lockers



    // cheata route locations
    Route::get('/locations', [LocationController::class, 'index'])
        ->name('locations.index');
    Route::get('/locations/create', [LocationController::class, 'create'])
        ->name('locations.create');
    Route::post('/locations', [LocationController::class, 'store'])
        ->name('locations.store');
    Route::get('/locations/{location}/edit', [LocationController::class, 'edit'])
        ->name('locations.edit');
    Route::put('/locations/{location}', [LocationController::class, 'update'])
        ->name('locations.update');
    Route::delete('/locations/{location}', [LocationController::class, 'destroy'])
        ->name('locations.destroy');
    Route::get('/locations/{location:slug}', [LocationController::class, 'show'])->name('location.show');
    // cheata end route locations




    //cheata route maintenance
    Route::get('/maintenance', [MaintenanceController::class, 'staff'])->name('maintenance.index');
    Route::get('/maintenance/create', [MaintenanceController::class, 'create'])->name('maintenance.create');
    Route::post('/maintenance', [MaintenanceController::class, 'storeStaff'])->name('maintenance.store');
    Route::get('/maintenance/{maintenance}/edit', [MaintenanceController::class, 'edit'])->name('maintenance.edit');
    Route::put('/maintenance/{maintenance}', [MaintenanceController::class, 'update'])->name('maintenance.update');
    Route::delete('/maintenance/{maintenance}', [MaintenanceController::class, 'destroy'])->name('maintenance.destroy');
    //cheata end route maintenance
});

// ---------- Guest only (login / register pages) ----------
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

// ---------- Logged-in users only ----------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/activity', [ActivityController::class, 'place'])->name('activity');

    // ---------- Locker flow (any logged-in user) ----------
    Route::get('/lockers/{locker}', [LockerController::class, 'show'])->name('locker.show');
    Route::post('/lockers/{locker}/assign', [LockerController::class, 'assign'])->name('locker.assign');
    Route::get('/lockers/{locker}/assigned', [LockerController::class, 'assigned'])->name('locker.assigned');
    Route::get('/lockers/{locker}/code', [LockerController::class, 'code'])->name('locker.code');
    Route::get('/lockers/{locker}/close', [LockerController::class, 'close'])->name('locker.close');
    Route::post('/lockers/{locker}/close', [LockerController::class, 'closeStore'])->name('locker.close.store');
    Route::get('/lockers/{locker}/in-use', [LockerController::class, 'inUse'])->name('locker.inUse');
    Route::get('/lockers/{locker}/release', [LockerController::class, 'release'])->name('locker.release');
    Route::get('/lockers/{locker}/release/confirm', [LockerController::class, 'releaseConfirm'])->name('locker.release.confirm');
    Route::post('/lockers/{locker}/release', [LockerController::class, 'releaseStore'])->name('locker.release.store');
    Route::get('/lockers/{locker}/released', [LockerController::class, 'released'])->name('locker.released');

    // ---------- ADMIN only ----------
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserRoleController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/role', [UserRoleController::class, 'update'])->name('users.role');
    });

    // ---------- STAFF (role: staff or admin) ----------
    Route::middleware('role:staff,admin')->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', function () {
            $byStatus = Locker::selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

            $lockerTotal = Locker::count();
            $available = (int) ($byStatus['available'] ?? 0);
            $occupied = (int) ($byStatus['occupied'] ?? 0);
            $maintenance = (int) ($byStatus['maintenance'] ?? 0);

            // Recent activity from records that exist in the database
            $activity = collect()
                ->concat(User::where('role', 'user')->latest()->take(4)->get()->map(fn ($u) => [
                    'type' => 'user', 'text' => 'New user registered', 'strong' => $u->name, 'time' => $u->created_at,
                ]))
                ->concat(Location::latest()->take(3)->get()->map(fn ($l) => [
                    'type' => 'location', 'text' => 'New location added', 'strong' => $l->name, 'time' => $l->created_at,
                ]))
                ->concat(Locker::where('status', 'maintenance')->latest('updated_at')->take(3)->get()->map(fn ($k) => [
                    'type' => 'maintenance', 'text' => 'Locker under maintenance', 'strong' => $k->name, 'time' => $k->updated_at,
                ]))
                ->concat(Locker::where('status', 'occupied')->latest('updated_at')->take(3)->get()->map(fn ($k) => [
                    'type' => 'in_use', 'text' => 'Locker in use', 'strong' => $k->name, 'time' => $k->updated_at,
                ]))
                ->sortByDesc(fn ($a) => $a['time']->timestamp)
                ->take(6)
                ->values();

            return view('staff.dashboard.index', [
                'locationCount' => Location::count(),
                'categoryCount' => Location::distinct()->count('category'),
                'lockerTotal' => $lockerTotal,
                'available' => $available,
                'occupied' => $occupied,
                'maintenance' => $maintenance,
                'usagePct' => $lockerTotal ? round($occupied / $lockerTotal * 100) : 0,
                'activeUsers' => User::where('role', 'user')->where('status', 'active')->count(),
                'newUsersWeek' => User::where('role', 'user')->where('created_at', '>=', now()->subDays(7))->count(),
                'activity' => $activity,
            ]);
        })->name('index');

        Route::get('/profile', [UserController::class, 'staff'])->name('profile');
        Route::get('/locations/create', [LocationController::class, 'create'])->name('locations.create');
        Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
        Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
        Route::get('/lockers', [LockerController::class, 'staff'])->name('lockers.index');
        Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
        Route::post('/assignments/{assignment}/release', [ReleaseController::class, 'store'])->name('assignments.release');
        Route::get('/access-codes', [AccessCodeController::class, 'index'])->name('access-codes.index');
        Route::get('/usage-history', [UsageHistoryController::class, 'staff'])->name('usage-history.index');
        Route::get('/maintenance', [MaintenanceController::class, 'staff'])->name('maintenance.index');
        Route::get('/list', [UserController::class, 'userlist'])->name('list.index');
    });

    // ---------- USER (role: user, admin) ----------
    Route::middleware('role:user,admin')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', function () {
            return view('user.dashboard.index');
        })->name('index');
        Route::get('/profile', [UserController::class, 'index'])->name('profile');
        Route::get('/locations', [LocationController::class, 'location'])->name('location.user');
        Route::get('/lockers', [LockerController::class, 'index'])->name('lockers.index');
        Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
        Route::post('/assignments/{assignment}/release', [ReleaseController::class, 'store'])->name('assignments.release');
        Route::get('/access-codes', [AccessCodeController::class, 'index'])->name('access-codes.index');
        Route::get('/usage-history', [UsageHistoryController::class, 'index'])->name('usage-history.index');
        Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
        Route::get('/list', [UserController::class, 'userlist'])->name('list.index');
    });
});
