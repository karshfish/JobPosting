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

        // Admin can see and filter by all roles
        $roles = collect(['all', 'admin', 'employer', 'candidate']);
        $selectedRole = in_array($request->query('role'), $roles->all(), true)
            ? $request->query('role')
            : 'all';

        // Filter by activation status
        $statuses = collect(['active', 'inactive', 'all']);
        $selectedStatus = in_array($request->query('status'), $statuses->all(), true)
            ? $request->query('status')
            : 'active';

        $query = User::query()->orderByDesc('created_at');

        if ($selectedStatus === 'inactive') {
            $query->onlyTrashed();
        } elseif ($selectedStatus === 'all') {
            $query->withTrashed();
        }

        // Apply role filter if selected
        if ($selectedRole !== 'all') {
            $query->where('role', $selectedRole);
        }

        $users = $query->paginate(12)->withQueryString();

        return view('admin.users.index', compact('users', 'roles', 'selectedRole', 'selectedStatus'));
    }

    public function edit(User $user)
    {
        // Only admins can edit user roles (authorization enforced via middleware)
        $roles = collect(['employer', 'candidate']);
        $userRole = $user->role;
        return view('admin.users.edit', compact('user','roles','userRole'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', 'in:employer,candidate'],
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

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User deactivated.');
    }

    /**
     * Restore a soft deleted user.
     */
    public function restore(Request $request, int $userId)
    {
        $user = User::withTrashed()->findOrFail($userId);

        if (! $user->trashed()) {
            return redirect()->route('admin.users.index')->with('status', 'User is already active.');
        }

        if ($request->user()->id === $user->id) {
            return back()->withErrors(['restore' => 'You cannot restore your own account context.']);
        }

        $user->restore();

        return redirect()->route('admin.users.index', ['status' => 'inactive'])->with('status', 'User activated.');
    }
}
