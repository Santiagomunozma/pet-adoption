<div>
    {{-- Formulario para Mascotas --}}
    <form wire:submit.prevent="save" class="mb-6 bg-white p-6 rounded-lg border border-gray-200 shadow-md">
        <h3 class="text-xl font-bold mb-4 text-gray-800">
            {{ $isEditMode ? '📝 Editar Mascota' : '🐾 Registrar Nueva Mascota' }}
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Nombre --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nombre de la Mascota</label>
                <input type="text" wire:model="name" class="border rounded w-full py-2 px-3 text-gray-700">
                @error('name') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
            </div>

            {{-- Selección de Especie --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Especie</label>
                <select wire:model="species_id" class="border rounded w-full py-2 px-3 text-gray-700">
                    <option value="">-- Seleccione una especie --</option>
                    @foreach($species as $specie)
                        <option value="{{ $specie->id }}">{{ $specie->name }}</option>
                    @endforeach
                </select>
                @error('species_id') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
            </div>

            {{-- Raza --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Raza</label>
                <input type="text" wire:model="breed" class="border rounded w-full py-2 px-3 text-gray-700">
            </div>

            {{-- Edad --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Edad (años)</label>
                <input type="number" wire:model="age" class="border rounded w-full py-2 px-3 text-gray-700">
            </div>

            {{-- Estado --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Estado</label>
                <select wire:model="status" class="border rounded w-full py-2 px-3 text-gray-700">
                    <option value="disponible">Disponible</option>
                    <option value="adoptado">Adoptado</option>
                </select>
            </div>

            {{-- Subida de Imagen --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Foto de la Mascota</label>
                {{-- Aquí usamos la variable iteration para obligar la limpieza --}}
                <input type="file" wire:model="image" id="upload-{{ $iteration }}" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                
                <div wire:loading wire:target="image" class="text-blue-500 text-xs mt-2">Subiendo imagen...</div>
                @error('image') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                
                {{-- Previsualización --}}
                <div class="mt-4 flex gap-4">
                    @if ($image)
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Previsualización:</p>
                            <img src="{{ $image->temporaryUrl() }}" class="w-24 h-24 object-cover rounded-lg border">
                        </div>
                    @elseif($this->oldImageUrl)
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Imagen Actual:</p>
                            <img src="{{ $this->oldImageUrl }}" alt="Imagen actual" class="w-24 h-24 object-cover rounded-lg border">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex gap-2 mt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-6 rounded shadow">
                {{ $isEditMode ? 'Actualizar Mascota' : 'Registrar Mascota' }}
            </button>
            @if($isEditMode)
                <button type="button" wire:click="resetFields" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                    Cancelar
                </button>
            @endif
        </div>
    </form>

    {{-- Tabla de Mascotas --}}
    <div class="overflow-x-auto shadow-lg rounded-lg">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100 border-b-2 border-gray-200">
                <tr>
                    <th class="py-3 px-4 text-left font-semibold text-gray-600">Foto</th>
                    <th class="py-3 px-4 text-left font-semibold text-gray-600">Nombre / Especie</th>
                    <th class="py-3 px-4 text-left font-semibold text-gray-600">Raza / Edad</th>
                    <th class="py-3 px-4 text-center font-semibold text-gray-600">Estado</th>
                    <th class="py-3 px-4 text-center font-semibold text-gray-600">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($pets as $pet)
                <tr wire:key="pet-{{ $pet->id }}" class="hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4">
                        @if($pet->image_url)
                            <img src="{{ $pet->image_url }}" alt="{{ $pet->name }}" class="w-16 h-16 object-cover rounded-full border shadow-sm">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center text-gray-400 text-xs">Sin foto</div>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        <div class="font-bold text-gray-800">{{ $pet->name }}</div>
                        <div class="text-xs text-blue-600 uppercase">{{ $pet->species->name }}</div>
                    </td>
                    <td class="py-3 px-4">
                        <div class="text-sm text-gray-600">{{ $pet->breed ?? 'Mestizo' }}</div>
                        <div class="text-xs text-gray-400">{{ $pet->age }} años</div>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $pet->status == 'disponible' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($pet->status) }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex justify-center gap-2">
                            <button wire:click="edit({{ $pet->id }})" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded">
                                ✏️ Editar
                            </button>
                            <button wire:click="delete({{ $pet->id }})" onclick="confirm('¿Borrar mascota?') || event.stopImmediatePropagation()" class="p-2 text-red-600 hover:bg-red-50 rounded">
                                🗑️ Borrar
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($pets->isEmpty())
            <div class="p-6 text-center text-gray-500">No hay mascotas registradas aún.</div>
        @endif
    </div>
</div>