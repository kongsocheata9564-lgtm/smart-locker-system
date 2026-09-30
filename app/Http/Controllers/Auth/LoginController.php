<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    // GET /login: show the login form
    public function create(): View
    {
        return view('auth.login');
    }

    // POST /login: check the credentials and send the person to the right page
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials['email'] = strtolower($credentials['email']);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // block accounts that are not active
            if ($user->status !== 'active') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Your account is not active. Please contact an administrator.',
                ])->onlyInput('email');
            }

            // new session id, but the saved page (url.intended) is kept
            $request->session()->regenerate();

            // staff/admin always go straight to their dashboard (ignore the saved page)
            if ($user->isStaff()) {
                // forget the saved page so it doesn't send them somewhere later
                $request->session()->forget('url.intended');

                return redirect()->route($user->dashboardRoute());
            }

            // normal users go back to the page they clicked before login (e.g. the locker);
            // if there is none (they opened /login directly), use their dashboard
            return redirect()->intended(route($user->dashboardRoute()));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // POST /logout: log out and go to the login page
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}