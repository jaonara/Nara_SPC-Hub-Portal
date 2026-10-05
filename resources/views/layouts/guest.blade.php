<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}?v=2">
        <link rel="apple-touch-icon" href="{{ asset('images/logo.jpeg') }}?v=2">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center bg-[#f7f3ed] px-4 py-10">
            <div class="mb-6 text-center">
                <a href="/" class="inline-flex flex-col items-center gap-3">
                    <x-application-logo class="h-20 w-20" />
                    <span class="text-lg font-semibold tracking-wide text-[#6B141A]">SPC Hub</span>
                    <span class="text-xs text-gray-500">Student Portal</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md border border-gray-200 bg-white px-6 py-5 shadow-sm sm:px-8 sm:py-7">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
