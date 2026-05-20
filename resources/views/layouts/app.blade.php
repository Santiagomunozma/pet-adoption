<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Peluditos en Red</title>

        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <link rel="alternate icon" href="{{ asset('favicon.ico') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

        <x-vite-assets />
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    </head>
    <body class="font-sans antialiased bg-purple-50/30">
        <div class="min-h-screen">
            
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white/80 backdrop-blur-md border-b border-purple-100 shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>

            <footer class="bg-white border-t border-purple-100 mt-12 py-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 5.5A3.5 3.5 0 108.5 9 3.5 3.5 0 0012 5.5zM4.5 12a3 3 0 10-3 3 3 3 0 003-3zm15 0a3 3 0 10-3 3 3 3 0 003-3zm-9.5 4a5.5 5.5 0 00-7.07 1.83 1.5 1.5 0 00.7 2.15c2.39 1.19 5.3 1.52 7.87.52a1.5 1.5 0 00.7-2.15A5.5 5.5 0 0010 16zm4-4a3.5 3.5 0 10-3.5-3.5A3.5 3.5 0 0014 12z"></path>
                                </svg>
                                <span class="font-black text-purple-700">Peluditos en Red</span>
                            </div>
                            <p class="text-gray-500 text-sm">Gestionando segundas oportunidades para cada huella.</p>
                        </div>

                        <div>
                            <h4 class="font-bold text-gray-800 mb-4">Desarrollado por:</h4>
                            <p class="text-purple-600 font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-gray-400 text-xs mt-1">Proyecto de Ingeniería de Sistemas</p>
                        </div>

                        <div>
                            <h4 class="font-bold text-gray-800 mb-4">Ubicación</h4>
                            <p class="text-sm text-gray-500">📍 Medellín, Antioquia</p>
                            <p class="text-sm text-gray-500">📧 contacto@peluditos.com</p>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-100 mt-8 pt-8 text-center text-xs text-gray-400">
                        &copy; {{ date('Y') }} Peluditos en Red. Todos los derechos reservados.
                    </div>
                </div>
            </footer>
        </div>

        @stack('scripts')
    </body>
</html>