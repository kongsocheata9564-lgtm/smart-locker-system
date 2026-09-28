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
use App\Http\Controllers\Admin\UserRoleController;

// ---------- Public (anyone can open these, no login needed) ----------
Route::get('/', function () { return view('index'); })->name('home');
Route::get('/select-location', [LocationController::class, 'select'])->name('location.select');
Route::get('/locations', [LocationController::class, 'place'])->name('location');
Route::get('/locations/{location}', [LocationController::class, 'show'])->name('location.show');

// ---------- Guest only (login / register pages) ----------
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

// ---------- Logged-in users only ----------
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/profiles', [UserController::class, 'profile'])->name('profile');
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
            return view('staff.dashboard.index');
        })->name('index');
        Route::get('/profile', [UserController::class, 'staff'])->name('profile');
        Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
        Route::get('/lockers', [LockerController::class, 'staff'])->name('lockers.index');
        Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
        Route::post('/assignments/{assignment}/release', [ReleaseController::class, 'store'])->name('assignments.release');
        Route::get('/access-codes', [AccessCodeController::class, 'index'])->name('access-codes.index');
        Route::get('/usage-history', [UsageHistoryController::class, 'staff'])->name('usage-history.index');
        Route::get('/maintenance', [MaintenanceController::class, 'staff'])->name('maintenance.index');
        Route::get('/list', [UserController::class, 'userlist'])->name('list.index');
    });

    // ---------- USER (role: user only) ----------
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