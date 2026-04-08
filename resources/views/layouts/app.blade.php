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
@if(session('success'))
    <div id="toast"
        class="fixed bottom-6 right-6 z-[9999] bg-white border border-green-200 shadow-lg rounded-xl px-4 py-3 flex items-center gap-3">

        <div class="text-green-600 text-lg">✔</div>

        <div class="text-sm text-gray-700">
            {{ session('success') }}
        </div>

        <button onclick="document.getElementById('toast').remove()" class="text-gray-400 hover:text-gray-700 ml-2">
            ✕
        </button>
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) toast.remove();
        }, 3000);
    </script>
@endif

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
</body>

</html>