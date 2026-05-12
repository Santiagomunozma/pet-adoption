<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 1. CALCULAMOS LOS DATOS REALES DE LA BASE DE DATOS --}}
            @php
                // Contamos cuántas mascotas tiene cada especie
                $species = \App\Models\Species::withCount('pets')->get();
                $labelsEspecies = $species->pluck('name')->toJson();
                $datosEspecies = $species->pluck('pets_count')->toJson();

                // Contamos el estado real de las mascotas
                $disponibles = \App\Models\Pet::where('status', 'disponible')->count();
                $adoptados = \App\Models\Pet::where('status', 'adoptado')->count();
            @endphp

            {{-- 2. BOTÓN DE PDF (Ahora arriba, grande y visible) --}}
            <div class="mb-6 flex justify-end">
                <a href="{{ route('pets.pdf') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg flex items-center gap-2 transition-transform hover:scale-105">
                    📥 Descargar Reporte PDF
                </a>
            </div>

            {{-- 3. GRÁFICAS CONTROLADAS --}}
            <div class="mb-8 bg-white p-6 rounded-xl shadow-md border border-gray-200">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">
                    📊 Estadísticas de Adopción (En tiempo real)
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Contenedores con altura fija (h-72) para que no muten --}}
                    <div class="relative h-72 w-full flex justify-center">
                        <canvas id="chartEspecies"></canvas>
                    </div>
                    <div class="relative h-72 w-full flex justify-center">
                        <canvas id="chartEstado"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 5. SCRIPT DE CHART.JS CON DATOS REALES --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. Guardamos las gráficas en variables (let) para poder modificarlas
            const ctx1 = document.getElementById('chartEspecies');
            let miGraficaEspecies = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: {!! $labelsEspecies !!}, 
                    datasets: [{
                        label: 'Cantidad de Mascotas',
                        data: {!! $datosEspecies !!}, 
                        backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });

            const ctx2 = document.getElementById('chartEstado');
            let miGraficaEstado = new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['Disponibles', 'Adoptados'],
                    datasets: [{
                        data: [{{ $disponibles }}, {{ $adoptados }}],
                        backgroundColor: ['#22c55e', '#ef4444']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // 2. EL ESCUCHADOR MÁGICO: Atrapa los datos nuevos de Livewire y anima la gráfica
            window.addEventListener('recargar-graficas', (event) => {
                // Sacamos los datos que mandó PHP
                let info = event.detail.datos || (event.detail[0] && event.detail[0].datos);

                // Actualizamos la dona (Estado)
                miGraficaEstado.data.datasets[0].data = [info.disponibles, info.adoptados];
                miGraficaEstado.update(); // <- Esto hace la animación

                // Actualizamos las barras (Especies)
                miGraficaEspecies.data.labels = info.labels;
                miGraficaEspecies.data.datasets[0].data = info.datosEspecies;
                miGraficaEspecies.update(); // <- Esto hace la animación
            });
        });
    </script>
</x-app-layout>