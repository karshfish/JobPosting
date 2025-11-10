<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $roles = collect(['all', 'admin', 'employer', 'candidate']);
        $selectedRole = in_array($request->query('role'), $roles->all(), true)
            ? $request->query('role')
            : 'all';

        $query = User::query()->orderBy('name');
        if ($selectedRole !== 'all') {
            $query->where('role', $selectedRole);
        }

        $users = $query->paginate(12)->withQueryString();

        return view('admin.users.index', compact('users', 'roles', 'selectedRole'));
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

    public function destroy(Request $request, User $user)
    {
        if ($request->user()->id === $user->id) {
            return back()->withErrors(['delete' => 'You cannot delete your own account.']);
        }

        if (($user->role ?? null) === 'admin' || (bool) ($user->is_admin ?? false)) {
            return back()->withErrors(['delete' => 'You cannot delete an admin user.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User deleted.');
    }
}
