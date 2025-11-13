<x-candidate-layout>
    <div class="container mx-auto px-6 py-10">

        {{-- Page Title --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Available Job Opportunities</h1>

        {{-- Filters --}}
        <div class="mb-6">
            <form method="GET" action="{{ route('candidate.jobs') }}" class="flex flex-wrap gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-200">

                {{-- Search --}}
                <div class="flex flex-col">
                    <label for="search" class="text-sm font-medium text-gray-700 mb-1">Search Title</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Search jobs..."
                        class="w-48 sm:w-56 border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                </div>

                {{-- Status --}}
                <div class="flex flex-col">
                    <label for="status" class="text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-40 border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                {{-- Date From --}}
                <div class="flex flex-col">
                    <label for="from" class="text-sm font-medium text-gray-700 mb-1">From</label>
                    <input type="date" name="from" id="from" value="{{ request('from') }}"
                        class="border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                </div>

                {{-- Date To --}}
                <div class="flex flex-col">
                    <label for="to" class="text-sm font-medium text-gray-700 mb-1">To</label>
                    <input type="date" name="to" id="to" value="{{ request('to') }}"
                        class="border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" />
                </div>

                {{-- Submit --}}
                <div class="flex flex-col justify-end">
                    <button type="submit" class="inline-flex items-center px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-indigo-700 transition">
                        Filter
                    </button>
                </div>

            </form>
        </div>




        {{-- Jobs Table --}}
        <div class="mt-8 bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="p-4 font-semibold text-gray-700 border-b">Recent Jobs</div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($latestJobs as $job)
                    <tr>
                        <td class="px-6 py-4">{{ $job->title }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($job->status == 'published') bg-green-100 text-green-800
                                    @elseif($job->status == 'draft') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($job->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $job->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right">


                            <a href="{{ route('candidate.jobs.show', $job) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                            <a href="{{ route('candidate.jobs.apply', $job) }}" class="text-indigo-600 hover:text-indigo-900">Apply</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No jobs found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4 px-6">{{ $latestJobs->links() }}</div>
        </div>

    </div>
</x-candidate-layout>
