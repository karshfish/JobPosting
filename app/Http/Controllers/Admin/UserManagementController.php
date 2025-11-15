<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $loggedIn = $request->user();

        // Super admin can see and filter by all roles; other admins cannot see super_admin
        $roles = $loggedIn && $loggedIn->role === 'super_admin'
            ? collect(['all', 'super_admin', 'admin', 'employer', 'candidate'])
            : collect(['all', 'admin', 'employer', 'candidate']);
        $selectedRole = in_array($request->query('role'), $roles->all(), true)
            ? $request->query('role')
            : 'all';

        $query = User::query()->orderByDesc('created_at');

        // Hide super admin user from non–super-admins
        if (! $loggedIn || $loggedIn->role !== 'super_admin') {
            $query->where('role', '!=', 'super_admin');
        }
        if ($selectedRole !== 'all') {
            $query->where('role', $selectedRole);
        }

        $users = $query->paginate(12)->withQueryString();

        return view('admin.users.index', compact('users', 'roles', 'selectedRole'));
    }

    public function edit(User $user)
    {
        // Only super admins can edit user roles
        if (request()->user()->role !== 'super_admin') {
            abort(403);
        }

        $superAdminEmail = 'superAdmin@gmail.com';
        $roles = $user->email === $superAdminEmail
            ? collect(['super_admin'])
            : collect(['admin', 'employer', 'candidate']);
        $userRole = $user->role;
        return view('admin.users.edit', compact('user','roles','userRole'));
    }

    public function update(Request $request, User $user)
    {
        // Only super admins can update user roles
        if ($request->user()->role !== 'super_admin') {
            abort(403);
        }

        $superAdminEmail = 'superAdmin@gmail.com';
        if ($user->email === $superAdminEmail) {
            return back()->with('error', 'You cannot change the primary super admin role.');
        }

        $validated = $request->validate([
            'role' => ['required', 'in:admin,employer,candidate'],
        ]);

        $user->role = $validated['role'];
        $user->save();

        return redirect()->route('admin.users.index')->with('status', 'User role updated.');
    }

    public function destroy(Request $request, User $user)
    {
        // Only super admins can delete users
        if ($request->user()->role !== 'super_admin') {
            abort(403);
        }

        if ($request->user()->id === $user->id) {
            return back()->withErrors(['delete' => 'You cannot delete your own account.']);
        }

        if (($user->role ?? null) === 'super_admin') {
            return back()->withErrors(['delete' => 'You cannot delete a super admin user.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User deleted.');
    }
}
