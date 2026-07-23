<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Modifier un trajet
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                <form action="{{ route('trajets.update', $trajet) }}" method="POST">

                    @csrf
                    @method('PUT')

                    @include('trajets._form')

                </form>

            </div>

        </div>
    </div>
</x-app-layout>