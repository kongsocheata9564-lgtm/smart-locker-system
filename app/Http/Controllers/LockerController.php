<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LockerController extends Controller
{
    public function index(): View
    {
        return view('user.lockers.index');
    }

    public function staff(): View
    {
        return view('staff.lockers.index');
    }
}
