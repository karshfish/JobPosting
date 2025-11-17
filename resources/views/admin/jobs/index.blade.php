@extends('admin.layouts.app')

@section('content')
  @php
    $statusCounts = $statusCounts ?? [];
    $draftCount = $statusCounts['draft'] ?? 0;
    $publishedCount = $statusCounts['published'] ?? 0;
    $closedCount = $statusCounts['closed'] ?? 0;
    $viewMode = $viewMode ?? 'all';
  @endphp

  <div class="flex items-center justify-between mb-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Jobs</h1>
      <p class="text-sm text-slate-600 dark:text-slate-400">
        Simple overview of all job postings.
      </p>
    </div>
    <div class="hidden md:flex gap-3 text-xs">
      <div class="rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/60 px-3 py-2">
        <div class="text-slate-500 dark:text-slate-400">Draft</div>
        <div class="mt-0.5 font-semibold text-slate-900 dark:text-slate-100">{{ $draftCount }}</div>
      </div>
      <div class="rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/60 px-3 py-2">
        <div class="text-slate-500 dark:text-slate-400">Published</div>
        <div class="mt-0.5 font-semibold text-slate-900 dark:text-slate-100">{{ $publishedCount }}</div>
      </div>
      <div class="rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/60 px-3 py-2">
        <div class="text-slate-500 dark:text-slate-400">Closed</div>
        <div class="mt-0.5 font-semibold text-slate-900 dark:text-slate-100">{{ $closedCount }}</div>
      </div>
    </div>
  </div>

  <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <div class="text-xs text-slate-500 dark:text-slate-400 md:hidden">
      Draft:
      <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $draftCount }}</span>
      A� Published:
      <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $publishedCount }}</span>
      A� Closed:
      <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $closedCount }}</span>
    </div>
    <div class="flex gap-2">
      <a
        href="{{ route('admin.jobs.pending') }}"
        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium transition-base
          {{ $viewMode === 'draft'
              ? 'bg-blue-600 text-white dark:bg-blue-500'
              : 'bg-white dark:bg-slate-900/60 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800/70' }}"
      >
        Draft
      </a>
      <a
        href="{{ route('admin.jobs.published') }}"
        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium transition-base
          {{ $viewMode === 'published'
              ? 'bg-emerald-600 text-white dark:bg-emerald-500'
              : 'bg-white dark:bg-slate-900/60 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800/70' }}"
      >
        Published
      </a>
      <a
        href="{{ route('admin.jobs.trashed') }}"
        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium transition-base
          {{ $viewMode === 'closed'
              ? 'bg-rose-600 text-white dark:bg-rose-500'
              : 'bg-white dark:bg-slate-900/60 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800/70' }}"
      >
        Closed
      </a>
    </div>
  </div>

  <div class="overflow-x-auto rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60">
    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
      <thead class="bg-slate-50 dark:bg-slate-900/80">
        <tr class="text-left text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider">
          <th class="px-3 py-2">Title</th>
          <th class="px-3 py-2">employer</th>
          <th class="px-3 py-2 hidden sm:table-cell">Applications</th>
          <th class="px-3 py-2">Status</th>
          <th class="px-3 py-2 text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
        @forelse($jobs as $job)
          @php
            $status = $job->status ?? 'draft';
            $statusConfig = [
              'draft' => [
                'label' => 'Draft',
                'class' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200',
              ],
              'published' => [
                'label' => 'Published',
                'class' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200',
              ],
              'closed' => [
                'label' => 'Closed',
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
              {{ $job->title }}
            </td>
            <td class="px-3 py-2 text-sm text-slate-700 dark:text-slate-200 align-middle">
              {{ $job->user->name ?? 'Unknown' }}
            </td>
            <td class="px-3 py-2 text-sm text-slate-700 dark:text-slate-200 align-middle hidden sm:table-cell">
              {{ $job->applications_count ?? 0 }}
            </td>
            <td class="px-3 py-2 align-middle">
              <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $statusMeta['class'] }}">
                {{ $statusMeta['label'] }}
              </span>
            </td>
            <td class="px-3 py-2 align-middle">
              <div class="flex justify-end gap-2">
                <a
                  href="{{ route('admin.jobs.show', $job->id) }}"
                  class="inline-flex items-center gap-1 px-2 py-1 rounded border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-base"
                >
                  View
                </a>

                @if(!method_exists($job, 'trashed') || ! $job->trashed())
                  @if($status === 'draft')
                    <form method="POST" action="{{ route('admin.jobs.approve', $job) }}" class="inline">
                      @csrf
                      <button class="inline-flex items-center gap-1 px-2 py-1 rounded border border-emerald-300 text-emerald-700 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-base text-xs">
                        Approve
                      </button>
                    </form>

                    <form method="POST" action="{{ route('admin.jobs.reject', $job) }}" class="inline">
                      @csrf
                      <input type="hidden" name="reason" value="Not suitable.">
                      <button class="inline-flex items-center gap-1 px-2 py-1 rounded border border-rose-300 text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-900/30 transition-base text-xs">
                        Reject
                      </button>
                    </form>
                  @elseif($status === 'published')
                    <form method="POST" action="{{ route('admin.jobs.reject', $job) }}" class="inline">
                      @csrf
                      <input type="hidden" name="reason" value="Not suitable.">
                      <button class="inline-flex items-center gap-1 px-2 py-1 rounded border border-rose-300 text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-900/30 transition-base text-xs">
                        Close
                      </button>
                    </form>
                  @endif

                  {{-- No separate archive button; closed jobs are soft deleted via reject/close --}}
                @else
                  @if($status === 'closed')
                    <form method="POST" action="{{ route('admin.jobs.republish', $job->id) }}" class="inline">
                      @csrf
                      @method('PATCH')
                      <button class="inline-flex items-center gap-1 px-2 py-1 rounded border border-emerald-300 text-emerald-700 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-base text-xs">
                        Republish
                      </button>
                    </form>
                  @else
                    <form method="POST" action="{{ route('admin.jobs.restore', $job->id) }}" class="inline">
                      @csrf
                      @method('PATCH')
                      <button class="inline-flex items-center gap-1 px-2 py-1 rounded border border-emerald-300 text-emerald-700 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-base text-xs">
                        Restore
                      </button>
                    </form>
                  @endif

                  <form method="POST" action="{{ route('admin.jobs.force-delete', $job->id) }}" class="inline js-job-force-delete-form">
                    @csrf
                    @method('DELETE')
                    <button class="inline-flex items-center gap-1 px-2 py-1 rounded border border-rose-500 text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-900/30 transition-base text-xs">
                      Delete
                    </button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-3 py-10 text-center text-sm text-slate-500 dark:text-slate-400">
              No jobs to show.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $jobs->onEachSide(1)->links('pagination::simple-tailwind') }}
  </div>
@endsection
