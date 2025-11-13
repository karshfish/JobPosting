{{-- Candidate Layout Component --}}
<x-app-layout>
    <div class="flex min-h-screen bg-gray-50">

        {{-- 🧭 Sidebar --}}
        <aside class="w-64 bg-white border-r border-gray-200 p-6 hidden md:block">
            <h2 class="text-2xl font-bold text-blue-600 mb-8 text-center">Candidate Panel</h2>

            <nav class="space-y-3">
                <a href="{{ route('candidate.dashboard') }}"
                    class="block px-4 py-2 rounded-lg hover:bg-blue-50 {{ request()->routeIs('candidate.dashboard') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    🏠 Dashboard
                </a>

                <a href="{{ route('candidate.jobs') }}"
                    class="block px-4 py-2 rounded-lg hover:bg-blue-50 {{ request()->routeIs('candidate.jobs*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    💼 Browse Jobs
                </a>

                <a href="{{ route('candidate.applications') }}"
                    class="block px-4 py-2 rounded-lg hover:bg-blue-50 {{ request()->routeIs('candidate.applications*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    📋 My Applications
                </a>

                <a href="{{ route('candidate.profile') }}"
                    class="block px-4 py-2 rounded-lg hover:bg-blue-50 {{ request()->routeIs('candidate.profile') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    👤 Profile
                </a>
            </nav>
        </aside>

        {{-- 🌟 Main Content --}}
        <main class="flex-1 p-6 md:p-10">
            {{ $slot }}
        </main>
    </div>
</x-app-layout>
