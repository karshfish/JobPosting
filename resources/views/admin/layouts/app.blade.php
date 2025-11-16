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
    /* Collapsible sidebar behavior on desktop (match employer layout) */
    .sidebar.collapsed { width: 5rem; }
    .sidebar .sidebar-label { display: inline; font-weight: 600; }
    .sidebar.collapsed .sidebar-label { display: none; }
    .sidebar.collapsed .logo-text { display: none; }
    .sidebar .nav-icon { width: 1.5rem; height: 1.5rem; }
    /* Make icons larger when sidebar is collapsed */
    .sidebar.collapsed .nav-icon { width: 3rem; height: 1rem; }
    .sidebar.collapsed .sidebar-footer { display: none; }
    /* Micro animations */
    @keyframes fade-in { from { opacity:.0; transform: translateY(8px) } to { opacity:1; transform: none } }
    @keyframes scale-in { from { opacity:.0; transform: scale(.98) } to { opacity:1; transform: scale(1) } }
    .animate-fade-in { animation: fade-in .28s ease-out both; }
	    .animate-scale-in { animation: scale-in .18s ease-out both; }
	    @media (min-width: 768px) {
	      .main-with-sidebar-expanded { margin-left: 16rem; }
	      .main-with-sidebar-collapsed { margin-left: 5rem; }
	    }
	  </style>
  </head>
<body class="min-h-dvh bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100">
  <div class="min-h-dvh flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar fixed inset-y-0 left-0 z-40 w-64 -translate-x-full md:translate-x-0 bg-white dark:bg-slate-900/50 border-r border-slate-200 dark:border-slate-800 flex flex-col transition-transform duration-150 ease-in-out">
      <div class="h-16 px-4 md:px-6 flex items-center justify-between border-b border-slate-200 dark:border-slate-800">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 min-w-0">
          <img src="{{ asset('assets/logo.jpg') }}" alt="HireHup logo" class="h-8 w-auto rounded">
          <span class="logo-text text-xl font-extrabold tracking-tight text-gray-800 dark:text-slate-100 truncate">
            <span class="text-indigo-600">Hire</span>
            <span class="dark:text-white">Hup</span>
          </span>
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
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="nav-icon w-5 h-5 transition-transform duration-150 ease-out group-hover:scale-110 group-hover:translate-x-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.47 3.84a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 1-1.06 1.06l-.9-.9V19.5A2.25 2.25 0 0 1 17.25 21h-2.5a.75.75 0 0 1-.75-.75v-3.5a1.25 1.25 0 0 0-1.25-1.25h-1a1.25 1.25 0 0 0-1.25 1.25v3.5a.75.75 0 0 1-.75.75h-2.5A2.25 2.25 0 0 1 3.75 19.5v-6.81l-.9.9a.75.75 0 1 1-1.06-1.06l8.68-8.69Z"/></svg>
          <span class="sidebar-label">Dashboard</span>
        </a>
        <a href="{{ route('admin.jobs.index') }}"
           class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.jobs.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50' }}">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="nav-icon w-5 h-5 transition-transform duration-150 ease-out group-hover:scale-110 group-hover:translate-x-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75A2.25 2.25 0 0 1 11.25 1.5h1.5A2.25 2.25 0 0 1 15 3.75V6h3.75A2.25 2.25 0 0 1 21 8.25v9A2.25 2.25 0 0 1 18.75 19.5H5.25A2.25 2.25 0 0 1 3 17.25v-9A2.25 2.25 0 0 1 5.25 6H9V3.75Zm1.5 0V6h3V3.75a.75.75 0 0 0-.75-.75h-1.5a.75.75 0 0 0-.75.75Z"/></svg>
          <span class="sidebar-label">Jobs</span>
        </a>
        <a href="{{ route('admin.applications.index') }}"
           class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.applications.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50' }}">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="nav-icon w-5 h-5 transition-transform duration-150 ease-out group-hover:scale-110 group-hover:translate-x-0.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 8.25V7.5A2.25 2.25 0 0 1 6 5.25h12A2.25 2.25 0 0 1 20.25 7.5v.75m-16.5 0h16.5m-16.5 0 1.5 8.25A2.25 2.25 0 0 0 7.5 18.75h9a2.25 2.25 0 0 0 2.25-1.95l1.5-8.25" />
          </svg>
          <span class="sidebar-label">Applications</span>
        </a>
        <a href="{{ route('admin.categories.index') }}"
           class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50' }}">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="nav-icon w-5 h-5 transition-transform duration-150 ease-out group-hover:scale-110 group-hover:translate-x-0.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 4.5h6v6h-6v-6zM13.5 4.5h6v6h-6v-6zM4.5 13.5h6v6h-6v-6zM13.5 13.5h6v6h-6v-6z" />
          </svg>
          <span class="sidebar-label">Categories</span>
        </a>
        <!-- Companies nav removed from admin -->
        <a href="{{ route('admin.users.index') }}"
           class="transition-base group flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50' }}">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="nav-icon w-5 h-5 transition-transform duration-150 ease-out group-hover:scale-110 group-hover:translate-x-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 8.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM4.5 18.75a6.75 6.75 0 0 1 13.5 0V20a.75.75 0 0 1-.75.75H5.25A.75.75 0 0 1 4.5 20v-1.25Z"/></svg>
          <span class="sidebar-label">Users</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
                  class="transition-base group flex items-center gap-3 w-full text-left px-3 py-2 rounded-md text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.5"
                 class="nav-icon w-5 h-5 transition-transform duration-150 ease-out group-hover:scale-110 group-hover:translate-x-0.5">
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
        @if(auth()->check())
          <div class="flex items-center gap-3 mb-3">
            <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300 text-xs font-semibold">
              {{ strtoupper(mb_substr(auth()->user()->name ?: 'A', 0, 1)) }}
            </div>
            <div class="min-w-0">
              <p class="text-[11px] uppercase tracking-wide text-slate-400 dark:text-slate-500">Signed in as</p>
              <p class="text-sm font-medium text-slate-800 dark:text-slate-100 truncate">
                {{ auth()->user()->name ?: 'Admin' }}
              </p>
              <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate">
                {{ auth()->user()->email ?: 'No email set' }}
              </p>
            </div>
          </div>

          <div class="flex items-center gap-2 text-[11px]">
            <span class="inline-flex items-center px-2 py-0.5 font-medium rounded-full border border-slate-200 dark:border-slate-700 bg-white/70 dark:bg-slate-800 text-slate-700 dark:text-slate-200">
              Role: {{ auth()->user()->role ?: 'none' }}
            </span>
          </div>
        @endif
        <div class="mt-3 text-[11px] text-slate-500 dark:text-slate-400">&copy; 2025 HireHup</div>
      </div>
    </aside>
    <!-- Backdrop for mobile -->
    <div id="sidebar-backdrop" class="hidden fixed inset-0 z-30 bg-black/30 md:hidden" aria-hidden="true"></div>

    <!-- Main -->
    <div id="admin-main" class="flex-1 flex flex-col min-w-0 main-with-sidebar-expanded">
      <header class="sticky top-0 z-30 h-16 bg-white dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-800 px-4 md:px-6 flex items-center justify-between shadow-sm animate-scale-in">
          <div class="flex items-center gap-2">
            <!-- Sidebar toggler -->
            <button id="sidebar-open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-base" aria-label="Open sidebar">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
              </svg>
            </button>
            <div class="flex items-center space-x-2">
              <img src="{{ asset('assets/logo.jpg') }}" alt="HireHup logo" class="h-8 w-auto rounded">
              <span class="text-2xl font-extrabold tracking-tight text-gray-800 dark:text-slate-100">
                <span class="text-indigo-600">Hire</span><span class="dark:text-white">Hup</span>
              </span>
            </div>
          </div>
        <div class="flex items-center gap-3">
          <button id="theme-toggle" type="button" class="transition-base inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50 text-sm">
            <span class="theme-toggle-light hidden">Light</span>
            <span class="theme-toggle-dark hidden">Dark</span>
          </button>
          <!-- Header logout removed; using sidebar logout -->
          <div class="text-sm text-slate-500 dark:text-slate-400">@yield('page-actions')</div>
        </div>
      </header>

      <main class="p-4 md:p-6 max-w-7xl mx-auto w-full animate-fade-in">
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
      const main = document.getElementById('admin-main');
      const openBtn = document.getElementById('sidebar-open');
      const closeBtn = document.getElementById('sidebar-close');
      const backdrop = document.getElementById('sidebar-backdrop');
      const mq = window.matchMedia('(min-width: 768px)'); // Tailwind md

      const setMainMargin = (collapsed) => {
        if (!main) return;
        main.classList.toggle('main-with-sidebar-expanded', !collapsed);
        main.classList.toggle('main-with-sidebar-collapsed', collapsed);
      };

      const applyCollapsed = () => {
        if (!mq.matches) return; // Only on desktop
        const collapsed = localStorage.getItem('sidebar-collapsed') === '1';
        sidebar.classList.toggle('collapsed', collapsed);
        setMainMargin(collapsed);
      };

      const openMobile = () => { sidebar.classList.remove('-translate-x-full'); backdrop.classList.remove('hidden'); };
      const closeMobile = () => { sidebar.classList.add('-translate-x-full'); backdrop.classList.add('hidden'); };

      const toggle = () => {
        if (mq.matches) {
          const collapsed = sidebar.classList.toggle('collapsed');
          localStorage.setItem('sidebar-collapsed', collapsed ? '1' : '0');
          setMainMargin(collapsed);
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
          if (main) {
            main.classList.remove('main-with-sidebar-expanded', 'main-with-sidebar-collapsed');
          }
        }
      });

      // Init
      applyCollapsed();
    })();
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	  <script>
	    (function () {
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
          + validationErrors.map(function (e) { return '<li>' + e + '</li>'; }).join('')
          + '</ul>';
	        Swal.fire({
	          icon: 'error',
	          title: 'There were some problems with your input:',
	          html: html,
	          confirmButtonColor: '#ef4444'
	        });
	      }

	      const deleteForms = document.querySelectorAll('.js-user-delete-form');
	      deleteForms.forEach(function (form) {
	        form.addEventListener('submit', function (e) {
	          e.preventDefault();
	          Swal.fire({
	            title: 'Delete this user?',
	            text: 'This action cannot be undone.',
	            icon: 'warning',
	            showCancelButton: true,
	            confirmButtonColor: '#ef4444',
	            cancelButtonColor: '#6b7280',
	            confirmButtonText: 'Yes, delete',
	            cancelButtonText: 'Cancel'
	          }).then(function (result) {
	            if (result.isConfirmed) {
	              form.submit();
	            }
	          });
	        });
	      });
	    })();
	  </script>
  </body>
</html>
