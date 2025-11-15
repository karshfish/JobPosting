@extends('admin.layouts.app')

@section('page-actions')
  <a href="{{ route('admin.applications.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-base text-sm">
    Back
  </a>
@endsection

@section('content')
  @php
    $status = $application->status ?? 'pending';
    $statusConfig = [
      'pending' => [
        'label' => 'Pending',
        'badge' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200',
      ],
      'accepted' => [
        'label' => 'Accepted',
        'badge' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200',
      ],
      'rejected' => [
        'label' => 'Rejected',
        'badge' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-200',
      ],
    ];
    $statusMeta = $statusConfig[$status] ?? [
      'label' => ucfirst($status),
      'badge' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200',
    ];
  @endphp

  <div class="flex flex-col gap-4 mb-6">
    <div class="flex items-start justify-between gap-4">
      <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">
          {{ $application->job->title ?? 'Job removed' }}
        </h1>
        <div class="text-sm text-slate-500 dark:text-slate-400">
          {{ $application->user->name ?? 'Unknown candidate' }}
          @if($application->job && $application->job->location)
            · <span>{{ $application->job->location }}</span>
          @endif
        </div>
      </div>
      <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusMeta['badge'] }}">
        {{ $statusMeta['label'] }}
      </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-3">
        <div class="text-xs text-slate-500 dark:text-slate-400">Applied at</div>
        <div class="mt-1 text-sm font-medium text-slate-900 dark:text-slate-100">
          {{ optional($application->created_at)->toDayDateTimeString() ?? '-' }}
        </div>
      </div>
      <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-3">
        <div class="text-xs text-slate-500 dark:text-slate-400">Job status</div>
        <div class="mt-1 text-sm font-medium text-slate-900 dark:text-slate-100">
          {{ ucfirst($application->job->status ?? 'unknown') }}
        </div>
      </div>
      <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-3">
        <div class="text-xs text-slate-500 dark:text-slate-400">Candidate email</div>
        <div class="mt-1 text-sm font-medium text-slate-900 dark:text-slate-100">
          {{ $application->user->email ?? '-' }}
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div class="space-y-4">
        <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4">
          <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Job description</h2>
          <p class="text-sm text-slate-700 dark:text-slate-200 whitespace-pre-line">
            {{ $application->job->description ?? 'No description available.' }}
          </p>
        </section>

        @if($application->job && $application->job->responsibilities)
          <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4">
            <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Responsibilities</h2>
            <p class="text-sm text-slate-700 dark:text-slate-200 whitespace-pre-line">
              {{ $application->job->responsibilities }}
            </p>
          </section>
        @endif
      </div>

      <div class="space-y-4">
        <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4">
          <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Candidate details</h2>
          <dl class="space-y-1 text-sm text-slate-700 dark:text-slate-200">
            <div class="flex justify-between gap-2">
              <dt class="text-slate-500 dark:text-slate-400">Name</dt>
              <dd>{{ $application->user->name ?? 'Unknown' }}</dd>
            </div>
            <div class="flex justify-between gap-2">
              <dt class="text-slate-500 dark:text-slate-400">Email</dt>
              <dd>{{ $application->user->email ?? '-' }}</dd>
            </div>
          </dl>
        </section>

        @if($application->resume)
          <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4">
            <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Resume</h2>
            <a href="{{ asset('storage/' . $application->resume) }}"
               target="_blank"
               class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-300 dark:hover:text-indigo-200">
              View uploaded resume
            </a>
          </section>
        @endif
      </div>
    </div>
  </div>
@endsection

