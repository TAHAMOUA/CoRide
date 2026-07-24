@extends('layouts.coride')

@section('titre', 'Mes reservations')

@section('contenu')
    <h1 class="text-2xl font-display font-semibold mb-6 text-paper">Mes reservations</h1>

    <div class="grid gap-3">
        @forelse ($reservations as $reservation)
            <div class="card p-4 flex items-center justify-between">
                <div>
                    <p class="font-medium text-paper">
                        {{ $reservation->trajet->ville_depart }} &rarr; {{ $reservation->trajet->ville_arrivee }}
                    </p>
                    <p class="text-sm text-ink-400 stat-time">
                        {{ $reservation->trajet->horaire->format('d/m/Y H:i') }} &middot;
                        Conducteur : {{ $reservation->trajet->conducteur->nom }}
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <span @class([
                        'badge',
                        'badge-pending' => $reservation->statut === \App\Enums\StatutReservation::EnAttente,
                        'badge-confirmed' => $reservation->statut === \App\Enums\StatutReservation::Confirmee,
                        'badge-refused' => $reservation->statut === \App\Enums\StatutReservation::Refusee,
                        'badge-cancelled' => $reservation->statut === \App\Enums\StatutReservation::Annulee,
                    ])>
                        {{ $reservation->statut->label() }}
                    </span>

                    @if (in_array(\App\Enums\StatutReservation::Annulee, $reservation->statut->transitionsAutorisees(), true))
                        <form method="POST" action="{{ route('reservations.update-status', $reservation) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="statut" value="annulee">
                            <button type="submit" class="text-sm text-rust-400 underline decoration-rust-700 hover:decoration-rust-400">Annuler</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-ink-400">Vous n'avez aucune reservation pour le moment.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $reservations->links() }}</div>
@endsection
