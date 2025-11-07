<x-app-layout>
    <div class="max-w-6xl mx-auto py-8">

        <form action="{{ route('jobs.index') }}" method="GET" class="mb-6 flex gap-3">

            <input type="text" name="keyword" placeholder="Search title..."
                class="border p-2 flex-1 rounded"
                value="{{ request('keyword') }}">

            <select name="work_type" class="border p-2 rounded">
                <option value="">Work Type</option>
                <option value="remote">Remote</option>
                <option value="on-site">On-site</option>
                <option value="hybrid">Hybrid</option>
            </select>

            <button class="bg-blue-600 text-white px-4 rounded">Search</button>
        </form>

        @foreach($jobs as $job)
        <a href="{{ route('jobs.show', $job) }}" class="block border p-4 rounded mb-4 hover:bg-gray-50">
            <h2 class="text-lg font-semibold">{{ $job->title }}</h2>
            <p class="text-sm text-gray-600">{{ $job->location }} • {{ ucfirst($job->work_type) }}</p>
        </a>
        @endforeach

        {{ $jobs->links() }}
    </div>
</x-app-layout>
