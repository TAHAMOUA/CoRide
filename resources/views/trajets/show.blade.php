@extends('layouts.coride')

@section('titre', 'Detail du trajet')

@section('contenu')
    <h1 class="text-2xl font-display font-semibold mb-2 text-paper">
        {{ $trajet->ville_depart }} &rarr; {{ $trajet->ville_arrivee }}
    </h1>
    <p class="text-ink-400 mb-1">Conducteur : {{ $trajet->conducteur->nom }}</p>
    <p class="text-ink-400 mb-1 stat-time">Horaire : {{ $trajet->horaire->format('d/m/Y H:i') }}</p>
    <p class="text-ink-400 mb-1">
        Jours de recurrence :
        {{ $trajet->jours_recurrence ? implode(', ', $trajet->jours_recurrence) : 'ponctuel' }}
    </p>
    <p class="text-ink-400 mb-6">
        Places restantes : {{ $trajet->placesRestantes() }} / {{ $trajet->places_disponibles }}
    </p>

    @auth
        @if (! $estConducteurDuTrajet && auth()->user()->estPassager())
            {{-- Le score IA n'est calcule qu'a la demande explicite du passager. --}}
            <form method="GET" class="mb-4 flex items-end gap-2">
                <input type="hidden" name="evaluer" value="1">
                <div>
                    <label class="field-label">Horaire souhaite (optionnel)</label>
                    <input type="time" name="horaire_souhaite" value="{{ request('horaire_souhaite') }}"
                           class="field-input text-sm">
                </div>
                <button type="submit" class="btn-secondary text-sm">
                    Voir la compatibilite IA
                </button>
            </form>

            @if ($erreurIA)
                <div class="mb-4 rounded-lg border border-rust-700 bg-rust-900 p-4 text-sm text-rust-300">
                    {{ $erreurIA }}
                </div>
            @endif

            @if ($compatibilite)
                <div class="mb-4 card p-4">
                    <div class="flex items-center justify-between">
                        <span class="eyebrow">Score de compatibilite</span>
                        <span class="text-xl font-display font-bold text-route-400">{{ $compatibilite->score }}/100</span>
                    </div>
                    <p class="text-sm text-paper mt-2">{{ $compatibilite->justification }}</p>
                    @if ($compatibilite->horaireSuggere)
                        <p class="text-sm text-ink-400 mt-1">
                            Horaire suggere : {{ $compatibilite->horaireSuggere }}
                        </p>
                    @endif
                </div>
            @endif

            @if ($trajet->aDesPlacesDisponibles())
                <form method="POST" action="{{ route('reservations.store', $trajet) }}">
                    @csrf
                    <button type="submit" class="btn-accent">
                        Reserver ce trajet
                    </button>
                </form>
            @else
                <p class="text-rust-400 font-medium">Ce trajet est complet.</p>
            @endif
        @endif
    @else
        <p><a href="{{ route('login') }}" class="btn-link">Connectez-vous</a> pour reserver.</p>
    @endauth
@endsection
