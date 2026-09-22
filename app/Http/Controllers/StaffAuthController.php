<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAuthController extends Controller
{
    public function showLogin()
    {
        return view('staff.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'role' => 'staff',
        ])) {
            $request->session()->regenerate();

            return redirect()->route('staff.dashboard');
        }

        return back()->withErrors([
            'email' => 'Your account is not a staff account or the login details are incorrect.',
        ]);
    }
}
