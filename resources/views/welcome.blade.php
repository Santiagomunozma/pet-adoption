<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peluditos en Red</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <nav class="relative w-full z-20 top-0 left-0 border-b border-gray-200 bg-white shadow-sm">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="/" class="flex items-center gap-2">
                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5.5A3.5 3.5 0 108.5 9 3.5 3.5 0 0012 5.5zM4.5 12a3 3 0 10-3 3 3 3 0 003-3zm15 0a3 3 0 10-3 3 3 3 0 003-3zm-9.5 4a5.5 5.5 0 00-7.07 1.83 1.5 1.5 0 00.7 2.15c2.39 1.19 5.3 1.52 7.87.52a1.5 1.5 0 00.7-2.15A5.5 5.5 0 0010 16zm4-4a3.5 3.5 0 10-3.5-3.5A3.5 3.5 0 0014 12z"></path>
                </svg>
                <span class="self-center text-2xl font-extrabold whitespace-nowrap text-purple-700">Peluditos en Red</span>
            </a>
            <div class="flex md:order-2">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2 text-center transition-colors">Ir al Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-800 hover:text-purple-600 font-medium rounded-lg text-sm px-4 py-2 text-center mr-2 transition-colors">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-white bg-teal-500 hover:bg-teal-600 focus:ring-4 focus:outline-none focus:ring-teal-300 font-medium rounded-lg text-sm px-4 py-2 text-center transition-colors">Registrarse</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <section class="bg-white">
        <div class="py-12 px-4 mx-auto max-w-screen-xl text-center lg:py-24 lg:px-12">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl">
                <span class="text-purple-600">Más que una plataforma,</span> <br> una familia para cada huella.
            </h1>
            <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48">Nuestra misión es conectar a mascotas rescatadas con personas dispuestas a darles el amor que merecen. Únete a nuestra comunidad y cambia una vida hoy mismo.</p>
            
            <div class="flex flex-col mb-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex justify-center items-center py-3 px-6 text-base font-medium text-center text-white rounded-lg bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-300 transition-all hover:scale-105 shadow-lg shadow-purple-200">
                        Gestionar Mascotas
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center py-3 px-6 text-base font-medium text-center text-white rounded-lg bg-teal-500 hover:bg-teal-600 focus:ring-4 focus:ring-teal-300 transition-all hover:scale-105 shadow-lg shadow-teal-200">
                        Comenzar ahora
                    </a>
                @endauth
            </div>
            
            <div class="flex justify-center">
                <img class="w-full max-w-3xl rounded-2xl shadow-2xl border-4 border-white" src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?q=80&w=1000&auto=format&fit=crop" alt="Perros felices jugando">
            </div>
        </div>
    </section>

</body>
</html>