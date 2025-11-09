<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(12);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->pluck('name');
        $userRoles = $user->getRoleNames();
        return view('admin.users.edit', compact('user','roles','userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $roles = $request->input('roles', []);
        $user->syncRoles($roles);
        return redirect()->route('admin.users.index')->with('status', 'User roles updated.');
    }
}

