<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nom -->
        <div>
            <x-input-label for="nom" :value="__('Nom')" />
            <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
        </div>

        <!-- Email professionnel -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email professionnel')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Entreprise -->
        <div class="mt-4">
            <x-input-label for="entreprise_id" :value="__('Entreprise')" />
            <select id="entreprise_id" name="entreprise_id" required
                    class="block mt-1 w-full bg-night-800 border-night-700 text-paper focus:border-route-500 focus:ring-route-500 rounded-md shadow-sm">
                <option value="">-- Choisir --</option>
                @foreach ($entreprises as $entreprise)
                    <option value="{{ $entreprise->id }}" @selected(old('entreprise_id') == $entreprise->id)>
                        {{ $entreprise->nom }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('entreprise_id')" class="mt-2" />
        </div>

        <!-- Ville de residence -->
        <div class="mt-4">
            <x-input-label for="ville_residence" :value="__('Ville de residence')" />
            <x-text-input id="ville_residence" class="block mt-1 w-full" type="text" name="ville_residence" :value="old('ville_residence')" required />
            <x-input-error :messages="$errors->get('ville_residence')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select id="role" name="role" required
                    class="block mt-1 w-full bg-night-800 border-night-700 text-paper focus:border-route-500 focus:ring-route-500 rounded-md shadow-sm">
                <option value="">-- Choisir --</option>
                @foreach (\App\Enums\RoleEmploye::cases() as $role)
                    <option value="{{ $role->value }}" @selected(old('role') === $role->value)>
                        {{ $role->label() }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-ink-400 hover:text-paper rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-night-950 focus:ring-route-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
