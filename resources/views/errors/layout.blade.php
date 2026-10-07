<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Wystąpił błąd') - {{ config('app.name', 'Peqursor') }}
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800,900" rel="stylesheet">

    <!-- Styles / Scripts -->
    @if ( file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')) )

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    @else

        <style>
            body {
                font-family:
                    'Instrument Sans',
                    ui-sans-serif,
                    system-ui,
                    sans-serif; }
        </style>

    @endif

</head>


<body class="background text-gray-900 min-h-screen">

    <x-banner />

    <main class="flex items-center justify-center px-6 py-12 ">

        <div class="w-full max-w-2xl text-center bg-gray-100 px-6 py-6 rounded-2xl shadow-lg">

                <div class="text-4xl font-black tracking-wider text-gray-900">
                    Błąd
                </div>

            <!-- Czerwona linia -->
            <div class="mx-auto mt-4 h-1 w-20 rounded-full bg-red-600"></div>

            <!-- Kod błędu -->
            <div class="mt-12 text-8xl font-black tracking-tight text-red-600 sm:text-9xl">
                @yield('code')
            </div>

            <!-- Tytuł -->
            <h1 class="mt-6 text-3xl font-bold text-gray-900 sm:text-4xl">
                @yield('heading')
            </h1>

            <!-- Opis -->
            <p class="mx-auto mt-4 max-w-xl text-base leading-7 text-gray-600">
                @yield('message')
            </p>

            <!-- Przyciski -->
            <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                @yield('actions')
            </div>

        </div>

    </main>

        <footer class="flex justify-center mt-8 text-sm text-gray-400">
            Peqursor Cinema
        </footer>
</body>

</html>
