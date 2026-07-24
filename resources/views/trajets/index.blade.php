@extends('layouts.coride')

@section('titre', 'Trajets disponibles')

@section('contenu')
    <h1 class="text-2xl font-display font-semibold mb-6 text-paper">Trajets disponibles</h1>

    <form method="GET" class="flex gap-2 mb-6">
        <input type="text" name="ville_depart" value="{{ request('ville_depart') }}"
               placeholder="Ville de depart" class="field-input max-w-[220px]">
        <input type="text" name="ville_arrivee" value="{{ request('ville_arrivee') }}"
               placeholder="Ville d'arrivee" class="field-input max-w-[220px]">
        <button type="submit" class="btn-accent !px-4 !py-1.5 text-sm">Filtrer</button>
    </form>

    <div class="grid gap-3">
        @forelse ($trajets as $trajet)
            <a href="{{ route('trajets.show', $trajet) }}" class="block card card-hover p-4">
                <div class="flex justify-between">
                    <span class="font-medium text-paper">{{ $trajet->ville_depart }} &rarr; {{ $trajet->ville_arrivee }}</span>
                    <span class="text-sm text-ink-400 stat-time">{{ $trajet->horaire->format('d/m/Y H:i') }}</span>
                </div>
                <div class="text-sm text-ink-400 mt-1">
                    Conducteur : {{ $trajet->conducteur->nom }} &middot;
                    {{ $trajet->placesRestantes() }} place(s) restante(s) sur {{ $trajet->places_disponibles }}
                </div>
            </a>
        @empty
            <p class="text-ink-400">Aucun trajet ne correspond a votre recherche.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $trajets->links() }}</div>
@endsection
