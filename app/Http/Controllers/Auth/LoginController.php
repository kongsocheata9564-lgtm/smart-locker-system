<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(): Response
    {
        return response()->noContent();
    }

    public function destroy(): Response
    {
        return response()->noContent();
    }
}
