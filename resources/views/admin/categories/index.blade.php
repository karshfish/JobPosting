@extends('admin.layouts.app')

@section('page-actions')
  <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-base text-sm">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path d="M12 4.5a.75.75 0 0 1 .75.75V11h5.75a.75.75 0 0 1 0 1.5H12.75v5.75a.75.75 0 0 1-1.5 0V12.5H5.5a.75.75 0 0 1 0-1.5h5.75V5.25A.75.75 0 0 1 12 4.5Z"/></svg>
    New Category
  </a>
@endsection

@section('content')
  <div class="mb-4 flex items-center justify-between">
    <div>
      <h1 class="text-xl font-semibold text-slate-800 dark:text-slate-100">Categories</h1>
      <p class="text-sm text-slate-500 dark:text-slate-400">Manage job categories used for classifying posts.</p>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @forelse($categories as $c)
      <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-4 md:p-5 shadow-sm hover:shadow-md transition-base">
        <div class="flex items-start justify-between gap-3">
          <div class="min-w-0">
            <div class="font-medium text-slate-800 dark:text-white truncate">{{ $c->name }}</div>
            <div class="mt-1 flex items-center gap-2 text-xs">
              <span class="inline-flex items-center px-2 py-0.5 rounded border border-slate-200 text-slate-700 bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:bg-slate-800/40">{{ $c->slug }}</span>
            </div>
          </div>
          <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('admin.categories.edit',$c) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-700/40 transition-base text-sm">Edit</a>
            <form method="POST" action="{{ route('admin.categories.destroy',$c) }}" onsubmit="return confirm('Delete this category?');">
              @csrf @method('DELETE')
              <button class="inline-flex items-center gap-1 px-3 py-1.5 rounded-md border border-red-300 text-red-700 hover:bg-red-50 dark:hover:bg-red-800/40 transition-base text-sm">Delete</button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="text-sm text-slate-500 dark:text-slate-400">No categories yet. Create your first one.</div>
    @endforelse
  </div>

  <div class="mt-4">
    {{ $categories->onEachSide(1)->links('pagination::simple-tailwind') }}
  </div>
@endsection
