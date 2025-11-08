@extends('admin.layouts.app')

@section('content')
  <div class="mb-4">
    <h1 class="text-xl font-semibold text-slate-800 dark:text-slate-100">Users</h1>
    <p class="text-sm text-slate-500 dark:text-slate-400">Manage user roles.</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($users as $user)
      <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 p-4 flex items-start justify-between">
        <div>
          <div class="font-medium text-slate-800 dark:text-slate-100">{{ $user->name }}</div>
          <div class="text-sm text-slate-500">{{ $user->email }}</div>
          <div class="mt-2 flex flex-wrap gap-1">
            @forelse($user->getRoleNames() as $role)
              <span class="inline-flex items-center px-2 py-0.5 text-[11px] font-medium rounded border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200">{{ $role }}</span>
            @empty
              <span class="text-xs text-slate-500">No roles</span>
            @endforelse
          </div>
        </div>
        <div>
          <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-1 px-2 py-1 rounded border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-base text-sm">Edit</a>
        </div>
      </div>
    @endforeach
  </div>

  <div class="mt-4">{{ $users->links() }}</div>
@endsection

