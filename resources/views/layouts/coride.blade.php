<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CoRide &middot; @yield('titre', 'Covoiturage entreprise')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">
    <header class="border-b border-night-800 bg-night-950/80 backdrop-blur sticky top-0 z-40">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('trajets.index') }}" class="flex items-center gap-2 font-display font-semibold text-lg text-paper">
                <span class="route-dot"></span>
                <span class="tracking-tight">Co<span class="text-route-400">Ride</span></span>
            </a>

            @auth
                <nav class="hidden sm:flex items-center gap-6 text-sm font-medium text-ink-400">
                    <a href="{{ route('trajets.index') }}" class="hover:text-paper transition {{ request()->routeIs('trajets.index') ? 'text-paper' : '' }}">Trajets</a>
                    <a href="{{ route('trajets.create') }}" class="hover:text-paper transition {{ request()->routeIs('trajets.create') ? 'text-paper' : '' }}">Publier</a>
                    <a href="{{ route('reservations.index') }}" class="hover:text-paper transition {{ request()->routeIs('reservations.*') ? 'text-paper' : '' }}">Mes reservations</a>
                    @if (auth()->user()->estConducteur())
                        <a href="{{ route('dashboard') }}" class="hover:text-paper transition {{ request()->routeIs('dashboard') ? 'text-paper' : '' }}">Tableau de bord</a>
                    @endif
                </nav>

                <div class="flex items-center gap-3">
                    <a href="{{ route('profile.edit') }}" class="hidden sm:flex items-center gap-2 text-sm text-ink-400 hover:text-paper transition">
                        <span class="h-7 w-7 rounded-full bg-route-900 text-route-300 flex items-center justify-center font-display font-semibold text-xs">
                            {{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}
                        </span>
                        {{ Str::of(auth()->user()->nom)->before(' ') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-ghost !px-3 !py-1.5 text-xs">Deconnexion</button>
                    </form>
                </div>
            @else
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="btn-ghost !px-3 !py-1.5 text-sm">Connexion</a>
                    <a href="{{ route('register') }}" class="btn-accent !px-4 !py-1.5 text-sm">Rejoindre CoRide</a>
                </div>
            @endauth
        </div>

        @auth
            <nav class="sm:hidden flex items-center gap-4 px-4 pb-3 text-xs font-medium text-ink-400 overflow-x-auto">
                <a href="{{ route('trajets.index') }}" class="shrink-0">Trajets</a>
                <a href="{{ route('trajets.create') }}" class="shrink-0">Publier</a>
                <a href="{{ route('reservations.index') }}" class="shrink-0">Reservations</a>
                @if (auth()->user()->estConducteur())
                    <a href="{{ route('dashboard') }}" class="shrink-0">Tableau de bord</a>
                @endif
                <a href="{{ route('profile.edit') }}" class="shrink-0">Profil</a>
            </nav>
        @endauth
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-10 w-full flex-1">
        @if (session('status'))
            <div class="mb-6 rounded-lg bg-route-900 text-route-300 border border-route-700 px-4 py-3 text-sm font-medium">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-rust-900 text-rust-300 border border-rust-700 px-4 py-3 text-sm">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @hasSection('header')
            <div class="mb-8">
                @yield('header')
            </div>
        @endif

        @yield('contenu')
    </main>

    <footer class="border-t border-night-800 py-6 mt-auto">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 flex items-center justify-between text-xs text-ink-400">
            <span class="font-mono">CoRide &middot; MobiliTech</span>
            <span>Covoiturage entre collegues, sans friction.</span>
        </div>
    </footer>
</body>
</html>