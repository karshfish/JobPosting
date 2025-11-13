<x-candidate-layout>
    {{-- 📋 Applications Section --}}
    <div class="bg-white border border-gray-100 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 p-6 mb-8">
        <div class="flex justify-between items-center mb-4 border-b pb-3">
            <h2 class="text-2xl font-semibold text-gray-800">My Job Applications</h2>

        </div>

        @if($applications->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($applications as $application)
            <div
                class="bg-gray-50 rounded-xl border border-gray-100 p-5 hover:-translate-y-1 hover:shadow-xl transition duration-300">
                <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $application->job->title }}</h3>
                <p class="text-gray-500 text-sm mb-2">📍 {{ $application->job->location ?? 'Remote' }}</p>

                {{-- Status Badge --}}
                @php
                $statusColors = [
                'pending' => 'bg-yellow-100 text-yellow-700',
                'accepted' => 'bg-green-100 text-green-700',
                'rejected' => 'bg-red-100 text-red-700',
                ];
                $statusIcons = [
                'pending' => '⏳',
                'accepted' => '✅',
                'rejected' => '❌',
                ];
                @endphp

                <span
                    class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$application->status] ?? 'bg-gray-200 text-gray-600' }}">
                    {{ $statusIcons[$application->status] ?? '🕓' }} {{ ucfirst($application->status) }}
                </span>

                {{-- Applied Date --}}
                <p class="text-xs text-gray-400 mt-2">
                    📅 Applied on: {{ $application->created_at->format('M d, Y') }}
                </p>

                {{-- Actions --}}
                <div class="flex justify-end items-center mt-4 space-x-3">
                    <a href="{{ route('candidate.applications.edit', $application) }}"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium transition">✏️ Edit</a>

                    <form action="{{ route('candidate.applications.delete', $application) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this application?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-red-600 hover:text-red-800 text-sm font-medium transition">🗑️ Delete</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center text-gray-500 bg-gray-50 py-10 rounded-lg border">
            <p class="text-lg">You haven’t applied to any jobs yet.</p>
            <a href="{{ route('candidate.jobs') }}"
                class="text-blue-600 font-medium hover:underline mt-2 inline-block">
                Browse Available Jobs →
            </a>
        </div>
        @endif
    </div>
</x-candidate-layout>
