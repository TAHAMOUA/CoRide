<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>CoRide &middot; {{ config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-paper antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-10 sm:pt-0 bg-night-950">
            <a href="/" class="flex items-center gap-2 font-display font-semibold text-2xl text-paper">
                <span class="route-dot"></span>
                Co<span class="text-route-400">Ride</span>
            </a>
            <p class="text-xs text-ink-400 mt-1 font-mono">Covoiturage entre collegues</p>

            <div class="w-full sm:max-w-md mt-8 px-6 py-8 card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>