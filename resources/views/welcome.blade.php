<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPC Hub | Portal</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpeg') }}?v=2">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f7f3ed] text-gray-950">
    <main class="relative flex min-h-screen flex-col overflow-hidden">
        <div class="spc-campus-portal absolute inset-0 bg-cover bg-center"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-transparent to-black/45"></div>

        <nav class="relative z-10 mx-auto flex w-full max-w-7xl items-center justify-between px-5 py-5 sm:px-8 lg:px-10">
            <a href="{{ url('/') }}" class="flex items-center gap-3 text-white">
                <x-application-logo class="h-11 w-11" />
                <span>
                    <span class="block text-base font-semibold tracking-wide">SPC Hub</span>
                    <span class="block text-xs text-white/70">St. Peter's College</span>
                </span>
            </a>
            <div class="flex items-center gap-2 sm:gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="border border-white/50 px-4 py-2 text-sm font-medium text-white transition hover:bg-white hover:text-[#6B141A]">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-white transition hover:text-[#F7F1E8]">Log in</a>
                    <a href="{{ route('register') }}" class="bg-[#F7F1E8] px-4 py-2 text-sm font-semibold text-[#6B141A] transition hover:bg-white">Create account</a>
                @endauth
            </div>
        </nav>

        <section class="relative z-10 mx-auto flex w-full max-w-7xl flex-1 items-center px-5 py-16 sm:px-8 lg:px-10">
            <div class="max-w-2xl text-white">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-[#F7F1E8]">The SPC student portal</p>
                <h1 class="mt-5 text-5xl font-semibold tracking-tight sm:text-7xl">Your campus, connected.</h1>
                <p class="mt-6 max-w-xl text-base leading-7 text-white/85 sm:text-lg">Buy and sell with fellow students, report lost and found items, and keep conversations in one trusted SPC community.</p>
                <div class="mt-9 flex flex-wrap gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-[#F7F1E8] px-5 py-3 text-sm font-semibold text-[#6B141A] transition hover:bg-white">Open SPC Hub &rarr;</a>
                    @else
                        <a href="{{ route('register') }}" class="bg-[#F7F1E8] px-5 py-3 text-sm font-semibold text-[#6B141A] transition hover:bg-white">Join SPC Hub &rarr;</a>
                        <a href="{{ route('login') }}" class="border border-white/60 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">Sign in</a>
                    @endauth
                </div>
            </div>
        </section>

        <section class="relative z-10 border-t border-white/20 bg-[#2d060a]/55 px-5 py-6 text-white backdrop-blur-sm sm:px-8 lg:px-10">
            <div class="mx-auto grid max-w-7xl gap-5 text-sm sm:grid-cols-3">
                <div><p class="font-semibold">Buy &amp; Sell</p><p class="mt-1 text-white/65">Find useful items around campus.</p></div>
                <div><p class="font-semibold">Lost &amp; Found</p><p class="mt-1 text-white/65">Help return what matters.</p></div>
                <div><p class="font-semibold">Private messages</p><p class="mt-1 text-white/65">Connect directly and respectfully.</p></div>
            </div>
        </section>
    </main>
</body>
</html>
