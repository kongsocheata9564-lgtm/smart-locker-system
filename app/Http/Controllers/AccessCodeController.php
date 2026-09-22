<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AccessCodeController extends Controller
{
    public function index(): View
    {
        return view('user.access-codes.index');
    }
}
