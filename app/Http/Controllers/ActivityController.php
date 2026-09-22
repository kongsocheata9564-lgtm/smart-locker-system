<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ActivityController extends Controller
{
    public function place(): View
    {
        return view('activity');
    }
}
