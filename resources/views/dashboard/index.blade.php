@extends('layouts.coride')

@section('titre', 'Tableau de bord conducteur')

@section('contenu')
    <h1 class="text-2xl font-display font-semibold mb-6 text-paper">Tableau de bord conducteur</h1>

    @if ($demandesEnAttente->isNotEmpty())
        <div class="mb-6 rounded-lg border border-amber-600/40 bg-amber-900 p-4">
            <p class="font-medium text-amber-300 mb-2">
                {{ $demandesEnAttente->count() }} demande(s) en attente de votre reponse
            </p>
        </div>
    @endif

    <div class="grid gap-4">
        @foreach ($trajets as $trajet)
            <div class="card p-4">
                <div class="flex justify-between items-center">
                    <span class="font-medium text-paper">{{ $trajet->ville_depart }} &rarr; {{ $trajet->ville_arrivee }}</span>
                    <span class="text-sm text-ink-400 stat-time">{{ $trajet->horaire->format('d/m/Y H:i') }}</span>
                </div>
                <p class="text-sm text-ink-400 mb-2">
                    {{ $trajet->placesRestantes() }} place(s) restante(s) sur {{ $trajet->places_disponibles }}
                </p>

                @forelse ($trajet->reservations as $reservation)
                    <div class="flex items-center justify-between border-t border-night-700 py-2 text-sm">
                        <span class="text-paper">{{ $reservation->passager->nom }} &middot; {{ $reservation->statut->label() }}</span>

                        @if ($reservation->statut === \App\Enums\StatutReservation::EnAttente)
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('reservations.update-status', $reservation) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="statut" value="confirmee">
                                    <button class="text-route-400 underline decoration-route-700 hover:decoration-route-400">Confirmer</button>
                                </form>
                                <form method="POST" action="{{ route('reservations.update-status', $reservation) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="statut" value="refusee">
                                    <button class="text-rust-400 underline decoration-rust-700 hover:decoration-rust-400">Refuser</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-ink-400/70 border-t border-night-700 pt-2">Aucune reservation pour ce trajet.</p>
                @endforelse
            </div>
        @endforeach
    </div>
@endsection
