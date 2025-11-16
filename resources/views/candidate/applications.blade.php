<x-candidate-layout>
    <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 p-6 mb-8">
        <div class="flex justify-between items-center mb-6 border-b dark:border-gray-600 pb-3">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">My Job Applications</h2>
        </div>

        @if($applications->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($applications as $application)
            <div class="bg-white dark:bg-gray-700 rounded-2xl border border-gray-200 dark:border-gray-600 p-5 hover:-translate-y-1 hover:shadow-lg transition duration-300 flex flex-col justify-between">

                {{-- Top Section: Job Icon + Title --}}
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-300 font-bold text-xl mr-3">
                        {{ strtoupper(substr($application->job->title ?? 'J', 0, 1)) }}
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $application->job->title ?? 'No Job Title' }}</h3>
                </div>

                {{-- Job Location --}}
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-2 mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    {{ $application->job->location ?? 'Remote' }}
                </p>

                {{-- Phone --}}
                <p class="text-sm mt-2 flex items-center text-gray-600 dark:text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                    </svg>
                    Phone: {{ $application->phone ?? '-' }}
                </p>

                {{-- Resume --}}
                @if($application->resume)
                <p class="text-sm mt-1 mb-3 flex items-center text-gray-600 dark:text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                    </svg>
                    Resume:
                    <a href="{{ asset('storage/' . $application->resume) }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline ml-1">Download</a>
                </p>
                @endif

                {{-- Status & Date --}}
                <div class="flex items-center justify-between mb-3">
                    @php
                    $statusColors = [
                    'pending' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300',
                    'accepted' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300',
                    'rejected' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                    ];
                    $statusIcons = [
                    'pending' => '⏳',
                    'accepted' => '✅',
                    'rejected' => '❌',
                    ];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$application->status] ?? 'bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-300' }}">
                        {{ $statusIcons[$application->status] ?? '🕓' }} {{ ucfirst($application->status) }}
                    </span>
                    <p class="text-xs text-gray-400 dark:text-gray-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $application->created_at->format('M d, Y') }}
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex justify-between mt-4">
                    <a href="{{ route('candidate.applications.edit', $application) }}"
                        class="px-3 py-1 text-sm font-medium text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-800 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30 transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5m-5-5l5-5m0 0L13 7m5-5v5" />
                        </svg>
                        Edit
                    </a>

                    <form action="{{ route('candidate.applications.delete', $application) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this application?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-3 py-1 text-sm font-medium text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 transition flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 py-10 rounded-lg border dark:border-gray-600">
            <p class="text-lg">You haven't applied to any jobs yet.</p>
            <a href="{{ route('candidate.jobs') }}" class="text-blue-600 dark:text-blue-400 font-medium hover:underline mt-2 inline-block">
                Browse Available Jobs →
            </a>
        </div>
        @endif
    </div>
</x-candidate-layout>
