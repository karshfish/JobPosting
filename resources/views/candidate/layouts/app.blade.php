<!doctype html>
<html lang="en" x-data="{ darkMode: $persist(false) }" x-init="$watch('darkMode', value => document.documentElement.classList.toggle('dark', value))">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Candidate Panel</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-dXU+uF1Rj8rFZ/1gO3+eQ6zzNNpJ3ytH4zVZT0x5Xp+3aV+YxJcfH3xvQnE8X6xkF/TZPo3q1TLZsN1h/0ZT0Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        // Set initial theme early to avoid FOUC
        (function() {
            try {
                const stored = localStorage.getItem('candidate-theme');
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
                    <button x-data="{ darkMode: localStorage.getItem('candidate-theme') === 'dark' }"
                        @click="darkMode = !darkMode; localStorage.setItem('candidate-theme', darkMode ? 'dark' : 'light'); document.documentElement.classList.toggle('dark', darkMode)"
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
                                    👤 <span>Profile</span>
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex w-full items-center gap-2 px-4 py-2 text-sm
                                               text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                        🚪 <span>Logout</span>
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
