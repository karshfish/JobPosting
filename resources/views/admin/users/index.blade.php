@extends('admin.layouts.app')

@section('content')
  <div class="mb-4 flex items-start justify-between gap-3">
    <div>
      <h1 class="text-xl font-semibold text-slate-800 dark:text-slate-100">Users</h1>
      <p class="text-sm text-slate-500 dark:text-slate-400">Manage user roles.</p>
    </div>
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-2">
      <label for="role" class="text-sm text-slate-600 dark:text-slate-400">Role</label>
      <select id="role" name="role" class="text-sm rounded-md border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100" onchange="this.form.submit()">
        @foreach(($roles ?? collect(['all','admin','employer','candidate'])) as $role)
          <option value="{{ $role }}" @selected(($selectedRole ?? 'all') === $role)>{{ ucfirst($role) }}</option>
        @endforeach
      </select>
    </form>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @forelse($users as $user)
      @php
        $role = $user->role ?? 'none';
        $roleClasses = match($role) {
          'admin' => 'border-red-300 text-red-700 bg-red-50 dark:border-red-600 dark:text-red-200 dark:bg-red-800/40',
          'employer' => 'border-amber-300 text-amber-700 bg-amber-50 dark:border-amber-600 dark:text-amber-200 dark:bg-amber-800/40',
          'candidate' => 'border-emerald-300 text-emerald-700 bg-emerald-50 dark:border-emerald-600 dark:text-emerald-200 dark:bg-emerald-800/40',
          default => 'border-slate-200 text-slate-700 bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:bg-slate-800/40',
        };
      @endphp
      <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-4 md:p-5 shadow-sm hover:shadow-md transition-base flex flex-col">
        <div class="flex items-center gap-3">
          <div class="min-w-0">
            <div class="font-medium text-slate-800 dark:text-white truncate">{{ $user->name }}</div>
            <div class="text-xs text-slate-500 dark:text-slate-300 truncate">{{ $user->email }}</div>
          </div>
        </div>

        <div class="mt-3 flex items-center gap-2 text-xs">
          <span class="inline-flex items-center px-2 py-0.5 rounded border {{ $roleClasses }}">
            {{ ucfirst($role) }}
          </span>
          <span class="text-slate-300 dark:text-slate-500">•</span>
          <span class="text-slate-500 dark:text-slate-300">Joined {{ optional($user->created_at)->format('M d, Y') }}</span>
        </div>

        <div class="mt-4 flex items-center justify-end gap-2">
          <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-700/40 transition-base text-sm">
            Edit
          </a>
          @if(auth()->id() !== $user->id && ($user->role !== 'admin') && !($user->is_admin ?? false))
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user? This action cannot be undone.');">
              @csrf
              @method('DELETE')
              <button class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md border border-red-300 text-red-700 hover:bg-red-50 dark:hover:bg-red-800/40 transition-base text-sm">
                Delete
              </button>
            </form>
          @endif
        </div>
      </div>
    @empty
      <div class="text-sm text-slate-500 dark:text-slate-400">No users found.</div>
    @endforelse
  </div>

  <div class="mt-4">{{ $users->links() }}</div>
@endsection
