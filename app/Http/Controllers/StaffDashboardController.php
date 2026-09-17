<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class StaffDashboardController extends Controller
{
    public function index(): View
    {
        return view('staff.dashboard');
    }
}
