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
        return view('locations.index');
    }
    public function location() : View
    {
        return view('user.locations.index');
    }




    //daracook
     public function select(): View
    {
        return view('locations.select');
    }

    public function show(): View
    {
        
        return view('locations.show');
    }
}
