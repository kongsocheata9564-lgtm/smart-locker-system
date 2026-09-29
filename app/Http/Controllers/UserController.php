<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class UserController extends Controller
{
    // GET /profiles (any logged-in user)
    public function profile(Request $request): View
    {
        return view('profile', ['user' => $request->user()]);
    }

    // GET /staff/profile
    public function staff(Request $request): View
    {
        return view('staff.profile.index', ['user' => $request->user()]);
    }

    // GET /user/profile
    public function index(Request $request): View
    {
        return view('user.profile.index', ['user' => $request->user()]);
    }

    // GET /staff/list and /user/list
    public function userlist(Request $request): View|RedirectResponse
{
    /** @var \App\Models\User $authUser */
    $authUser = $request->user();

    // Admins manage roles on their own page
    if ($authUser->role === 'admin') {
        return redirect()->route('admin.users.index');
    }

    $users = User::latest()->paginate(10);

    $view = $authUser->isStaff()
        ? 'staff.list.index'
        : 'user.list.index';

    return view($view, compact('users'));
}
}
