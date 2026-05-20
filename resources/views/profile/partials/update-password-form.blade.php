<section>
    <header>
        <h2 class="text-lg font-semibold text-purple-800">
            Actualizar contraseña
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Usa una contraseña larga y segura para proteger tu cuenta.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" value="Contraseña actual" class="text-purple-700" />
            <x-password-input id="update_password_current_password" name="current_password" class="mt-1 block w-full border-purple-200 focus:border-purple-500 focus:ring-purple-500" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" value="Nueva contraseña" class="text-purple-700" />
            <x-password-input id="update_password_password" name="password" class="mt-1 block w-full border-purple-200 focus:border-purple-500 focus:ring-purple-500" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" value="Confirmar contraseña" class="text-purple-700" />
            <x-password-input id="update_password_password_confirmation" name="password_confirmation" class="mt-1 block w-full border-purple-200 focus:border-purple-500 focus:ring-purple-500" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-primary-button>Guardar contraseña</x-primary-button>
        </div>
    </form>
</section>
