<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Liste des trajets
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('trajets.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Nouveau trajet
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">

                <table class="min-w-full">

                    <thead class="bg-gray-100 dark:bg-gray-700">

                    <tr>

                        <th class="px-4 py-3 text-left">
                            Conducteur
                        </th>

                        <th class="px-4 py-3 text-left">
                            Départ
                        </th>

                        <th class="px-4 py-3 text-left">
                            Arrivée
                        </th>

                        <th class="px-4 py-3 text-left">
                            Horaire
                        </th>

                        <th class="px-4 py-3 text-left">
                            Places
                        </th>

                        <th class="px-4 py-3 text-center">
                            Actions
                        </th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($trajets as $trajet)

                        <tr class="border-t">

                            <td class="px-4 py-3">
                                {{ $trajet->employe->nom }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $trajet->ville_depart }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $trajet->ville_arrivee }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $trajet->horaire }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $trajet->places_disponibles }}
                            </td>

                            <td class="px-4 py-3 text-center space-x-2">

                                <a href="{{ route('trajets.show', $trajet) }}"
                                   class="text-blue-600">
                                    Voir
                                </a>

                                <a href="{{ route('trajets.edit', $trajet) }}"
                                   class="text-yellow-600">
                                    Modifier
                                </a>

                                <form action="{{ route('trajets.destroy', $trajet) }}"
                                      method="POST"
                                      class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Supprimer ce trajet ?')"
                                        class="text-red-600">
                                        Supprimer
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-5">

                                Aucun trajet disponible.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</x-app-layout>