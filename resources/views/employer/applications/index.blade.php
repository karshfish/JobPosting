@extends('employer.layouts.app')

@section('content')
<div class="py-4 space-y-6">

    {{-- Search & Filter --}}
    <div>
        <form method="GET" action="{{ route('Applications.index') }}"
              class="flex flex-wrap items-end gap-4 bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">

            {{-- Search by Job Title --}}
            <div class="flex flex-col">
                <label for="search" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search Title</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                       placeholder="Search Application..."
                       class="w-48 sm:w-56 border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 text-sm
                              dark:bg-slate-700 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            {{-- Status Filter --}}
            <div class="flex flex-col">
                <label for="status" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select id="status" name="status"
                        class="w-28 border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 text-sm
                               dark:bg-slate-700 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Accepted" {{ request('status') == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
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
                ['label'=>'Total Applications','value'=>$totalApplication,'color'=>'bg-indigo-500'],
                ['label'=>'Pending','value'=>$pendingApplication,'color'=>'bg-gray-500'],
                ['label'=>'Accepted','value'=>$AcceptedApplication,'color'=>'bg-green-500'],
                ['label'=>'Rejected','value'=>$RejectedApplication,'color'=>'bg-red-500'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
            <div class="p-5 flex items-center gap-4">
                <div class="flex-shrink-0 {{ $stat['color'] }} rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
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

    {{-- Recent Application Table --}}
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-slate-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Application Posts</h3>
        </div>

        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                @forelse($latestApplication as $application)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                        <td class="px-6 py-4 text-sm font-medium">
                            <a href="{{ route('Applications.show', $application) }}"
                               class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-300 dark:hover:text-indigo-200">
                                {{ $application->job->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($application->status == 'Accepted') bg-green-100 text-green-800
                                @elseif($application->status == 'Rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                            {{ $application->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route('Applications.show', $application) }}" class="text-indigo-600 hover:text-indigo-900 dark:hover:text-indigo-400 mr-3">View</a>
                        </td>
                         <td class="px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route('Applications.edit', $application) }}" class="text-indigo-600 hover:text-indigo-900 dark:hover:text-indigo-400 mr-3">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No Application found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($latestApplication->hasPages())
            <div class="px-6 py-4">
                {{ $latestApplication->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
