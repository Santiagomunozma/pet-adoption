<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-purple-800 leading-tight">
            Mi perfil
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow-md sm:rounded-xl border border-purple-100">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow-md sm:rounded-xl border border-purple-100">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow-md sm:rounded-xl border border-purple-100">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @if (session('status') === 'profile-updated')
            <script>
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Perfil actualizado correctamente.',
                    icon: 'success',
                    confirmButtonColor: '#16a34a'
                });
            </script>
        @elseif (session('status') === 'password-updated')
            <script>
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Contraseña actualizada correctamente.',
                    icon: 'info',
                    confirmButtonColor: '#16a34a'
                });
            </script>
        @endif
    @endpush
</x-app-layout>
