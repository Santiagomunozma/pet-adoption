<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-purple-800">
            Eliminar cuenta
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Una vez eliminada tu cuenta, todos sus recursos y datos se borrarán de forma permanente. Antes de continuar, descarga cualquier información que quieras conservar.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Eliminar cuenta</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-purple-800">
                ¿Seguro que deseas eliminar tu cuenta?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Esta acción no se puede deshacer. Ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Contraseña" class="sr-only" />

                <x-password-input
                    id="password"
                    name="password"
                    class="mt-1 block w-full border-purple-200 focus:border-purple-500 focus:ring-purple-500"
                    placeholder="Contraseña"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancelar
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    Eliminar cuenta
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
