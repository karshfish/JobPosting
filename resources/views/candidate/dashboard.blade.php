<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Welcome, {{ $candidate->user->name }}</h1>

        <div class="bg-white shadow rounded p-4">
            <h2 class="text-xl font-semibold mb-3">Your Applications</h2>

            @if($applications->count() > 0)
            <ul class="space-y-2">
                @foreach($applications as $application)
                <li class="border p-3 rounded flex justify-between items-center">
                    <div>
                        <strong>{{ $application->job->title }}</strong>
                        <p class="text-gray-500 text-sm">{{ $application->job->location ?? '' }}</p>
                    </div>
                    <span class="text-sm text-gray-500">Status: {{ $application->status }}</span>
                </li>
                @endforeach
            </ul>
            @else
            <p class="text-gray-500">You have not applied to any jobs yet.</p>
            @endif
        </div>
    </div>
</x-app-layout>
