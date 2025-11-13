@extends('employer.layouts.app')

@section('content')
<div class="py-4 space-y-6">

    {{-- Search & Filter --}}
    <div>
        <form method="GET" action="{{ route('employer.dashboard') }}"
              class="flex flex-wrap items-end gap-4 bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">

            {{-- Search by Title --}}
            <div class="flex flex-col">
                <label for="search" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search Title</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                       placeholder="Search jobs..."
                       class="w-48 sm:w-56 border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 text-sm
                              dark:bg-slate-700 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            {{-- Status --}}
            <div class="flex flex-col">
                <label for="status" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select id="status" name="status"
                        class="w-28 border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 text-sm
                               dark:bg-slate-700 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            {{-- Date Range --}}
            <div class="flex flex-col">
                <label for="from" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From</label>
                <input type="date" id="from" name="from" value="{{ request('from') }}"
                       class="border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 text-sm
                              dark:bg-slate-700 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
            <div class="flex flex-col">
                <label for="to" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">To</label>
                <input type="date" id="to" name="to" value="{{ request('to') }}"
                       class="border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 text-sm
                              dark:bg-slate-700 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            {{-- Quick Filter --}}
            <div class="flex flex-col">
                <label for="period" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quick Filter</label>
                <select id="period" name="period"
                        class="w-40 border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 text-sm
                               dark:bg-slate-700 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Select --</option>
                    <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="this_week" {{ request('period') == 'this_week' ? 'selected' : '' }}>This Week</option>
                    <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>This Month</option>
                </select>
            </div>

            {{-- Submit Button --}}
            <div class="flex flex-col">
                <label class="invisible mb-1">Filter</label>
                <button type="submit"
                        class="inline-flex items-center px-5 py-2 bg-indigo-600 dark:bg-indigo-500
                               text-white text-sm font-medium rounded-md shadow-sm hover:bg-indigo-700 dark:hover:bg-indigo-600
                               focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    Filter
                </button>
            </div>
        </form>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @php
            $stats = [
                ['label'=>'Total Jobs','value'=>$totalJobs,'icon'=>'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745','color'=>'bg-indigo-500'],
                ['label'=>'Published','value'=>$publishedJobs,'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'bg-green-500'],
                ['label'=>'Drafts','value'=>$draftJobs,'icon'=>'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z','color'=>'bg-yellow-500'],
                ['label'=>'Closed','value'=>$closedJobs,'icon'=>'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'bg-red-500']
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
            <div class="p-5 flex items-center gap-4">
                <div class="flex-shrink-0 {{ $stat['color'] }} rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">{{ $stat['label'] }}</dt>
                    <dd class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stat['value'] }}</dd>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Recent Jobs Table --}}
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-slate-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Job Posts</h3>
            <a href="{{ route('jobs.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
        </div>

        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                @forelse($latestJobs as $job)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $job->title }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($job->status == 'published') bg-green-100 text-green-800
                                @elseif($job->status == 'draft') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($job->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                            {{ $job->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route('jobs.show', $job) }}" class="text-indigo-600 hover:text-indigo-900 dark:hover:text-indigo-400 mr-3">View</a>
                            <a href="{{ route('jobs.edit', $job) }}" class="text-indigo-600 hover:text-indigo-900 dark:hover:text-indigo-400">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No jobs found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($latestJobs->hasPages())
            <div class="px-6 py-4">
                {{ $latestJobs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
