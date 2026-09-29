<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class UsageHistoryController extends Controller
{
   public function index(): View
{
    $usages = \App\Models\LockerUsage::with('locker.location')
        ->where('user_id', auth()->id())
        ->whereNotNull('end_time')
        ->latest('end_time')
        ->get();

    return view('user.usage-history.index', compact('usages'));
}

    public function staff(): View
    {
        return view('staff.usage-history.index');
    }
}
