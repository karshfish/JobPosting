@extends('admin.layouts.app')

@section('content')
  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Welcome back</h1>
      <p class="text-slate-600 dark:text-slate-400">Here’s what’s happening today.</p>
    </div>
    <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-10 w-auto">
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 p-4">
      <div class="text-sm text-slate-500 dark:text-slate-400">Pending Jobs</div>
      <div class="mt-1 text-2xl font-semibold text-slate-900 dark:text-slate-100">{{ $stats['pending_jobs'] ?? 0 }}</div>
      <a href="{{ route('admin.jobs.pending') }}" class="mt-2 inline-block text-sm text-blue-700 dark:text-blue-300 hover:underline">Review</a>
    </div>
    <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 p-4">
      <div class="text-sm text-slate-500 dark:text-slate-400">Approved Jobs</div>
      <div class="mt-1 text-2xl font-semibold text-slate-900 dark:text-slate-100">{{ $stats['approved_jobs'] ?? 0 }}</div>
      <a href="{{ route('admin.jobs.index') }}" class="mt-2 inline-block text-sm text-blue-700 dark:text-blue-300 hover:underline">View</a>
    </div>
    <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 p-4">
      <div class="text-sm text-slate-500 dark:text-slate-400">Categories</div>
      <div class="mt-1 text-2xl font-semibold text-slate-900 dark:text-slate-100">{{ $stats['categories'] ?? 0 }}</div>
      <a href="{{ route('admin.categories.index') }}" class="mt-2 inline-block text-sm text-blue-700 dark:text-blue-300 hover:underline">Manage</a>
    </div>
  </div>

  <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 p-4">
    <div class="text-sm font-medium text-slate-900 dark:text-slate-100 mb-2">Quick Links</div>
    <div class="flex flex-wrap gap-2">
      <a href="{{ route('admin.jobs.pending') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50 text-sm">Moderate Jobs</a>
      <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50 text-sm">New Category</a>
    </div>
  </div>
@endsection
