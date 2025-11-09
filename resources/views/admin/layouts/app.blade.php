<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel</title>
  <script>
    // Set initial theme early to avoid FOUC (only light/dark)
    (function() {
      try {
        const stored = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const isDark = stored ? stored === 'dark' : prefersDark;
        document.documentElement.classList.toggle('dark', isDark);
      } catch (e) { /* noop */ }
    })();
  </script>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <style>
    /* Smooth hover transitions for nav & buttons */
    .transition-base { transition: all .15s ease-in-out; }
    /* Collapsible sidebar behavior on desktop */
    .sidebar.collapsed { width: 4rem; }
    .sidebar .sidebar-label { display: inline; }
    .sidebar.collapsed .sidebar-label { display: none; }
    .sidebar.collapsed .logo-text { display: none; }
    .sidebar .nav-icon { width: 1.5rem; height: 1.5rem; }
    .sidebar.collapsed .nav-icon { width: 2rem; height: 2rem; }
    .sidebar.collapsed .sidebar-footer { display: none; }
    /* Micro animations */
    @keyframes fade-in { from { opacity:.0; transform: translateY(8px) } to { opacity:1; transform: none } }
    @keyframes scale-in { from { opacity:.0; transform: scale(.98) } to { opacity:1; transform: scale(1) } }
    .animate-fade-in { animation: fade-in .28s ease-out both; }
    .animate-scale-in { animation: scale-in .18s ease-out both; }
  </style>
  </head>
<body class="min-h-dvh bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100">
  <div class="min-h-dvh flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar fixed inset-y-0 left-0 z-40 w-64 -translate-x-full md:translate-x-0 md:static md:flex bg-white dark:bg-slate-900/50 border-r border-slate-200 dark:border-slate-800 flex-col transition-transform duration-150 ease-in-out">
      <div class="h-16 px-4 md:px-6 flex items-center justify-between border-b border-slate-200 dark:border-slate-800">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 min-w-0">
          <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-12 w-auto">
          <span class="logo-text text-lg font-bold text-slate-800 dark:text-slate-100 truncate">Admin</span>
        </a>
        <button id="sidebar-close" type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-base" aria-label="Close sidebar">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <nav class="flex-1 p-4 space-y-1">
        <a href="{{ route('admin.dashboard') }}"
           class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50' }}">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="nav-icon w-5 h-5 transition-transform duration-150 ease-out group-hover:scale-110 group-hover:translate-x-0.5"><path d="M11.47 3.84a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 1-1.06 1.06l-.9-.9V19.5A2.25 2.25 0 0 1 17.25 21h-2.5a.75.75 0 0 1-.75-.75v-3.5a1.25 1.25 0 0 0-1.25-1.25h-1a1.25 1.25 0 0 0-1.25 1.25v3.5a.75.75 0 0 1-.75.75h-2.5A2.25 2.25 0 0 1 3.75 19.5v-6.81l-.9.9a.75.75 0 1 1-1.06-1.06l8.68-8.69Z"/></svg>
          <span class="sidebar-label">Dashboard</span>
        </a>
        <a href="{{ route('admin.jobs.index') }}"
           class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.jobs.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50' }}">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="nav-icon w-5 h-5 transition-transform duration-150 ease-out group-hover:scale-110 group-hover:translate-x-0.5"><path d="M9 3.75A2.25 2.25 0 0 1 11.25 1.5h1.5A2.25 2.25 0 0 1 15 3.75V6h3.75A2.25 2.25 0 0 1 21 8.25v9A2.25 2.25 0 0 1 18.75 19.5H5.25A2.25 2.25 0 0 1 3 17.25v-9A2.25 2.25 0 0 1 5.25 6H9V3.75Zm1.5 0V6h3V3.75a.75.75 0 0 0-.75-.75h-1.5a.75.75 0 0 0-.75.75Z"/></svg>
          <span class="sidebar-label">Jobs</span>
        </a>
        <a href="{{ route('admin.categories.index') }}"
           class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50' }}">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="nav-icon w-5 h-5 transition-transform duration-150 ease-out group-hover:scale-110 group-hover:translate-x-0.5"><path d="M3.75 5.25A2.25 2.25 0 0 1 6 3h12a2.25 2.25 0 0 1 2.25 2.25V9A2.25 2.25 0 0 1 18 11.25H6A2.25 2.25 0 0 1 3.75 9V5.25ZM3.75 15A2.25 2.25 0 0 1 6 12.75h12A2.25 2.25 0 0 1 20.25 15v3.75A2.25 2.25 0 0 1 18 21H6a2.25 2.25 0 0 1-2.25-2.25V15Z"/></svg>
          <span class="sidebar-label">Categories</span>
        </a>
        <a href="{{ route('admin.companies.index') }}"
           class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.companies.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50' }}">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="nav-icon w-5 h-5 transition-transform duration-150 ease-out group-hover:scale-110 group-hover:translate-x-0.5"><path d="M3.75 4.5A2.25 2.25 0 0 1 6 2.25h12A2.25 2.25 0 0 1 20.25 4.5v15a.75.75 0 0 1-.75.75H4.5a.75.75 0 0 1-.75-.75v-15ZM7.5 6h9v1.5h-9V6Zm0 3h9v1.5h-9V9Zm0 3h6v1.5h-6V12Z"/></svg>
          <span class="sidebar-label">Companies</span>
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50' }}">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="nav-icon w-5 h-5 transition-transform duration-150 ease-out group-hover:scale-110 group-hover:translate-x-0.5"><path d="M15 8.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM4.5 18.75a6.75 6.75 0 0 1 13.5 0V20a.75.75 0 0 1-.75.75H5.25A.75.75 0 0 1 4.5 20v-1.25Z"/></svg>
          <span class="sidebar-label">Users</span>
        </a>
      </nav>
      <div class="sidebar-footer px-4 py-3 border-t border-slate-200 dark:border-slate-800">
        @if(auth()->check())
          <div class="mb-2 text-sm font-medium text-slate-800 dark:text-slate-100">{{ auth()->user()->name }}</div>
          @php($roles = auth()->user()->getRoleNames())
          @if($roles->isNotEmpty())
            <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Your roles</div>
            <div class="flex flex-wrap gap-1">
              @foreach($roles as $role)
                <span class="inline-flex items-center px-2 py-0.5 text-[11px] font-medium rounded border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200">{{ $role }}</span>
              @endforeach
            </div>
          @endif
        @endif
        <div class="mt-3 text-[11px] text-slate-500 dark:text-slate-400">&copy; {{ date('Y') }} JobPosting</div>
      </div>
    </aside>
    <!-- Backdrop for mobile -->
    <div id="sidebar-backdrop" class="hidden fixed inset-0 z-30 bg-black/30 md:hidden" aria-hidden="true"></div>

    <!-- Main -->
    <div class="flex-1 flex flex-col min-w-0">
      <header class="sticky top-0 z-30 h-16 bg-white dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-800 px-4 md:px-6 flex items-center justify-between shadow-sm animate-scale-in">
        <div class="flex items-center gap-2">
          <!-- Sidebar toggler -->
          <button id="sidebar-open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-base" aria-label="Open sidebar">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
          </button>
          <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-10 w-auto">
          <span class="font-semibold text-slate-800 dark:text-slate-100">Admin</span>
        </div>
        <div class="flex items-center gap-3">
          <button id="theme-toggle" type="button" class="transition-base inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50 text-sm">
            <span class="theme-toggle-light hidden">Light</span>
            <span class="theme-toggle-dark hidden">Dark</span>
          </button>
          <div class="text-sm text-slate-500 dark:text-slate-400">@yield('page-actions')</div>
        </div>
      </header>

      <main class="p-4 md:p-6 max-w-7xl mx-auto w-full animate-fade-in">
        @if(session('status'))
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

        <div class="bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 shadow-sm rounded-lg p-4 md:p-6 transition-all duration-200 hover:shadow-md">
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
      const getMode = () => localStorage.getItem('theme') || (document.documentElement.classList.contains('dark') ? 'dark' : 'light');
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

      const openMobile = () => { sidebar.classList.remove('-translate-x-full'); backdrop.classList.remove('hidden'); };
      const closeMobile = () => { sidebar.classList.add('-translate-x-full'); backdrop.classList.add('hidden'); };

      const toggle = () => {
        if (mq.matches) {
          const collapsed = sidebar.classList.toggle('collapsed');
          localStorage.setItem('sidebar-collapsed', collapsed ? '1' : '0');
        } else {
          if (sidebar.classList.contains('-translate-x-full')) openMobile(); else closeMobile();
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
  </body>
</html>
