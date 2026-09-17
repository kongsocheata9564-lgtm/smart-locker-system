<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(): View
    {
        return view('locations.index');
    }
}
