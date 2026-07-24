<div class="mb-4">
    <label class="field-label">
        Conducteur
    </label>

    <select
        name="id_employe"
        class="field-input">

        <option value="">-- Choisir un conducteur --</option>

        @foreach($employes as $employe)
            <option
                value="{{ $employe->id_employe }}"
                {{ old('id_employe', $trajet->id_employe ?? '') == $employe->id_employe ? 'selected' : '' }}>
                {{ $employe->nom }}
            </option>
        @endforeach

    </select>

    @error('id_employe')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="field-label">
        Ville de départ
    </label>

    <input
        type="text"
        name="ville_depart"
        value="{{ old('ville_depart', $trajet->ville_depart ?? '') }}"
        class="field-input">

    @error('ville_depart')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="field-label">
        Ville d'arrivée
    </label>

    <input
        type="text"
        name="ville_arrivee"
        value="{{ old('ville_arrivee', $trajet->ville_arrivee ?? '') }}"
        class="field-input">

    @error('ville_arrivee')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="field-label">
        Horaire
    </label>

    <input
        type="datetime-local"
        name="horaire"
        value="{{ old('horaire', isset($trajet) ? \Carbon\Carbon::parse($trajet->horaire)->format('Y-m-d\TH:i') : '') }}"
        class="field-input">

    @error('horaire')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="field-label">
        Places disponibles
    </label>

    <input
        type="number"
        name="places_disponibles"
        min="1"
        value="{{ old('places_disponibles', $trajet->places_disponibles ?? '') }}"
        class="field-input">

    @error('places_disponibles')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

<div class="mb-6">
    <label class="field-label">
        Jours de récurrence
    </label>

    <input
        type="text"
        name="jours_recurrence"
        value="{{ old('jours_recurrence', $trajet->jours_recurrence ?? '') }}"
        class="field-input">

    @error('jours_recurrence')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

<div class="flex gap-3">

    <button
        type="submit"
        class="btn-accent">

        Enregistrer

    </button>

    <a
        href="{{ route('trajets.index') }}"
        class="btn-secondary">

        Retour

    </a>

</div>
