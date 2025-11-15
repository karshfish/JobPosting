<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            
        </div>
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
            })();
        </script>
    </body>
</html>
