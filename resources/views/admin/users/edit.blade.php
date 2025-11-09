@extends('admin.layouts.app')

@section('page-actions')
  <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-base text-sm">Back</a>
@endsection

@section('content')
  <h1 class="text-xl font-semibold text-slate-800 dark:text-slate-100 mb-4">Edit Role: {{ $user->name }}</h1>
  <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
    @csrf @method('PUT')
    <div class="space-y-2">
      <label class="block text-sm text-slate-600 dark:text-slate-300">Role</label>
      <select name="role" class="rounded border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100">
        @foreach($roles as $role)
          <option value="{{ $role }}" @selected($userRole === $role)>{{ ucfirst($role) }}</option>
        @endforeach
      </select>
    </div>
    <div class="pt-2">
      <button class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-base">Save</button>
    </div>
  </form>
@endsection
