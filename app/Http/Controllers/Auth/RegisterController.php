<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    // GET /register: show the register form
    public function create(): View
    {
        return view('auth.register');
    }

    // POST /register: create the account, log in, go back to where they came from
    public function store(Request $request): RedirectResponse
    {
        // check the form data
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // new sign-ups are always normal users (never staff)
        // NOTE: the password is hashed by the 'hashed' cast in the User model
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => strtolower($validated['email']),
            'password' => $validated['password'],
            'role'     => 'user',
            'status'   => 'active',
        ]);

        // log the new user in
        Auth::login($user);

        // regenerate() makes a new session id but KEEPS the saved page
        // (do not use invalidate() or flush(), they delete it)
        $request->session()->regenerate();

        // go back to the page they wanted before the auth middleware stopped them
        // (e.g. the locker they clicked); if there is none, use their dashboard
        return redirect()->intended(route($user->dashboardRoute()));
    }
}