<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class ReleaseController extends Controller
{
    public function store(): Response
    {
        return response()->noContent();
    }
}
