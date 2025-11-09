@extends('admin.layouts.app')

@section('page-actions')
  <a href="{{ route('admin.jobs.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-slate-300 text-slate-700 hover:bg-slate-100 transition-base text-sm">Back</a>
@endsection

@section('content')
  <div class="flex items-start justify-between mb-4">
    <div>
      <h1 class="text-xl font-semibold text-slate-800">{{ $job->title }}</h1>
      <div class="text-sm text-slate-500">{{ $job->company->name ?? '—' }} • {{ ucfirst($job->work_type ?? 'on-site') }}</div>
    </div>
    <div class="flex gap-2">
      @if(($job->status ?? 'pending') !== 'approved')
        <form method="POST" action="{{ route('admin.jobs.approve',$job) }}">
          @csrf
          <button class="inline-flex items-center gap-1 px-3 py-1.5 rounded border border-green-300 text-green-700 hover:bg-green-50 transition-base text-sm">Approve</button>
        </form>
      @endif
      @if(($job->status ?? 'pending') !== 'rejected')
        <form method="POST" action="{{ route('admin.jobs.reject',$job) }}">
          @csrf
          <input type="hidden" name="reason" value="Not suitable.">
          <button class="inline-flex items-center gap-1 px-3 py-1.5 rounded border border-red-300 text-red-700 hover:bg-red-50 transition-base text-sm">Reject</button>
        </form>
      @endif
    </div>
  </div>

  <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <dt class="text-sm text-slate-500">Status</dt>
      <dd class="text-slate-800">{{ ucfirst($job->status ?? 'pending') }}</dd>
    </div>
    <div>
      <dt class="text-sm text-slate-500">Location</dt>
      <dd class="text-slate-800">{{ $job->location ?? '—' }}</dd>
    </div>
    <div class="md:col-span-2">
      <dt class="text-sm text-slate-500">Description</dt>
      <dd class="text-slate-800 whitespace-pre-line">{{ $job->description ?? '—' }}</dd>
    </div>
  </dl>
@endsection

