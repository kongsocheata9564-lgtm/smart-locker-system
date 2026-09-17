<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MaintenanceController extends Controller
{
    public function index(): View
    {
        return view('maintenance.index');
    }
}
