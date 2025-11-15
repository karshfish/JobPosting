@extends('admin.layouts.app')

@section('page-actions')
  <a href="{{ route('admin.jobs.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-base text-sm">
    Back
  </a>
@endsection

@section('content')
  @php
    $status = $job->status ?? 'draft';

    $statusConfig = [
      'draft' => [
        'label' => 'Draft',
        'badge' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200',
      ],
      'published' => [
        'label' => 'Published',
        'badge' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200',
      ],
      'closed' => [
        'label' => 'Closed',
        'badge' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-200',
      ],
    ];

    $statusMeta = $statusConfig[$status] ?? [
      'label' => ucfirst($status),
      'badge' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200',
    ];

    $salaryMin = $job->salary_min;
    $salaryMax = $job->salary_max;
  @endphp

  <div class="flex flex-col gap-4 mb-6">
    <div class="flex items-start justify-between gap-4">
      <div>
        <div class="flex items-center gap-3 mb-1">
          <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">
            {{ $job->title }}
          </h1>
          <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusMeta['badge'] }}">
            {{ $statusMeta['label'] }}
          </span>
        </div>
        <div class="text-sm text-slate-500 dark:text-slate-400">
          {{ $job->user->name ?? 'Unknown company' }}
          @if($job->category)
            · <span>{{ $job->category->name }}</span>
          @endif
          @if($job->location)
            · <span>{{ $job->location }}</span>
          @endif
        </div>
      </div>

      <div class="flex flex-wrap gap-2 justify-end">
        @if($status === 'draft')
          <form method="POST" action="{{ route('admin.jobs.approve', $job) }}">
            @csrf
            <button class="inline-flex items-center gap-1 px-3 py-1.5 rounded border border-emerald-300 text-emerald-700 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-base text-sm">
              Approve
            </button>
          </form>

          <form method="POST" action="{{ route('admin.jobs.reject', $job) }}">
            @csrf
            <input type="hidden" name="reason" value="Not suitable.">
            <button class="inline-flex items-center gap-1 px-3 py-1.5 rounded border border-rose-300 text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-900/30 transition-base text-sm">
              Reject
            </button>
          </form>
        @elseif($status === 'published')
          <form method="POST" action="{{ route('admin.jobs.reject', $job) }}">
            @csrf
            <input type="hidden" name="reason" value="Not suitable.">
            <button class="inline-flex items-center gap-1 px-3 py-1.5 rounded border border-rose-300 text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-900/30 transition-base text-sm">
              Close job
            </button>
          </form>
        @endif
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-3">
        <div class="text-xs text-slate-500 dark:text-slate-400">Work type</div>
        <div class="mt-1 text-sm font-medium text-slate-900 dark:text-slate-100">
          {{ ucfirst($job->work_type ?? 'on-site') }}
        </div>
      </div>

      <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-3">
        <div class="text-xs text-slate-500 dark:text-slate-400">Applications</div>
        <div class="mt-1 text-sm font-medium text-slate-900 dark:text-slate-100">
          {{ $job->applications_count ?? 0 }}
        </div>
      </div>

      <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-3">
        <div class="text-xs text-slate-500 dark:text-slate-400">Salary range</div>
        <div class="mt-1 text-sm font-medium text-slate-900 dark:text-slate-100">
          @if($salaryMin || $salaryMax)
            @if($salaryMin)
              {{ number_format($salaryMin, 0) }}
            @endif
            @if($salaryMin && $salaryMax)
              –
            @endif
            @if($salaryMax)
              {{ number_format($salaryMax, 0) }}
            @endif
          @else
            Not specified
          @endif
        </div>
      </div>

      <div class="rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-3">
        <div class="text-xs text-slate-500 dark:text-slate-400">Deadline</div>
        <div class="mt-1 text-sm font-medium text-slate-900 dark:text-slate-100">
          @if($job->application_deadline)
            {{ $job->application_deadline->toFormattedDateString() }}
          @else
            No deadline
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
      <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4">
        <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Description</h2>
        <p class="text-sm text-slate-700 dark:text-slate-200 whitespace-pre-line">
          {{ $job->description ?? 'No description provided.' }}
        </p>
      </section>

      @if($job->responsibilities)
        <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4">
          <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Responsibilities</h2>
          <p class="text-sm text-slate-700 dark:text-slate-200 whitespace-pre-line">
            {{ $job->responsibilities }}
          </p>
        </section>
      @endif

      @php
        $skills = $job->skills ?? [];
        $qualifications = $job->qualifications ?? [];
        $technologies = $job->technologies ?? [];
        $benefits = $job->benefits ?? [];
      @endphp

      @if(!empty($skills))
        <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4">
          <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Skills</h2>
          <div class="flex flex-wrap gap-1.5">
            @foreach($skills as $skill)
              <span class="inline-flex items-center rounded-full bg-slate-100 dark:bg-slate-800 text-xs text-slate-700 dark:text-slate-200 px-2 py-0.5">
                {{ $skill }}
              </span>
            @endforeach
          </div>
        </section>
      @endif

      @if(!empty($technologies))
        <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4">
          <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Technologies</h2>
          <div class="flex flex-wrap gap-1.5">
            @foreach($technologies as $tech)
              <span class="inline-flex items-center rounded-full bg-slate-100 dark:bg-slate-800 text-xs text-slate-700 dark:text-slate-200 px-2 py-0.5">
                {{ $tech }}
              </span>
            @endforeach
          </div>
        </section>
      @endif
    </div>

    <div class="space-y-4">
      @if(!empty($qualifications))
        <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4">
          <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Qualifications</h2>
          <ul class="list-disc list-inside text-sm text-slate-700 dark:text-slate-200 space-y-1">
            @foreach($qualifications as $qualification)
              <li>{{ $qualification }}</li>
            @endforeach
          </ul>
        </section>
      @endif

      @if(!empty($benefits))
        <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4">
          <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Benefits</h2>
          <ul class="list-disc list-inside text-sm text-slate-700 dark:text-slate-200 space-y-1">
            @foreach($benefits as $benefit)
              <li>{{ $benefit }}</li>
            @endforeach
          </ul>
        </section>
      @endif

      <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4">
        <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Meta</h2>
        <dl class="space-y-1 text-sm text-slate-700 dark:text-slate-200">
          <div class="flex justify-between gap-2">
            <dt class="text-slate-500 dark:text-slate-400">Status</dt>
            <dd>{{ $statusMeta['label'] }}</dd>
          </div>
          <div class="flex justify-between gap-2">
            <dt class="text-slate-500 dark:text-slate-400">Created</dt>
            <dd>{{ optional($job->created_at)->toDayDateTimeString() ?? '—' }}</dd>
          </div>
          <div class="flex justify-between gap-2">
            <dt class="text-slate-500 dark:text-slate-400">Last updated</dt>
            <dd>{{ optional($job->updated_at)->toDayDateTimeString() ?? '—' }}</dd>
          </div>
        </dl>
      </section>
    </div>
  </div>
@endsection

