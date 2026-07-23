<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Détails du trajet
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                <div class="mb-4">
                    <strong>Conducteur :</strong>
                    {{ $trajet->employe->nom }}
                </div>

                <div class="mb-4">
                    <strong>Ville de départ :</strong>
                    {{ $trajet->ville_depart }}
                </div>

                <div class="mb-4">
                    <strong>Ville d'arrivée :</strong>
                    {{ $trajet->ville_arrivee }}
                </div>

                <div class="mb-4">
                    <strong>Horaire :</strong>
                    {{ \Carbon\Carbon::parse($trajet->horaire)->format('d/m/Y H:i') }}
                </div>

                <div class="mb-4">
                    <strong>Places disponibles :</strong>
                    {{ $trajet->places_disponibles }}
                </div>

                <div class="mb-6">
                    <strong>Jours de récurrence :</strong>
                    {{ $trajet->jours_recurrence }}
                </div>

                <div class="flex gap-3">

                    <a href="{{ route('trajets.edit', $trajet) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                        Modifier
                    </a>

                    <a href="{{ route('trajets.index') }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                        Retour
                    </a>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>