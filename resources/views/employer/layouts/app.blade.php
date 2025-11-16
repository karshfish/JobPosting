<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employer Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-dXU+uF1Rj8rFZ/1gO3+eQ6zzNNpJ3ytH4zVZT0x5Xp+3aV+YxJcfH3xvQnE8X6xkF/TZPo3q1TLZsN1h/0ZT0Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        // Set initial theme early to avoid FOUC (only light/dark)
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
        /* Smooth hover transitions for nav & buttons */
        .transition-base {
            transition: all .15s ease-in-out;
        }

        /* Collapsible sidebar behavior on desktop */
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

        .sidebar .nav-icon {
            width: 1.5rem;
            height: 1.5rem;
        }

        /* Make icons larger when sidebar is collapsed */
        .sidebar.collapsed .nav-icon {
            width: 3rem;
            height: 1rem;
        }

        .sidebar.collapsed .sidebar-footer {
            display: none;
        }

        /* Micro animations */
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

<body class="min-h-dvh bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100">
    <div class="min-h-dvh flex">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="sidebar fixed top-0 bottom-0  inset-y-0 left-0 z-40 w-64 -translate-x-full md:translate-x-0 md:static md:flex bg-white dark:bg-slate-900/50 border-r border-slate-200 dark:border-slate-800 flex-col transition-transform duration-150 ease-in-out max-h-[100vh]">
            <div
                class="h-16 px-4 md:px-6 flex items-center justify-between border-b border-slate-200 dark:border-slate-800">
                <a href="{{ route('employer.dashboard') }}" class="flex items-center gap-2 min-w-0">
                    <img src="{{ asset('assets/logo.jpg') }}" alt="Logo" class="h-8 w-auto rounded">
                    <span
                        class="logo-text text-lg font-bold text-slate-800 dark:text-slate-100 truncate">Employer</span>
                </a>
                <button id="sidebar-close" type="button"
                    class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-base"
                    aria-label="Close sidebar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav x-data="{ activeLink: '{{ request()->routeIs('employer.dashboard') ? 'dashboard' : (request()->routeIs('employer.jobs.*') ? 'create-job' : (request()->routeIs('Applications.index') ? 'applications' : (request()->routeIs('employer.analysis') ? 'analysis' : ''))) }}' }" class="flex-1 p-4 space-y-1">

                <!-- Dashboard -->
                <a href="{{ route('employer.dashboard') }}" @click="activeLink = 'dashboard'"
                    :class="activeLink === 'dashboard' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' :
                        'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-blue-700 dark:hover:text-blue-300'"
                    class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-5 md:h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 9.75L12 3l9 6.75V21a.75.75 0 01-.75.75H3.75A.75.75 0 013 21V9.75z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9" />
                    </svg>
                    <span class="sidebar-label">Dashboard</span>
                </a>

                <!-- Create Job -->
                <a href="{{ route('jobs.create') }}"
                    class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md
                        {{ request()->routeIs('jobs.create')
                            ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300'
                            : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-blue-700 dark:hover:text-blue-300' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-5 md:h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 7V6a2 2 0 012-2h8a2 2 0 012 2v1M6 7h12v12H6V7z" />
                    </svg>
                    <span class="sidebar-label">Create Job</span>
                </a>


                <!-- Applications -->
                <a href="{{ route('Applications.index') }}" @click="activeLink = 'applications'"
                    :class="activeLink === 'applications' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' :
                        'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-blue-700 dark:hover:text-blue-300'"
                    class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-5 md:h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6v4H9V3z" />
                    </svg>
                    <span class="sidebar-label">Applications</span>
                </a>

                <!-- Analysis -->
                <a href="{{ route('employer.analysis') }}" @click="activeLink = 'analysis'"
                    :class="activeLink === 'analysis' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' :
                        'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-blue-700 dark:hover:text-blue-300'"
                    class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:w-5 md:h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M9 17V9m4 8V5m4 12v-4" />
                    </svg>
                    <span class="sidebar-label">Analysis</span>
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="transition-base group flex items-center gap-3 w-full text-left px-3 py-2 rounded-md
                       text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50
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





            <div class="sidebar-footer px-4 py-3 border-t border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-900/40">
                @if (auth()->check())
                    <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Your name : <span
                            class="inline-flex items-center px-2 py-0.5 text-[11px] font-medium rounded border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200">{{ auth()->user()->name ?: 'none' }}</span>
                    </div>
                    <div class="text-xs text-slate-500 my-2 dark:text-slate-400 mb-1">Your email : <span
                            class="inline-flex items-center px-2 py-0.5 text-[11px] font-medium rounded border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200">{{ auth()->user()->email ?: 'none' }}</span>
                    </div>
                    <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Your role : <span
                            class="inline-flex items-center px-2 py-0.5 text-[11px] font-medium rounded border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200">{{ auth()->user()->role ?: 'none' }}</span>
                    </div>

                    <div class="py-3 flex items-center justify-center gap-3" x-data="{ profileOpen: false, darkMode: localStorage.theme === 'dark' }"
                        x-init="if (darkMode) document.documentElement.classList.add('dark');
                        else document.documentElement.classList.remove('dark');">

                        <div class="flex items-center" x-data="{ darkMode: localStorage.theme === 'dark' }"
                            x-init="if (darkMode) document.documentElement.classList.add('dark'); else document.documentElement.classList.remove('dark');">
                            <button
                                @click="
                                    darkMode = !darkMode;
                                    localStorage.theme = darkMode ? 'dark' : 'light';
                                    document.documentElement.classList.toggle('dark', darkMode);
                                "
                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-slate-300 dark:border-slate-700
                       text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50
                       text-[11px] font-medium transition-all duration-200">
                                <template x-if="darkMode">
                                    <span>Light mode</span>
                                </template>
                                <template x-if="!darkMode">
                                    <span>Dark mode</span>
                                </template>
                            </button>
                        </div>
                    </div>
                @endif
                <div class="mt-3 text-[11px] text-slate-500 dark:text-slate-400 flex items-center justify-between">
                    <span>&copy; 2025 HireHup</span>
                    <span class="text-[10px] uppercase tracking-wide text-slate-400 dark:text-slate-500">Employer Panel</span>
                </div>
            </div>
        </aside>
        <!-- Backdrop for mobile -->
        <div id="sidebar-backdrop" class="hidden fixed inset-0 z-30 bg-black/30 md:hidden" aria-hidden="true"></div>

        <!-- Main -->
        <div class="flex-1 flex flex-col min-w-0 h-[100vh] overflow-auto">
            <header
                class="sticky top-0 z-30  bg-white dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-800 px-4 py-[.4rem] md:px-6 flex items-center justify-between shadow-sm animate-scale-in">
                <div class="flex items-center gap-2">
                    <!-- Sidebar toggler -->
                    <button id="sidebar-open" type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-base"
                        aria-label="Open sidebar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('assets/logo.jpg') }}" alt="Logo" class="h-8 w-auto rounded">
                        <span class="text-2xl font-extrabold tracking-tight text-gray-800">
                            <span class="text-indigo-600">Hire</span><span class="dark:text-white">Up</span>
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3" x-data="{ profileOpen: false, darkMode: localStorage.theme === 'dark' }" x-init="if (darkMode) document.documentElement.classList.add('dark');
                else document.documentElement.classList.remove('dark');">


                    <!-- 👤 Profile Dropdown -->
                    <div class="relative">
                        <button @click="profileOpen = !profileOpen" @keydown.escape.window="profileOpen = false"
                            type="button"
                            class="flex items-center gap-2 rounded-full border border-transparent
                   bg-white dark:bg-slate-900 px-3 py-1.5 text-sm font-medium
                   text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-slate-800
                   transition focus:outline-none">
                            <img class="h-9 w-9 rounded-full border border-gray-300 dark:border-slate-600 object-cover"
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
                   bg-white dark:bg-slate-900 shadow-lg ring-1 ring-black/10 z-50">
                            <div class="py-2">

                                {{-- Home (visible only for logged users) --}}
                                @auth
                                    <a href="{{ route('jobs.index') }}"
                                        class="flex items-center gap-2 px-4 py-2 text-sm
                   text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-800 transition">
                                        🏠 <span>Home</span>
                                    </a>

                                    {{-- Dashboard based on user role --}}
                                    @php
                                        $dashboardRoute = match (auth()->user()->role) {
                                            'candidate' => 'candidate.dashboard',
                                            'employer' => 'employer.dashboard',
                                            'admin' => 'admin.dashboard',
                                            default => null,
                                        };
                                    @endphp

                                    @if ($dashboardRoute)
                                        <a href="{{ route($dashboardRoute) }}"
                                            class="flex items-center gap-2 px-4 py-2 text-sm
                       text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-800 transition">
                                            📊 <span>Dashboard</span>
                                        </a>
                                    @endif
                                @endauth


                                {{-- Profile --}}
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-2 px-4 py-2 text-sm
               text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-800 transition">
                                    👤 <span>Profile</span>
                                </a>

                                {{-- Logout --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex w-full items-center gap-2 px-4 py-2 text-sm
                   text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-800 transition">
                                        🚪 <span>Logout</span>
                                    </button>
                                </form>

                            </div>

                        </div>
                    </div>

                    <!-- Optional placeholder for page actions -->
                    <div class="text-sm text-slate-500 dark:text-slate-400">@yield('page-actions')</div>
                </div>

            </header>

            <main class="p-4 md:p-6 max-w-7xl mx-auto w-full animate-fade-in">
                @if (session('status'))
                <div
                    class="mb-4 rounded-md border border-green-200 dark:border-green-900 bg-green-50 dark:bg-emerald-900/30 text-green-800 dark:text-emerald-200 px-4 py-3">
                    {{ session('status') }}
                </div>
                @endif

                @if ($errors->any())
                <div
                    class="mb-4 rounded-md border border-red-200 dark:border-red-900 bg-red-50 dark:bg-red-900/30 text-red-800 dark:text-red-200 px-4 py-3">
                    <div class="font-semibold mb-1">There were some problems with your input:</div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div
                    class="bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 shadow-sm rounded-lg p-4 md:p-6 transition-all duration-200 hover:shadow-md">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <script>
        (function() {
            const btn = document.getElementById('theme-toggle');
            const setLabel = (mode) => {
                document.querySelector('.theme-toggle-light').classList.toggle('hidden', mode !== 'light');
                document.querySelector('.theme-toggle-dark').classList.toggle('hidden', mode !== 'dark');
            };
            const apply = (mode) => {
                const isDark = mode === 'dark';
                document.documentElement.classList.toggle('dark', isDark);
                setLabel(mode);
            };
            const getMode = () => localStorage.getItem('theme') || (document.documentElement.classList.contains(
                'dark') ? 'dark' : 'light');
            let mode = getMode();
            apply(mode);
            btn && btn.addEventListener('click', () => {
                mode = getMode();
                mode = mode === 'light' ? 'dark' : 'light';
                localStorage.setItem('theme', mode);
                apply(mode);
            });
        })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        (function() {
            const hasStatus = @json(session('status') ? true : false);
            const statusMessage = @json(session('status'));
            const hasErrorMessage = @json(session('error') ? true : false);
            const errorMessage = @json(session('error'));
            const validationErrors = @json($errors->all());

            if (hasStatus && statusMessage) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: statusMessage,
                    confirmButtonColor: '#4f46e5'
                });
            }

            if (hasErrorMessage && errorMessage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    confirmButtonColor: '#ef4444'
                });
            }

            if (validationErrors && validationErrors.length) {
                const html = '<ul style="text-align:left;margin:0;padding-left:1.25rem;">'
                    + validationErrors.map(function(e) { return '<li>' + e + '</li>'; }).join('')
                    + '</ul>';
                Swal.fire({
                    icon: 'error',
                    title: 'There were some problems with your input:',
                    html: html,
                    confirmButtonColor: '#ef4444'
                });
            }
        })();
    </script>
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
                const collapsed = localStorage.getItem('sidebar-collapsed') === '1';
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
                    localStorage.setItem('sidebar-collapsed', collapsed ? '1' : '0');
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
