<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(): View
    {
        return view('staff.locations.index');
    }

    public function place() : View
    {
        return view('location');
    }
    public function location() : View
    {
        return view('user.locations.index');
    }
}
