<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class UsageHistoryController extends Controller
{
    public function index(): View
    {
        return view('user.usage-history.index');
    }
}
