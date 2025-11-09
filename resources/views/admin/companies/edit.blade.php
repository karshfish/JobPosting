@extends('admin.layouts.app')

@section('page-actions')
  <a href="{{ route('admin.companies.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-base text-sm">Back</a>
@endsection

@section('content')
  <h1 class="text-xl font-semibold text-slate-800 dark:text-slate-100 mb-4">Edit Company</h1>
  <form method="POST" action="{{ route('admin.companies.update', $company) }}" class="space-y-4">
    @csrf @method('PUT')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Name</label>
        <input name="name" value="{{ old('name', $company->name) }}" class="block w-full rounded-md border-slate-300 focus:border-blue-400 focus:ring-blue-400" required>
        @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Website</label>
        <input name="website" value="{{ old('website', $company->website) }}" class="block w-full rounded-md border-slate-300 focus:border-blue-400 focus:ring-blue-400">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input name="email" value="{{ old('email', $company->email) }}" class="block w-full rounded-md border-slate-300 focus:border-blue-400 focus:ring-blue-400">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Location</label>
        <input name="location" value="{{ old('location', $company->location) }}" class="block w-full rounded-md border-slate-300 focus:border-blue-400 focus:ring-blue-400">
      </div>
      <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Logo Path (optional)</label>
        <input name="logo_path" value="{{ old('logo_path', $company->logo_path) }}" class="block w-full rounded-md border-slate-300 focus:border-blue-400 focus:ring-blue-400">
      </div>
      <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Description</label>
        <textarea name="description" rows="4" class="block w-full rounded-md border-slate-300 focus:border-blue-400 focus:ring-blue-400">{{ old('description', $company->description) }}</textarea>
      </div>
    </div>
    <div class="pt-2">
      <button class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-base">Update</button>
    </div>
  </form>
@endsection

