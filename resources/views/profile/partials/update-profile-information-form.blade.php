<section>
    <header>
        <h2 class="text-lg font-semibold text-purple-800">
            Información del perfil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Actualiza la información de tu cuenta y tu correo electrónico.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Nombre" class="text-purple-700" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-purple-200 focus:border-purple-500 focus:ring-purple-500" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Correo electrónico" class="text-purple-700" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-purple-200 focus:border-purple-500 focus:ring-purple-500" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="phone" value="Teléfono de contacto" class="text-purple-700" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full border-purple-200 focus:border-purple-500 focus:ring-purple-500" :value="old('phone', $user->phone)" placeholder="Ej: +57 300..." />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="address" value="Dirección de residencia" class="text-purple-700" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full border-purple-200 focus:border-purple-500 focus:ring-purple-500" :value="old('address', $user->address)" placeholder="Calle 123 #45-67..." />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm text-gray-800">
                    Tu correo electrónico no está verificado.

                    <button form="send-verification" class="underline text-sm text-purple-600 hover:text-purple-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Haz clic aquí para reenviar el correo de verificación.
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600">
                        Se envió un nuevo enlace de verificación a tu correo electrónico.
                    </p>
                @endif
            </div>
        @endif

        <div>
            <x-primary-button>Guardar cambios</x-primary-button>
        </div>
    </form>
</section>
