<?php

use App\Http\Controllers\AccessCodeController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\UsageHistoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// =====================================================================
// PUBLIC
// =====================================================================
Route::get('/', function () { return view('index'); })->name('home');                        // [DONE] landing page
Route::get('/locations', [LocationController::class, 'place'])->name('location');            // [DONE]
Route::get('/profiles', [UserController::class, 'profile'])->name('profile');                // [FRIEND]
Route::get('/activity', [ActivityController::class, 'place'])->name('activity');             // [DONE]

// [FRIEND] login / register: LoginController::store still redirects to
// 'user.dashboard', which does not exist. It should be 'user.index'.
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// =====================================================================
// STAFF (desktop layout: layouts.app / layouts.app1)
// =====================================================================
Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard.index');
    })->name('index');                                                                       // [DONE]
    Route::get('/profile', [UserController::class, 'staff'])->name('profile');               // [FRIEND]
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index'); // [DONE]
    Route::get('/lockers', [LockerController::class, 'staff'])->name('lockers.index');       // [DONE]
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index'); // [CHANGED] redirects to user.lockers.index
    Route::post('/assignments/{assignment}/release', [ReleaseController::class, 'store'])->name('assignments.release'); // [DONE]
    Route::get('/access-codes', [AccessCodeController::class, 'index'])->name('access-codes.index'); // [CHANGED] duplicate class removed
    Route::get('/usage-history', [UsageHistoryController::class, 'staff'])->name('usage-history.index'); // [DONE]
    Route::get('/maintenance', [MaintenanceController::class, 'staff'])->name('maintenance.index'); // [FRIEND]
    Route::get('/list', [UserController::class, 'userlist'])->name('list.index');            // [FRIEND]
});

// =====================================================================
// USER (phone-screen layout: layouts.user)
// Flow: Locations -> Lockers -> Confirm -> Assigned -> Release -> Released -> History
// =====================================================================
Route::prefix('user')->name('user.')->group(function () {

    // --- Home / account ---
    Route::get('/dashboard', function () {
        return view('user.dashboard.index');
    })->name('index');                                                                       // [TODO] dashboard view is still a placeholder
    Route::get('/profile', [UserController::class, 'index'])->name('profile');               // [FRIEND]

    // --- 1. Search / Select Location ---
    Route::get('/locations', [LocationController::class, 'location'])->name('location.user'); // [CHANGED] duplicates removed

    // --- 2. Location details + locker list ---
    Route::get('/locations/{location}/lockers', [LockerController::class, 'byLocation'])->name('locations.lockers'); // [CHANGED] shows ALL statuses + counts, duplicate removed

    // --- My Locker (only lockers the user is using) ---
    Route::get('/lockers', [LockerController::class, 'index'])->name('lockers.index');       // [CHANGED] now uses LockerUsage, shows only user's active locker

    // --- 3. Select + Confirm locker ---
    Route::get('/lockers/{locker}/confirm', [AssignmentController::class, 'confirm'])->name('lockers.confirm'); // [CHANGED] duplicate removed, loads location
    Route::post('/lockers/{locker}/select', [AssignmentController::class, 'store'])->name('lockers.select');    // [CHANGED] uses AssignmentService + locker_usage table

    // --- 4. Locker assigned + code ---
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index'); // [CHANGED] redirects to My Locker
    Route::get('/assignments/{assignment}', [AssignmentController::class, 'show'])->name('assignments.show'); // [CHANGED] {assignment} is now a LockerUsage row

    // --- 5. Release flow ---
    Route::get('/assignments/{assignment}/release', [ReleaseController::class, 'confirm'])->name('assignments.release.confirm'); // [NEW] Confirm Release page
    Route::post('/assignments/{assignment}/release', [ReleaseController::class, 'store'])->name('assignments.release');         // [CHANGED] no more UsageHistory table
    Route::get('/assignments/{assignment}/released', [ReleaseController::class, 'released'])->name('assignments.released');     // [NEW] Locker Released page

    // --- 6. Usage history ---
    Route::get('/usage-history', [UsageHistoryController::class, 'index'])->name('usage-history.index'); // [CHANGED] reads finished rows from locker_usage

    // --- Other ---
    Route::get('/access-codes', [AccessCodeController::class, 'index'])->name('access-codes.index'); // [CHANGED] duplicate class removed
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index'); // [FRIEND]
    Route::get('/list', [UserController::class, 'userlist'])->name('list.index');            // [FRIEND]
});

// [TODO] Put Belongings Inside, Locker Receipt, You're all set, Maintenance Locker Details