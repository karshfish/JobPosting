@extends('admin.layouts.app')

@section('page-actions')
  <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-base text-sm">Back</a>
@endsection

@section('content')
  <h1 class="text-xl font-semibold text-slate-800 dark:text-slate-100 mb-4">Edit Roles: {{ $user->name }}</h1>
  <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
    @csrf @method('PUT')
    <div class="space-y-2">
      @foreach($roles as $role)
        <label class="flex items-center gap-3">
          <input type="checkbox" name="roles[]" value="{{ $role }}" @checked($userRoles->contains($role)) class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
          <span class="text-slate-700 dark:text-slate-200">{{ ucfirst($role) }}</span>
        </label>
      @endforeach
    </div>
    <div class="pt-2">
      <button class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-base">Save</button>
    </div>
  </form>
@endsection

