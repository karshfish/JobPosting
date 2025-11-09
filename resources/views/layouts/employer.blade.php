<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Employer Dashboard') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="font-sans antialiased bg-gray-100">
<div x-data="{ sidebarOpen: false, profileOpen: false }" class="min-h-screen flex flex-col">

    {{-- 🌐 Top Navbar --}}
    <nav class="bg-white border-b shadow-sm sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="md:hidden p-2 rounded-md text-gray-600 hover:bg-gray-200 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': sidebarOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{ 'hidden': !sidebarOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <a href="{{ route('employer.dashboard') }}" class="text-xl font-semibold text-indigo-600">
                    {{ config('app.name', 'JobBoard') }}
                </a>
            </div>

            <div class="relative">
                <button @click="profileOpen = !profileOpen"
                        class="flex items-center text-sm focus:outline-none rounded-full hover:bg-gray-100 px-3 py-1">
                    <img class="h-8 w-8 rounded-full mr-2"
                         src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()?->name ?? 'Guest') }}&background=4f46e5&color=fff"
                         alt="Profile">
                    <span class="text-gray-700 font-medium hidden sm:block">{{ auth()->user()?->name ?? 'Guest' }}</span>
                    <svg class="w-4 h-4 ml-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="profileOpen" @click.away="profileOpen = false"
                     x-transition
                     class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md py-2 z-40">
                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        👤 Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            🚪 Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex flex-1 overflow-hidden">

        <aside class="fixed inset-y-0 left-0 w-64 bg-white border-r shadow-md transform md:translate-x-0 transition-transform duration-300 ease-in-out z-20"
               :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
            <div class="p-4 border-b flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-700">Employer Panel</h2>
                <button @click="sidebarOpen = false" class="text-gray-600 md:hidden hover:text-gray-900">
                    ✕
                </button>
            </div>

            <nav class="p-4 space-y-1 text-sm font-medium text-gray-700">
                <a href="{{ route('employer.dashboard') }}"
                   class="flex items-center px-3 py-2 rounded-md
                       {{ request()->routeIs('employer.dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">
                    🏠 <span class="ml-2">Dashboard</span>
                </a>

                <a href="{{ route('jobs.create') }}"
                   class="flex items-center px-3 py-2 rounded-md
                       {{ request()->routeIs('jobs.create') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">
                    📝 <span class="ml-2">Post a Job</span>
                </a>

                <a href="{{ route('employer.jobListings') }}"
                   class="flex items-center px-3 py-2 rounded-md
                       {{ request()->routeIs('employer.jobListings') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">
                    📄 <span class="ml-2">Job Listings</span>
                </a>

                {{-- <a href="{{ url('/applications') }}"
                   class="flex items-center px-3 py-2 rounded-md
                       {{ request()->is('applications') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">
                    📥 <span class="ml-2">Applications</span>
                </a> --}}
                <a href="{{ url('/employer/analysis') }}"
                   class="flex items-center px-3 py-2 rounded-md
                       {{ request()->is('employer/analysis') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">
                    📊 <span class="ml-2">Analysis</span>
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center px-3 py-2 rounded-md
                       {{ request()->routeIs('profile.edit') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">
                    ⚙️ <span class="ml-2">Profile</span>
                </a>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="flex items-center px-3 py-2 rounded-md hover:bg-gray-100">
                    🚪 <span class="ml-2">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </nav>
        </aside>

        <main class="flex-1 overflow-y-auto p-6 md:ml-64 transition-all">
            @isset($header)
                <header class="mb-6 border-b pb-4">
                    {{ $header }}
                </header>
            @endisset

            {{ $slot }}
        </main>
    </div>

</div>
</body>
</html>
