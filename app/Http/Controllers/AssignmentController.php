<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AssignmentController extends Controller
{
    public function index(): View
    {
        return view('user.assignments.index');
    }
}
