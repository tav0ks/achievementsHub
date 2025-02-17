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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="mb-8">
                <a href="/" class="flex items-center gap-2">
                    <x-application-logo class="font-alegrayaSc text-5xl font-bold text-gray-800 dark:text-gray-200 hover:text-gray-700 dark:hover:text-gray-300 transition-colors" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-3 px-6 py-8 bg-white dark:bg-gray-800 shadow-none border border-gray-200 dark:border-gray-700 rounded-xl transition-all">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>