<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CoRide &middot; Covoiturage entre collegues</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-night-950 text-paper font-sans antialiased">

    <header class="max-w-5xl mx-auto px-6 h-20 flex items-center justify-between">
        <span class="flex items-center gap-2 font-display font-semibold text-lg">
            <span class="route-dot"></span>
            Co<span class="text-route-400">Ride</span>
        </span>
        <nav class="flex items-center gap-3">
            @auth
                <a href="{{ route('trajets.index') }}" class="btn-primary">Voir les trajets</a>
            @else
                <a href="{{ route('login') }}" class="btn-ghost !px-3 !py-1.5 text-sm">Connexion</a>
                <a href="{{ route('register') }}" class="btn-accent">Rejoindre CoRide</a>
            @endauth
        </nav>
    </header>

    <main class="max-w-5xl mx-auto px-6 pt-10 pb-24">
        <p class="eyebrow mb-4">MobiliTech &middot; mobilite d'entreprise</p>
        <h1 class="font-display text-4xl sm:text-6xl font-semibold tracking-tight max-w-2xl leading-[1.05]">
            Vos collegues font deja le meme trajet.
        </h1>
        <p class="mt-6 text-lg text-ink-400 max-w-xl">
            CoRide relie les salaries qui habitent des zones proches et vont
            au bureau aux memes horaires &mdash; avec une compatibilite
            expliquee par IA, pas juste un filtre par ville.
        </p>

        <div class="mt-8 flex items-center gap-4">
            @auth
                <a href="{{ route('trajets.index') }}" class="btn-primary">Voir les trajets disponibles</a>
            @else
                <a href="{{ route('register') }}" class="btn-primary">Creer mon compte entreprise</a>
                <a href="{{ route('login') }}" class="btn-link">J'ai deja un compte</a>
            @endauth
        </div>

        {{-- Signature element: a route line, echoing a real CoRide trajet card --}}
        <div class="mt-20 card p-6 sm:p-8 max-w-2xl">
            <p class="eyebrow mb-4">Exemple de trajet</p>
            <div class="route-line mb-3">
                <span class="route-dot"></span>
                <span class="flex-1"></span>
                <span class="route-dot route-dot--end"></span>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-display font-semibold text-lg">Beni Mellal &rarr; Casablanca</p>
                    <p class="text-sm text-ink-400 mt-1">Conducteur : Youssef A. &middot; lun, mer, ven</p>
                </div>
                <div class="text-right">
                    <p class="stat-time text-2xl font-semibold text-paper">07:45</p>
                    <span class="badge badge-confirmed mt-1">92/100 compatible</span>
                </div>
            </div>
        </div>

        <div class="mt-16 grid sm:grid-cols-3 gap-6">
            <div>
                <p class="font-mono text-xs text-route-400 mb-2">01</p>
                <h3 class="font-display font-semibold mb-1">Publiez ou cherchez</h3>
                <p class="text-sm text-ink-400">Un conducteur propose un trajet ; un passager cherche une place compatible.</p>
            </div>
            <div>
                <p class="font-mono text-xs text-route-400 mb-2">02</p>
                <h3 class="font-display font-semibold mb-1">Score explique par IA</h3>
                <p class="text-sm text-ink-400">Ville, horaires, recurrence &mdash; le score dit pourquoi ce trajet convient.</p>
            </div>
            <div>
                <p class="font-mono text-xs text-route-400 mb-2">03</p>
                <h3 class="font-display font-semibold mb-1">Reservez en un clic</h3>
                <p class="text-sm text-ink-400">Le conducteur confirme, refuse, ou vous annulez &mdash; tout est suivi.</p>
            </div>
        </div>
    </main>

    <footer class="border-t border-night-800 py-6">
        <div class="max-w-5xl mx-auto px-6 flex items-center justify-between text-xs text-ink-400">
            <span class="font-mono">CoRide &middot; MobiliTech</span>
            <span>Covoiturage entre collegues, sans friction.</span>
        </div>
    </footer>
</body>
</html>