<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Conducteur
    </label>

    <select
        name="id_employe"
        class="w-full mt-1 rounded-md border-gray-300 shadow-sm">

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
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Ville de départ
    </label>

    <input
        type="text"
        name="ville_depart"
        value="{{ old('ville_depart', $trajet->ville_depart ?? '') }}"
        class="w-full mt-1 rounded-md border-gray-300 shadow-sm">

    @error('ville_depart')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Ville d'arrivée
    </label>

    <input
        type="text"
        name="ville_arrivee"
        value="{{ old('ville_arrivee', $trajet->ville_arrivee ?? '') }}"
        class="w-full mt-1 rounded-md border-gray-300 shadow-sm">

    @error('ville_arrivee')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Horaire
    </label>

    <input
        type="datetime-local"
        name="horaire"
        value="{{ old('horaire', isset($trajet) ? \Carbon\Carbon::parse($trajet->horaire)->format('Y-m-d\TH:i') : '') }}"
        class="w-full mt-1 rounded-md border-gray-300 shadow-sm">

    @error('horaire')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Places disponibles
    </label>

    <input
        type="number"
        name="places_disponibles"
        min="1"
        value="{{ old('places_disponibles', $trajet->places_disponibles ?? '') }}"
        class="w-full mt-1 rounded-md border-gray-300 shadow-sm">

    @error('places_disponibles')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Jours de récurrence
    </label>

    <input
        type="text"
        name="jours_recurrence"
        value="{{ old('jours_recurrence', $trajet->jours_recurrence ?? '') }}"
        class="w-full mt-1 rounded-md border-gray-300 shadow-sm">

    @error('jours_recurrence')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

<div class="flex gap-3">

    <button
        type="submit"
        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded">

        Enregistrer

    </button>

    <a
        href="{{ route('trajets.index') }}"
        class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded">

        Retour

    </a>

</div>