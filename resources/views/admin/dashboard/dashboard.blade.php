@extends('admin.layouts.app')

@section('content')
  @php
    $jobStats = $stats['jobs'] ?? [];
    $appStats = $stats['applications'] ?? [];
    $entityStats = $stats['entities'] ?? [];
  @endphp

  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-slate-100">Admin overview</h1>
      <p class="text-sm md:text-base text-slate-600 dark:text-slate-400">
        Snapshot of jobs, applications, and platform activity.
      </p>
    </div>
    <div class="flex items-center gap-4">
      <div class="hidden md:flex flex-col items-end text-xs text-slate-500 dark:text-slate-400">
        <span>Today</span>
        <span class="font-medium text-slate-700 dark:text-slate-200">{{ now()->format('M d, Y') }}</span>
      </div>
      <img src="{{ asset('assets/logo.jpg') }}" alt="HireHup logo" class="h-10 w-auto rounded-md shadow-sm">
    </div>
  </div>

  {{-- Top metrics cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    {{-- Jobs card --}}
    <a href="{{ route('admin.jobs.index') }}"
       class="group block rounded-xl border border-slate-200 dark:border-slate-800 bg-gradient-to-br from-blue-50 to-blue-100/60 dark:from-slate-900 dark:to-blue-900/40 p-4 shadow-sm transition-base hover:-translate-y-0.5 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-xs font-medium uppercase tracking-wide text-blue-700 dark:text-blue-300">Total jobs</div>
          <div class="mt-1 text-2xl font-semibold text-slate-900 dark:text-slate-50">
            {{ $jobStats['total'] ?? 0 }}
          </div>
        </div>
        <div class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/70 dark:bg-slate-900/60 text-blue-600 dark:text-blue-300 shadow-sm">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5h16.5m-14.25 3v7.125c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V10.5M8.25 7.5V6.375c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V7.5" />
          </svg>
        </div>
      </div>
      <div class="mt-2 text-xs text-slate-600 dark:text-slate-400">
        Draft: <span class="font-semibold">{{ $jobStats['draft'] ?? 0 }}</span> •
        Published: <span class="font-semibold">{{ $jobStats['published'] ?? 0 }}</span> •
        Closed: <span class="font-semibold">{{ $jobStats['closed'] ?? 0 }}</span>
      </div>
    </a>

    {{-- Applications card --}}
    <a href="{{ route('admin.applications.index') }}"
       class="group block rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4 shadow-sm transition-base hover:-translate-y-0.5 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-emerald-500">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-xs font-medium uppercase tracking-wide text-emerald-700 dark:text-emerald-300">Applications</div>
          <div class="mt-1 text-2xl font-semibold text-slate-900 dark:text-slate-50">
            {{ $appStats['total'] ?? 0 }}
          </div>
        </div>
        <div class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-emerald-50 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-200 shadow-sm">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <!-- Inbox-style icon -->
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 8.25V7.5A2.25 2.25 0 0 1 6 5.25h12A2.25 2.25 0 0 1 20.25 7.5v.75m-16.5 0h16.5m-16.5 0 1.5 8.25A2.25 2.25 0 0 0 7.5 18.75h9a2.25 2.25 0 0 0 2.25-1.95l1.5-8.25" />
          </svg>
        </div>
      </div>
      <div class="mt-2 text-xs text-slate-600 dark:text-slate-400">
        Pending: <span class="font-semibold">{{ $appStats['pending'] ?? 0 }}</span> •
        Accepted: <span class="font-semibold">{{ $appStats['accepted'] ?? 0 }}</span> •
        Rejected: <span class="font-semibold">{{ $appStats['rejected'] ?? 0 }}</span>
      </div>
    </a>

    {{-- Users card --}}
    <a href="{{ route('admin.users.index') }}"
       class="group block rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4 shadow-sm transition-base hover:-translate-y-0.5 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-violet-500">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-xs font-medium uppercase tracking-wide text-violet-700 dark:text-violet-300">Users</div>
          <div class="mt-1 text-2xl font-semibold text-slate-900 dark:text-slate-50">
            {{ $entityStats['users'] ?? 0 }}
          </div>
        </div>
        <div class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-violet-50 dark:bg-violet-900/40 text-violet-700 dark:text-violet-200 shadow-sm">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118A7.5 7.5 0 0 1 12 15.75a7.5 7.5 0 0 1 7.5 7.5v.75H4.5v-.632z" />
          </svg>
        </div>
      </div>
      <div class="mt-2 text-xs text-slate-600 dark:text-slate-400">
        Total registered accounts on the platform.
      </div>
    </a>

    {{-- Categories card --}}
    <a href="{{ route('admin.categories.index') }}"
       class="group block rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4 shadow-sm transition-base hover:-translate-y-0.5 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-amber-500">
      <div class="flex items-center justify-between">
        <div>
          <div class="text-xs font-medium uppercase tracking-wide text-amber-700 dark:text-amber-300">Categories</div>
          <div class="mt-1 text-2xl font-semibold text-slate-900 dark:text-slate-50">
            {{ $entityStats['categories'] ?? 0 }}
          </div>
        </div>
        <div class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-amber-50 dark:bg-amber-900/40 text-amber-700 dark:text-amber-200 shadow-sm">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <!-- Grid-style icon -->
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 4.5h6v6h-6v-6zM13.5 4.5h6v6h-6v-6zM4.5 13.5h6v6h-6v-6zM13.5 13.5h6v6h-6v-6z" />
          </svg>
        </div>
      </div>
      <div class="mt-2 text-xs text-slate-600 dark:text-slate-400">
        Active job categories for organizing postings.
      </div>
    </a>
  </div>

  {{-- Charts + quick links --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4">
      <div class="flex items-center justify-between mb-3">
        <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Jobs by status</h2>
        <span class="text-xs text-slate-500 dark:text-slate-400">Overview of job lifecycle</span>
      </div>
      <div class="relative h-60">
        <canvas id="jobsStatusChart"></canvas>
        <div class="chart-empty absolute inset-0 flex items-center justify-center text-sm text-slate-500 dark:text-slate-400 hidden">
          No job data yet.
        </div>
      </div>
    </div>

    <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4 flex flex-col">
      <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Quick links</h2>
      <p class="text-xs text-slate-600 dark:text-slate-400 mb-3">
        Jump directly into common moderation and management actions.
      </p>
      <div class="flex flex-col gap-2 mt-auto">
        <a href="{{ route('admin.jobs.pending') }}" class="inline-flex items-center justify-between gap-2 px-3 py-2 rounded-md border border-slate-200 dark:border-slate-700 text-sm text-slate-800 dark:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-base">
          <span class="flex items-center gap-2">
            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-50 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300">
              <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>
            </span>
            Review draft jobs
          </span>
          <span class="text-xs text-slate-500 dark:text-slate-400">&rarr;</span>
        </a>
        <a href="{{ route('admin.jobs.index') }}" class="inline-flex items-center justify-between gap-2 px-3 py-2 rounded-md border border-slate-200 dark:border-slate-700 text-sm text-slate-800 dark:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-base">
          <span class="flex items-center gap-2">
            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-50 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-200">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75 9 17.25l10.5-10.5" />
              </svg>
            </span>
            All job postings
          </span>
          <span class="text-xs text-slate-500 dark:text-slate-400">&rarr;</span>
        </a>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center justify-between gap-2 px-3 py-2 rounded-md border border-slate-200 dark:border-slate-700 text-sm text-slate-800 dark:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-base">
          <span class="flex items-center gap-2">
            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-amber-50 dark:bg-amber-900/40 text-amber-700 dark:text-amber-200">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
              </svg>
            </span>
            New category
          </span>
          <span class="text-xs text-slate-500 dark:text-slate-400">&rarr;</span>
        </a>
      </div>
    </div>
  </div>

  {{-- Applications chart + recent activity --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4">
      <div class="flex items-center justify-between mb-3">
        <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Applications by status</h2>
        <span class="text-xs text-slate-500 dark:text-slate-400">Pipeline health</span>
      </div>
      <div class="relative h-60">
        <canvas id="applicationsStatusChart"></canvas>
        <div class="chart-empty absolute inset-0 flex items-center justify-center text-sm text-slate-500 dark:text-slate-400 hidden">
          No applications yet.
        </div>
      </div>
    </div>

    <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-4">
      <div class="flex items-center justify-between mb-3">
        <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Recent applications</h2>
        <span class="text-xs text-slate-500 dark:text-slate-400">Last 5 submissions</span>
      </div>
      @if(($recentApplications ?? collect())->isEmpty())
        <p class="text-sm text-slate-500 dark:text-slate-400">No applications have been submitted yet.</p>
      @else
        <div class="overflow-x-auto -mx-2 sm:mx-0">
          <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800 text-sm">
            <thead>
              <tr class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">
                <th class="px-2 sm:px-3 py-2 text-left">Candidate</th>
                <th class="px-2 sm:px-3 py-2 text-left">Job</th>
                <th class="px-2 sm:px-3 py-2 text-left">Status</th>
                <th class="px-2 sm:px-3 py-2 text-left">Applied</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
              @foreach($recentApplications as $application)
                <tr>
                  <td class="px-2 sm:px-3 py-2 whitespace-nowrap text-slate-900 dark:text-slate-100">
                    {{ $application->user?->name ?? 'Unknown' }}
                  </td>
                  <td class="px-2 sm:px-3 py-2 whitespace-nowrap text-slate-700 dark:text-slate-200">
                    {{ $application->job?->title ?? 'Job removed' }}
                  </td>
                  <td class="px-2 sm:px-3 py-2 whitespace-nowrap">
                    @php
                      $status = $application->status;
                      $statusColors = [
                        'pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200',
                        'accepted' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200',
                        'rejected' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-200',
                      ];
                    @endphp
                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $statusColors[$status] ?? 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200' }}">
                      {{ ucfirst($status) }}
                    </span>
                  </td>
                  <td class="px-2 sm:px-3 py-2 whitespace-nowrap text-slate-500 dark:text-slate-400">
                    {{ optional($application->created_at)->diffForHumans() ?? '-' }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>

  {{-- Charts script --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    (function () {
      const jobsData = @json($charts['jobs_by_status'] ?? ['labels' => [], 'data' => []]);
      const appsData = @json($charts['applications_by_status'] ?? ['labels' => [], 'data' => []]);

      const colorsJobs = ['#0ea5e9', '#22c55e', '#64748b'];
      const colorsApps = ['#f97316', '#22c55e', '#ef4444'];

      const initDoughnut = (canvasId, data, colors) => {
        const el = document.getElementById(canvasId);
        if (!el) return;

        const emptyState = el.parentElement.querySelector('.chart-empty');
        if (!data || !Array.isArray(data.data) || data.data.length === 0) {
          el.classList.add('hidden');
          if (emptyState) emptyState.classList.remove('hidden');
          return;
        }

        const chartColors = data.data.map((_, idx) => colors[idx % colors.length]);

        new Chart(el.getContext('2d'), {
          type: 'doughnut',
          data: {
            labels: data.labels || [],
            datasets: [{
              data: data.data,
              backgroundColor: chartColors,
              borderWidth: 1,
            }]
          },
          options: {
            plugins: {
              legend: {
                position: 'bottom',
                labels: {
                  boxWidth: 12,
                  boxHeight: 12,
                  usePointStyle: true,
                }
              }
            },
            responsive: true,
            maintainAspectRatio: false,
          }
        });
      };

      initDoughnut('jobsStatusChart', jobsData, colorsJobs);
      initDoughnut('applicationsStatusChart', appsData, colorsApps);
    })();
  </script>
@endsection
