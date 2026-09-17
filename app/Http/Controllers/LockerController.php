<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LockerController extends Controller
{
    public function index(): View
    {
        return view('lockers.index');
    }
}
