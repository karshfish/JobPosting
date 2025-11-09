<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">

        <h1 class="text-2xl font-bold mb-2">{{ $job->title }}</h1>
        <p class="text-gray-600 mb-4">{{ $job->location }} • {{ ucfirst($job->work_type) }}</p>

        <div class="mb-6">
            {!! nl2br(e($job->description)) !!}
        </div>

        <form action="{{ route('jobs.apply', $job) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label class="block font-medium mb-1">Upload Resume (optional)</label>
            <input type="file" name="resume" class="mb-4">

            <button class="bg-green-600 text-white px-4 py-2 rounded">
                Apply
            </button>
        </form>

        @if(session('error'))
        <p class="mt-4 text-red-600">{{ session('error') }}</p>
        @endif

    </div>
</x-app-layout>
