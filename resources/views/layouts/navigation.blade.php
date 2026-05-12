<nav x-data="{ open: false, openMenu: false }" class="bg-white border-b border-purple-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center gap-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 5.5A3.5 3.5 0 108.5 9 3.5 3.5 0 0012 5.5zM4.5 12a3 3 0 10-3 3 3 3 0 003-3zm15 0a3 3 0 10-3 3 3 3 0 003-3zm-9.5 4a5.5 5.5 0 00-7.07 1.83 1.5 1.5 0 00.7 2.15c2.39 1.19 5.3 1.52 7.87.52a1.5 1.5 0 00.7-2.15A5.5 5.5 0 0010 16zm4-4a3.5 3.5 0 10-3.5-3.5A3.5 3.5 0 0014 12z"></path>
                        </svg>
                        <span class="font-black text-purple-700 text-lg hidden md:block">Peluditos en Red</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('📊 Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('especies.index')" :active="request()->routeIs('especies.index')">
                        {{ __('🦴 Especies') }}
                    </x-nav-link>
                    <x-nav-link :href="route('mascotas.index')" :active="request()->routeIs('mascotas.index')">
                        {{ __('🐾 Mascotas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('quienes.somos')" :active="request()->routeIs('quienes.somos')">
                        {{ __('🤝 Quiénes Somos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('contacto')" :active="request()->routeIs('contacto')">
                        {{ __('📞 Contacto') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative">
                    <button @click="openMenu = !openMenu" @click.outside="openMenu = false" class="inline-flex items-center px-3 py-2 border border-purple-200 text-sm leading-4 font-medium rounded-md text-purple-700 bg-white hover:text-purple-900 hover:bg-purple-50 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4 text-purple-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="openMenu" 
                         x-cloak
                         style="display: none;"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 z-50 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-2">
                        
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-purple-700 hover:bg-purple-50 transition">
                            ⚙️ Mi Perfil Profesional
                        </a>

                        <div class="border-t border-purple-100 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 font-bold hover:bg-red-50 transition">
                                🚪 Cerrar Sesión Segura
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-purple-400 hover:text-purple-600 hover:bg-purple-50 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-purple-50 border-t border-purple-100">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('📊 Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('especies.index')" :active="request()->routeIs('especies.index')">
                {{ __('🦴 Especies') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('mascotas.index')" :active="request()->routeIs('mascotas.index')">
                {{ __('🐾 Mascotas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('quienes.somos')" :active="request()->routeIs('quienes.somos')">
                {{ __('🤝 Quiénes Somos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contacto')" :active="request()->routeIs('contacto')">
                {{ __('📞 Contacto') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-purple-200">
            <div class="px-4">
                <div class="font-bold text-base text-purple-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-purple-700 font-medium">
                    {{ __('⚙️ Editar Perfil') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-red-600 font-bold">
                        {{ __('🚪 Cerrar Sesión Segura') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>