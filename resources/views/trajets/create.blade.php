<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Nouveau trajet
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                <form action="{{ route('trajets.store') }}" method="POST">

                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">
                            Conducteur
                        </label>

                        <select
                            name="id_employe"
                            class="w-full rounded border-gray-300">

                            <option value="">-- Choisir un conducteur --</option>

                            @foreach($employes as $employe)
                                <option value="{{ $employe->id_employe }}"
                                    {{ old('id_employe') == $employe->id_employe ? 'selected' : '' }}>
                                    {{ $employe->nom }}
                                </option>
                            @endforeach

                        </select>

                        @error('id_employe')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">
                            Ville de départ
                        </label>

                        <input
                            type="text"
                            name="ville_depart"
                            value="{{ old('ville_depart') }}"
                            class="w-full rounded border-gray-300">

                        @error('ville_depart')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">
                            Ville d'arrivée
                        </label>

                        <input
                            type="text"
                            name="ville_arrivee"
                            value="{{ old('ville_arrivee') }}"
                            class="w-full rounded border-gray-300">

                        @error('ville_arrivee')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">
                            Horaire
                        </label>

                        <input
                            type="datetime-local"
                            name="horaire"
                            value="{{ old('horaire') }}"
                            class="w-full rounded border-gray-300">

                        @error('horaire')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">
                            Places disponibles
                        </label>

                        <input
                            type="number"
                            name="places_disponibles"
                            value="{{ old('places_disponibles') }}"
                            min="1"
                            class="w-full rounded border-gray-300">

                        @error('places_disponibles')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold">
                            Jours de récurrence
                        </label>

                        <input
                            type="text"
                            name="jours_recurrence"
                            value="{{ old('jours_recurrence') }}"
                            placeholder="Ex : Lundi, Mardi, Vendredi"
                            class="w-full rounded border-gray-300">

                        @error('jours_recurrence')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
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
                            class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded">

                            Annuler

                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>