<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(): RedirectResponse
    {
        return redirect()->route('user.dashboard');
    }

    public function destroy(): RedirectResponse
    {
        return redirect()->route('login');
    }
}
