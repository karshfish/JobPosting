<x-employer-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Job Listings') }}</h2>
                <p class="mt-1 text-sm text-gray-600">{{ __('Manage your job listings and applications') }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('jobs.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    {{ __('Post New Job') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
    <div class="mt-8 mb-6">
        <form method="GET" action="{{ route('employer.jobListings') }}"
              class="flex flex-wrap items-end gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-200">

            {{-- Search by Title --}}
            <div class="flex flex-col">
                <label for="search" class="text-sm font-medium text-gray-700 mb-1">Search Title</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                       placeholder="Search jobs..."
                       class="w-48 sm:w-56 border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            {{-- Filter by Status --}}
            <div class="flex flex-col">
                <label for="status" class="text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status"
                        class="w-40 border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            {{-- Date Range --}}
            <div class="flex flex-col">
                <label for="from" class="text-sm font-medium text-gray-700 mb-1">From</label>
                <input type="date" id="from" name="from" value="{{ request('from') }}"
                       class="border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            <div class="flex flex-col">
                <label for="to" class="text-sm font-medium text-gray-700 mb-1">To</label>
                <input type="date" id="to" name="to" value="{{ request('to') }}"
                       class="border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            {{-- Quick Filter --}}
            <div class="flex flex-col">
                <label for="period" class="text-sm font-medium text-gray-700 mb-1">Quick Filter</label>
                <select id="period" name="period"
                        class="w-40 border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Select --</option>
                    <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="this_week" {{ request('period') == 'this_week' ? 'selected' : '' }}>This Week</option>
                    <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>This Month</option>
                </select>
            </div>

            {{-- Submit --}}
            <div class="flex flex-col">
                <label class="invisible mb-1">Filter</label>
                <button type="submit"
                        class="inline-flex items-center px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    Filter
                </button>
            </div>
        </form>
    </div>
</div>


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Total Jobs Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Jobs</dt>
                                    <dd class="text-2xl font-semibold text-gray-900">{{ $totalJobs }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Published Jobs Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Published</dt>
                                    <dd class="text-2xl font-semibold text-gray-900">{{ $publishedJobs }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Draft Jobs Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Drafts</dt>
                                    <dd class="text-2xl font-semibold text-gray-900">{{ $draftJobs }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Closed Jobs Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Closed</dt>
                                    <dd class="text-2xl font-semibold text-gray-900">{{ $closedJobs }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Job Posts -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Recent Job Posts</h3>
                    <a href="{{ route('jobs.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                </div>
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">

               <table class="min-w-full divide-y divide-gray-200">
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($latestJobs as $job)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $job->title }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        @if($job->status == 'published') bg-green-100 text-green-800
                        @elseif($job->status == 'draft') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($job->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $job->created_at->format('d M Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('jobs.show', $job) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                    <a href="{{ route('jobs.edit', $job) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                    No jobs found
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- ✅ pagination outside table --}}
@if($latestJobs->hasPages())
    <div class="mt-4 px-6">
        {{ $latestJobs->links() }}
    </div>
@endif



</div>
</div>
        </div>
            </div>

</x-app-layout>
