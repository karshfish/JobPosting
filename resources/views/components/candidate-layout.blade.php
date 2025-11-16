<!doctype html>
<html lang="en" x-data="{
    darkMode: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
}" x-init="$watch('darkMode', value => {
    localStorage.setItem('theme', value ? 'dark' : 'light');
    document.documentElement.classList.toggle('dark', value);
})">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Candidate Panel</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-dXU+uF1Rj8rFZ/1gO3+eQ6zzNNpJ3ytH4zVZT0x5Xp+3aV+YxJcfH3xvQnE8X6xkF/TZPo3q1TLZsN1h/0ZT0Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        // Set initial theme early to avoid FOUC - UPDATED VERSION
        (function() {
            try {
                const stored = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const isDark = stored ? stored === 'dark' : prefersDark;
                document.documentElement.classList.toggle('dark', isDark);
            } catch (e) {
                /* noop */
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .transition-base {
            transition: all .15s ease-in-out;
        }

        .sidebar.collapsed {
            width: 5rem;
        }

        .sidebar .sidebar-label {
            display: inline;
        }

        .sidebar.collapsed .sidebar-label {
            display: none;
        }

        .sidebar.collapsed .logo-text {
            display: none;
        }

        @keyframes fade-in {
            from {
                opacity: .0;
                transform: translateY(8px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        @keyframes scale-in {
            from {
                opacity: .0;
                transform: scale(.98)
            }

            to {
                opacity: 1;
                transform: scale(1)
            }
        }

        .animate-fade-in {
            animation: fade-in .28s ease-out both;
        }

        .animate-scale-in {
            animation: scale-in .18s ease-out both;
        }
    </style>
</head>

<body class="min-h-dvh bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="min-h-dvh flex">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="sidebar fixed top-0 bottom-0 inset-y-0 left-0 z-40 w-64 -translate-x-full md:translate-x-0 md:static md:flex bg-white dark:bg-gray-900/50 border-r border-gray-200 dark:border-gray-800 flex-col transition-transform duration-150 ease-in-out max-h-[100vh]">

            <div class="h-16 px-4 md:px-6 flex items-center justify-between border-b border-gray-200 dark:border-gray-800">
                <a href="{{ route('candidate.dashboard') }}" class="flex items-center gap-2 min-w-0">
                    <img src="{{ asset('assets/logo.jpg') }}" alt="Logo" class="h-8 w-auto rounded">
                    <span class="logo-text text-lg font-bold text-gray-800 dark:text-gray-100 truncate">Candidate</span>
                </a>
                <button id="sidebar-close" type="button"
                    class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800/50 transition-base"
                    aria-label="Close sidebar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('candidate.dashboard') }}"
                    class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md
                        {{ request()->routeIs('candidate.dashboard')
                            ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300'
                            : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800/50 hover:text-blue-700 dark:hover:text-blue-300' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-5 md:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75V21a.75.75 0 01-.75.75H3.75A.75.75 0 013 21V9.75z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9" />
                    </svg>
                    <span class="sidebar-label">Dashboard</span>
                </a>

                <!-- Browse Jobs -->
                <a href="{{ route('candidate.jobs') }}"
                    class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md
                        {{ request()->routeIs('candidate.jobs*')
                            ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300'
                            : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800/50 hover:text-blue-700 dark:hover:text-blue-300' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-5 md:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                    </svg>
                    <span class="sidebar-label">Browse Jobs</span>
                </a>

                <!-- My Applications -->
                <a href="{{ route('candidate.applications') }}"
                    class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md
                        {{ request()->routeIs('candidate.applications*')
                            ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300'
                            : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800/50 hover:text-blue-700 dark:hover:text-blue-300' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-5 md:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2z" />
                    </svg>
                    <span class="sidebar-label">My Applications</span>
                </a>

                <!-- Profile -->
                <a href="{{ route('candidate.profile') }}"
                    class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md
                        {{ request()->routeIs('candidate.profile')
                            ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300'
                            : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800/50 hover:text-blue-700 dark:hover:text-blue-300' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-5 md:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="sidebar-label">Profile</span>
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="transition-base group flex items-center gap-3 w-full text-left px-3 py-2 rounded-md
                       text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800/50
                       hover:text-blue-700 dark:hover:text-blue-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-5 md:h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6A2.25 2.25 0 0015.75 18.75V15" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 12H9.75M15.75 9L18 12l-2.25 3" />
                        </svg>
                        <span class="sidebar-label">Logout</span>
                    </button>
                </form>
            </nav>


        </aside>

        <!-- Backdrop for mobile -->
        <div id="sidebar-backdrop" class="hidden fixed inset-0 z-30 bg-black/30 md:hidden" aria-hidden="true"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 h-[100vh] overflow-auto">
            <header class="sticky top-0 z-30 bg-white dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-800 px-4 py-[.4rem] md:px-6 flex items-center justify-between shadow-sm animate-scale-in">
                <div class="flex items-center gap-2">
                    <!-- Sidebar toggler -->
                    <button id="sidebar-open" type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800/50 transition-base"
                        aria-label="Open sidebar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>

                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('assets/logo.jpg') }}" alt="Logo" class="h-8 w-auto rounded">
                        <span class="text-2xl font-extrabold tracking-tight text-gray-800 dark:text-white">
                            <span class="text-indigo-600">Hire</span><span>Up</span>
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Theme Toggle for Header -->
                    <!-- Theme Toggle for Header -->
                    <button x-data="{
    darkMode: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
}"
                        @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light'); document.documentElement.classList.toggle('dark', darkMode)"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800/50 transition-base"
                        aria-label="Toggle theme">
                        <template x-if="darkMode">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </template>
                        <template x-if="!darkMode">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </template>
                    </button>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ profileOpen: false }">
                        <button @click="profileOpen = !profileOpen" @keydown.escape.window="profileOpen = false"
                            type="button"
                            class="flex items-center gap-2 rounded-full border border-transparent
                                   bg-white dark:bg-gray-900 px-3 py-1.5 text-sm font-medium
                                   text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-800
                                   transition focus:outline-none">
                            <img class="h-9 w-9 rounded-full border border-gray-300 dark:border-gray-600 object-cover"
                                src="{{ Auth::user()?->profile_photo_path
                                    ? asset('storage/' . Auth::user()->profile_photo_path)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()?->name ?? 'Guest') . '&background=4f46e5&color=fff' }}"
                                alt="{{ Auth::user()?->name ?? 'Guest' }}">
                            <span class="hidden sm:block">{{ auth()->user()?->name ?? 'Guest' }}</span>

                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 transition-transform duration-200"
                                :class="profileOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="profileOpen" @click.away="profileOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                            class="absolute right-0 mt-2 w-52 origin-top-right rounded-xl
                                   bg-white dark:bg-gray-900 shadow-lg ring-1 ring-black/10 z-50">
                            <div class="py-2">
                                <a href="{{ route('candidate.profile') }}"
                                    class="flex items-center gap-2 px-4 py-2 text-sm
           text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-gray-700 dark:text-gray-300"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 12c2.485 0 4.5-2.239 4.5-5S14.485 2 12 2 7.5 4.239 7.5 7s2.015 5 4.5 5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 22c0-4 4-7 8-7s8 3 8 7" />
                                    </svg>

                                    <span>Profile</span>
                                </a>


                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex w-full items-center gap-2 px-4 py-2 text-sm
           text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 12H9m9 0l-3-3m3 3l-3 3" />
                                        </svg>

                                        <span>Logout</span>
                                    </button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-4 md:p-6 max-w-7xl mx-auto w-full animate-fade-in">
                @if (session('status'))
                <div class="mb-4 rounded-md border border-green-200 dark:border-green-900 bg-green-50 dark:bg-emerald-900/30 text-green-800 dark:text-emerald-200 px-4 py-3">
                    {{ session('status') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-4 rounded-md border border-red-200 dark:border-red-900 bg-red-50 dark:bg-red-900/30 text-red-800 dark:text-red-200 px-4 py-3">
                    <div class="font-semibold mb-1">There were some problems with your input:</div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="bg-white dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 shadow-sm rounded-lg p-4 md:p-6 transition-all duration-200 hover:shadow-md">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <script>
        // Sidebar toggle and collapse
        (function() {
            const sidebar = document.getElementById('sidebar');
            const openBtn = document.getElementById('sidebar-open');
            const closeBtn = document.getElementById('sidebar-close');
            const backdrop = document.getElementById('sidebar-backdrop');
            const mq = window.matchMedia('(min-width: 768px)'); // Tailwind md

            const applyCollapsed = () => {
                if (!mq.matches) return; // Only on desktop
                const collapsed = localStorage.getItem('candidate-sidebar-collapsed') === '1';
                sidebar.classList.toggle('collapsed', collapsed);
            };

            const openMobile = () => {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            };
            const closeMobile = () => {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            };

            const toggle = () => {
                if (mq.matches) {
                    const collapsed = sidebar.classList.toggle('collapsed');
                    localStorage.setItem('candidate-sidebar-collapsed', collapsed ? '1' : '0');
                } else {
                    if (sidebar.classList.contains('-translate-x-full')) openMobile();
                    else closeMobile();
                }
            };

            openBtn && openBtn.addEventListener('click', toggle);
            closeBtn && closeBtn.addEventListener('click', closeMobile);
            backdrop && backdrop.addEventListener('click', closeMobile);
            window.addEventListener('resize', () => {
                if (mq.matches) {
                    backdrop.classList.add('hidden');
                    applyCollapsed();
                } else {
                    sidebar.classList.remove('collapsed');
                }
            });

            // Init
            applyCollapsed();
        })();
    </script>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>

</html>
