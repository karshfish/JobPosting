@extends('admin.layouts.app')

@section('page-actions')
  <a href="{{ route('admin.companies.create') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-base text-sm">New Company</a>
@endsection

@section('content')
  <div class="mb-4">
    <h1 class="text-xl font-semibold text-slate-800 dark:text-slate-100">Companies</h1>
    <p class="text-sm text-slate-500 dark:text-slate-400">Manage employer companies.</p>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
      <thead class="bg-slate-50 dark:bg-slate-800/40">
        <tr class="text-left text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider">
          <th class="px-3 py-2">Name</th>
          <th class="px-3 py-2">Website</th>
          <th class="px-3 py-2">Email</th>
          <th class="px-3 py-2">Location</th>
          <th class="px-3 py-2 text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
        @forelse($companies as $company)
          <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
            <td class="px-3 py-2 font-medium text-slate-800 dark:text-slate-100">{{ $company->name }}</td>
            <td class="px-3 py-2 text-slate-600 dark:text-slate-300"><a class="text-blue-700 dark:text-blue-300 hover:underline" href="{{ $company->website }}" target="_blank" rel="noopener">{{ $company->website ?? '—' }}</a></td>
            <td class="px-3 py-2 text-slate-600 dark:text-slate-300">{{ $company->email ?? '—' }}</td>
            <td class="px-3 py-2 text-slate-600 dark:text-slate-300">{{ $company->location ?? '—' }}</td>
            <td class="px-3 py-2">
              <div class="flex justify-end gap-2">
                <a href="{{ route('admin.companies.edit', $company) }}" class="inline-flex items-center gap-1 px-2 py-1 rounded border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-base text-sm">Edit</a>
                <form method="POST" action="{{ route('admin.companies.destroy', $company) }}" onsubmit="return confirm('Delete this company?');">
                  @csrf @method('DELETE')
                  <button class="inline-flex items-center gap-1 px-2 py-1 rounded border border-red-300 text-red-700 hover:bg-red-50 dark:hover:bg-red-900/30 transition-base text-sm">Delete</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-3 py-10 text-center text-slate-500">No companies yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">{{ $companies->links() }}</div>
@endsection

