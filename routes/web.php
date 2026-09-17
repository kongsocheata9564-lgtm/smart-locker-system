<?php

use App\Http\Controllers\AccessCodeController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\UsageHistoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/profile', [UserController::class, 'index'])->name('profile');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
Route::get('/lockers', [LockerController::class, 'index'])->name('lockers.index');
Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
Route::get('/access-codes', [AccessCodeController::class, 'index'])->name('access-codes.index');
Route::post('/assignments/{assignment}/release', [ReleaseController::class, 'store'])->name('assignments.release');
Route::get('/usage-history', [UsageHistoryController::class, 'index'])->name('usage-history.index');
Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
Route::get('/staff/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');
