@extends('admin.layouts.app')

@section('content')
  <h1 class="text-xl font-semibold text-slate-800 mb-4">Jobs</h1>

  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-200">
      <thead class="bg-slate-50">
        <tr class="text-left text-slate-600 text-xs uppercase tracking-wider">
          <th class="px-3 py-2">Title</th>
          <th class="px-3 py-2">Company</th>
          <th class="px-3 py-2">Status</th>
          <th class="px-3 py-2 text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        @forelse($jobs as $job)
          <tr class="hover:bg-slate-50">
            <td class="px-3 py-2 font-medium text-slate-800">{{ $job->title }}</td>
            <td class="px-3 py-2 text-slate-700">{{ $job->company->name ?? '-' }}</td>
            <td class="px-3 py-2">
              @php
                $status = $job->status ?? 'pending';
                $badge = [
                  'approved' => 'bg-green-100 text-green-800 border-green-200',
                  'rejected' => 'bg-red-100 text-red-800 border-red-200',
                  'pending'  => 'bg-amber-100 text-amber-800 border-amber-200',
                ][$status] ?? 'bg-slate-100 text-slate-800 border-slate-200';
              @endphp
              <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded border {{ $badge }}">{{ ucfirst($status) }}</span>
            </td>
            <td class="px-3 py-2">
              <div class="flex justify-end gap-2">
                @if(($job->status ?? 'pending') !== 'approved')
                  <form method="POST" action="{{ route('admin.jobs.approve',$job) }}" class="inline">
                    @csrf
                    <button class="inline-flex items-center gap-1 px-2 py-1 rounded border border-green-300 text-green-700 hover:bg-green-50 transition-base text-sm">Approve</button>
                  </form>
                @endif
                @if(($job->status ?? 'pending') !== 'rejected')
                  <form method="POST" action="{{ route('admin.jobs.reject',$job) }}" class="inline">
                    @csrf
                    <input type="hidden" name="reason" value="Not suitable.">
                    <button class="inline-flex items-center gap-1 px-2 py-1 rounded border border-red-300 text-red-700 hover:bg-red-50 transition-base text-sm">Reject</button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="px-3 py-10 text-center text-slate-500">No jobs to show.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $jobs->links() }}
  </div>
@endsection
