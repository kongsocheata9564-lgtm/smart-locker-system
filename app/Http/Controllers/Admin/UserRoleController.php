<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserRoleController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->when($request->q, fn ($q, $term) => $q
                ->where('name', 'ilike', "%{$term}%")
                ->orWhere('email', 'ilike', "%{$term}%"))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(['user', 'staff', 'admin'])],
        ]);

        // Stop an admin from locking themselves out
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $user->role = $data['role'];
        $user->save();

        return back()->with('success', "{$user->name} is now {$user->role}.");
    }
}
