{{-- Candidate Layout Component --}}
<x-app-layout>
    <div class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r border-gray-200 p-6 hidden md:block">
            <h2 class="text-2xl font-bold text-blue-600 mb-8 text-center">Candidate Panel</h2>

            <nav class="space-y-3">
                <a href="{{ route('candidate.dashboard') }}"
                    class="flex items-center px-4 py-2 rounded-lg hover:bg-blue-50 {{ request()->routeIs('candidate.dashboard') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 md:w-5 md:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75V21a.75.75 0 01-.75.75H3.75A.75.75 0 013 21V9.75z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9"></path>
                    </svg>
                    Dashboard
                </a>


                <a href="{{ route('candidate.jobs') }}"
                    class="flex items-center px-4 py-2 rounded-lg hover:bg-blue-50 {{ request()->routeIs('candidate.jobs*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 md:w-5 md:h-5"  fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                    </svg>

                    Browse Jobs
                </a>


                <a href="{{ route('candidate.applications') }}"
                    class="flex items-center px-4 py-2 rounded-lg hover:bg-blue-50 {{ request()->routeIs('candidate.applications*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 md:w-5 md:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2z" />
                    </svg>
                    My Applications
                </a>

                <a href="{{ route('candidate.profile') }}"
                    class="flex items-center px-4 py-2 rounded-lg hover:bg-blue-50 {{ request()->routeIs('candidate.profile') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2 md:w-5 md:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>

                    Profile
                </a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-6 md:p-10">
            {{ $slot }}
        </main>
    </div>
</x-app-layout>
