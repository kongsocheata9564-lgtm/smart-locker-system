<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        if (request()->routeIs('staff.users.index')) {
            return view('user.users.index');
            
        }
        return view('user.profile.index');
    }
    public function staff(): View
    {
        if (request()->routeIs('staff.users.index')) {
            return view('staff.users.index');
            
        }
        return view('staff.profile.index');
    }


    public function profile(): View
    {
        return view('profile');
    }

 

    public function userlist(): View
    {
        return view('staff.list.index');
    }

}
