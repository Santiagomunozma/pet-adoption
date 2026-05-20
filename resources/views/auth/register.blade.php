<x-guest-layout>
    <h1 class="text-xl font-semibold text-purple-800 mb-6">Crear cuenta</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" value="Nombre" class="text-purple-700" />
            <x-text-input id="name" class="block mt-1 w-full border-purple-200 focus:border-purple-500 focus:ring-purple-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" value="Correo electrónico" class="text-purple-700" />
            <x-text-input id="email" class="block mt-1 w-full border-purple-200 focus:border-purple-500 focus:ring-purple-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Contraseña" class="text-purple-700" />

            <x-password-input id="password" name="password" class="block mt-1 w-full border-purple-200 focus:border-purple-500 focus:ring-purple-500"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmar contraseña" class="text-purple-700" />

            <x-password-input id="password_confirmation" name="password_confirmation" class="block mt-1 w-full border-purple-200 focus:border-purple-500 focus:ring-purple-500"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-purple-600 hover:text-purple-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" href="{{ route('login') }}">
                ¿Ya tienes cuenta?
            </a>

            <x-primary-button class="ms-4 bg-purple-600 hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 focus:ring-purple-500">
                Registrarse
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
