<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Apply for: {{ $job->title }}</h1>

        <div class="bg-white shadow rounded p-4">
            <p class="mb-4"><strong>Location:</strong> {{ $job->location ?? '-' }}</p>
            <p class="mb-4"><strong>Description:</strong> {{ $job->description }}</p>

            <form action="{{ route('candidate.jobs.submit', $job) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Resume (PDF)</label>
                    <input type="file" name="resume" class="border p-2 w-full rounded">
                    @if($candidate->resume)
                    <p class="text-sm text-gray-500 mt-1">Current: <a href="{{ asset('storage/' . $candidate->resume) }}" target="_blank">Download</a></p>
                    @endif
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit Application</button>
            </form>
        </div>
    </div>
</x-app-layout>
