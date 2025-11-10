@extends('admin.layouts.app')

@section('page-actions')
  <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-base text-sm">Back</a>
@endsection

@section('content')
  <h1 class="text-xl font-semibold text-slate-800 dark:text-slate-100 mb-4">Create Category</h1>
  <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Name</label>
      <input class="block w-full rounded-md border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 focus:border-blue-400 focus:ring-blue-400" name="name" value="{{ old('name') }}" required>
      @error('name')
        <p class="mt-1 text-sm text-red-600 dark:text-red-300">{{ $message }}</p>
      @enderror
    </div>
    <div class="pt-2">
      <button class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-base">Save</button>
    </div>
  </form>
@endsection
