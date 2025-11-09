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
      <h1 class="text-xl font-semibold text-slate-800">Categories</h1>
      <p class="text-sm text-slate-500">Manage job categories used for classifying posts.</p>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-200">
      <thead class="bg-slate-50">
        <tr class="text-left text-slate-600 text-xs uppercase tracking-wider">
          <th class="px-3 py-2">Name</th>
          <th class="px-3 py-2">Slug</th>
          <th class="px-3 py-2 text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        @forelse($categories as $c)
          <tr class="hover:bg-slate-50">
            <td class="px-3 py-2 font-medium text-slate-800">{{ $c->name }}</td>
            <td class="px-3 py-2 text-slate-600">{{ $c->slug }}</td>
            <td class="px-3 py-2">
              <div class="flex justify-end gap-2">
                <a href="{{ route('admin.categories.edit',$c) }}" class="inline-flex items-center gap-1 px-2 py-1 rounded border border-slate-300 text-slate-700 hover:bg-slate-100 transition-base text-sm">Edit</a>
                <form method="POST" action="{{ route('admin.categories.destroy',$c) }}" onsubmit="return confirm('Delete this category?');">
                  @csrf @method('DELETE')
                  <button class="inline-flex items-center gap-1 px-2 py-1 rounded border border-red-300 text-red-700 hover:bg-red-50 transition-base text-sm">Delete</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="3" class="px-3 py-10 text-center text-slate-500">
              No categories yet. Create your first one.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $categories->links() }}
  </div>
@endsection
