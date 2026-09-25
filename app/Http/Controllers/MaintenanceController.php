<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MaintenanceController extends Controller
{
    public function index(): View
    {
        return view('user.maintenance.index');
    }
    public function staff(): View
    {
        return view('staff.maintenance.index');
    }
}
