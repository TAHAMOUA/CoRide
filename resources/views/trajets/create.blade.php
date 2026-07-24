@extends('layouts.coride')

@section('titre', 'Publier un trajet')

@section('contenu')
    <h1 class="text-2xl font-display font-semibold mb-6 text-paper">Publier un trajet</h1>

    <form method="POST" action="{{ route('trajets.store') }}" class="space-y-4 max-w-md card p-6">
        @csrf

        <div>
            <label class="field-label">Ville de depart</label>
            <input type="text" name="ville_depart" value="{{ old('ville_depart') }}" class="field-input">
        </div>

        <div>
            <label class="field-label">Ville d'arrivee</label>
            <input type="text" name="ville_arrivee" value="{{ old('ville_arrivee') }}" class="field-input">
        </div>

        <div>
            <label class="field-label">Horaire</label>
            <input type="datetime-local" name="horaire" value="{{ old('horaire') }}" class="field-input">
        </div>

        <div>
            <label class="field-label">Places disponibles</label>
            <input type="number" name="places_disponibles" min="1" max="8" value="{{ old('places_disponibles', 3) }}" class="field-input">
        </div>

        <div>
            <label class="field-label mb-1">Jours de recurrence</label>
            <div class="flex flex-wrap gap-3 text-sm text-ink-400">
                @foreach (['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'] as $jour)
                    <label class="flex items-center gap-1.5">
                        <input type="checkbox" name="jours_recurrence[]" value="{{ $jour }}"
                               class="rounded border-night-700 bg-night-800 text-route-500 focus:ring-route-500"
                               @checked(in_array($jour, old('jours_recurrence', [])))>
                        {{ ucfirst($jour) }}
                    </label>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn-accent">Publier le trajet</button>
    </form>
@endsection
