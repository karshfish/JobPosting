@extends('admin.layouts.app')

@section('content')
  @php
    $statusCounts = $statusCounts ?? [];
    $pendingCount = $statusCounts['pending'] ?? 0;
    $acceptedCount = $statusCounts['accepted'] ?? 0;
    $rejectedCount = $statusCounts['rejected'] ?? 0;
  @endphp

  <div class="flex items-center justify-between mb-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Applications</h1>
      <p class="text-sm text-slate-600 dark:text-slate-400">
        Overview of all applications across jobs.
      </p>
    </div>
    <div class="hidden md:flex gap-3 text-xs">
      <div class="rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/60 px-3 py-2">
        <div class="text-slate-500 dark:text-slate-400">Pending</div>
        <div class="mt-0.5 font-semibold text-slate-900 dark:text-slate-100">{{ $pendingCount }}</div>
      </div>
      <div class="rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/60 px-3 py-2">
        <div class="text-slate-500 dark:text-slate-400">Accepted</div>
        <div class="mt-0.5 font-semibold text-slate-900 dark:text-slate-100">{{ $acceptedCount }}</div>
      </div>
      <div class="rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/60 px-3 py-2">
        <div class="text-slate-500 dark:text-slate-400">Rejected</div>
        <div class="mt-0.5 font-semibold text-slate-900 dark:text-slate-100">{{ $rejectedCount }}</div>
      </div>
    </div>
  </div>

  <div class="overflow-x-auto rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60">
    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
      <thead class="bg-slate-50 dark:bg-slate-900/80">
        <tr class="text-left text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider">
          <th class="px-3 py-2">Job</th>
          <th class="px-3 py-2">Candidate</th>
          <th class="px-3 py-2 hidden sm:table-cell">Status</th>
          <th class="px-3 py-2 hidden md:table-cell">Applied</th>
          <th class="px-3 py-2 text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
        @forelse($applications as $application)
          @php
            $status = $application->status ?? 'pending';
            $statusConfig = [
              'pending' => [
                'label' => 'Pending',
                'class' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200',
              ],
              'accepted' => [
                'label' => 'Accepted',
                'class' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200',
              ],
              'rejected' => [
                'label' => 'Rejected',
                'class' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-200',
              ],
            ];
            $statusMeta = $statusConfig[$status] ?? [
              'label' => ucfirst($status),
              'class' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200',
            ];
          @endphp
          <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/40">
            <td class="px-3 py-2 text-sm align-middle font-medium text-slate-900 dark:text-slate-100">
              {{ $application->job->title ?? 'Job removed' }}
            </td>
            <td class="px-3 py-2 text-sm text-slate-700 dark:text-slate-200 align-middle">
              {{ $application->user->name ?? 'Unknown' }}
            </td>
            <td class="px-3 py-2 align-middle hidden sm:table-cell">
              <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $statusMeta['class'] }}">
                {{ $statusMeta['label'] }}
              </span>
            </td>
            <td class="px-3 py-2 text-xs text-slate-500 dark:text-slate-400 align-middle hidden md:table-cell">
              {{ optional($application->created_at)->diffForHumans() ?? '-' }}
            </td>
            <td class="px-3 py-2 align-middle">
              <div class="flex justify-end gap-2">
                <a
                  href="{{ route('admin.applications.show', $application) }}"
                  class="inline-flex items-center gap-1 px-2 py-1 rounded border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-base"
                >
                  View
                </a>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-3 py-10 text-center text-sm text-slate-500 dark:text-slate-400">
              No applications to show.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $applications->onEachSide(1)->links('pagination::simple-tailwind') }}
  </div>
@endsection

