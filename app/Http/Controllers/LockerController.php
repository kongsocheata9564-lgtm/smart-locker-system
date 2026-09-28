<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LockerController extends Controller
{
    public function index(): View
    {
        return view('user.lockers.index');
    }

    public function staff(): View
    {
        return view('staff.lockers.index');
    }
    public function show($locker)
    {
        return view('lockers.show', compact('locker'));
    }
    public function assign($locker)
    {
        return redirect()->route('locker.assigned', $locker);
    }

    public function assigned($locker)
    {
        return view('lockers.assigned', compact('locker'));
    }

    public function code($locker)
    {
        return view('lockers.code', compact('locker'));
    }
    public function close($locker)
{
    return view('lockers.close', compact('locker'));
}

public function closeStore($locker)
{
    return redirect()->route('locker.inUse', $locker);
}

public function inUse($locker)
{
    return view('lockers.in-use', compact('locker'));
}

public function release($locker)
{
    return view('lockers.release', compact('locker'));
}

public function releaseConfirm($locker)
{
    return view('lockers.release-confirm', compact('locker'));
}

public function releaseStore($locker)
{
    return redirect()->route('locker.released', $locker);
}

public function released($locker)
{
    return view('lockers.released', compact('locker'));
}
}
