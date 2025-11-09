<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(12);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = collect(['admin', 'employer', 'candidate']);
        $userRole = $user->role;
        return view('admin.users.edit', compact('user','roles','userRole'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', 'in:admin,employer,candidate'],
        ]);

        $user->role = $validated['role'];
        $user->save();

        return redirect()->route('admin.users.index')->with('status', 'User role updated.');
    }
}
