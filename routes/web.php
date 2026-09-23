<?php

use App\Http\Controllers\AccessCodeController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\UsageHistoryController;
use App\Http\Controllers\UserController;
use App\Models\Location;
use Illuminate\Support\Facades\Route;

// ---------- Public ----------
Route::get('/', function () { return view('index'); })->name('home');
Route::get('/locations', [LocationController::class, 'place'])->name('location');
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
    Route::get('/lockers', [LockerController::class, 'staff'])->name('lockers.index');
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::post('/assignments/{assignment}/release', [ReleaseController::class, 'store'])->name('assignments.release');
    Route::get('/access-codes', [AccessCodeController::class, 'index'])->name('access-codes.index');
    Route::get('/usage-history', [UsageHistoryController::class, 'staff'])->name('usage-history.index');
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('/list', [UserController::class, 'userlist'])->name('list.index');
});

Route::prefix('user')->name('user.')->group(function () {
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

