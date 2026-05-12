<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    {{-- El formulario ahora decide si llama a store() o a update() --}}
    <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}" class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
        
        <h3 class="text-lg font-bold mb-4">
            {{ $isEditMode ? 'Editar Especie' : 'Registrar Nueva Especie' }}
        </h3>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nombre de la Especie</label>
            <input type="text" wire:model="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            @error('name') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Descripción (Opcional)</label>
            <textarea wire:model="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            @error('description') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                {{ $isEditMode ? 'Actualizar Cambios' : 'Guardar Especie' }}
            </button>

            {{-- Botón para cancelar la edición --}}
            @if($isEditMode)
                <button type="button" wire:click="resetFields" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cancelar
                </button>
            @endif
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4 text-left">ID</th>
                    <th class="py-2 px-4 text-left">Nombre</th>
                    <th class="py-2 px-4 text-left">Descripción</th>
                    <th class="py-2 px-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($species as $item)
                <tr class="border-b hover:bg-gray-100">
                    <td class="py-2 px-4">{{ $item->id }}</td>
                    <td class="py-2 px-4 font-bold">{{ $item->name }}</td>
                    <td class="py-2 px-4">{{ $item->description }}</td>
                    <td class="py-2 px-4 text-center flex justify-center gap-2">
                        {{-- Botones mágicos de Livewire que llaman a las funciones de PHP --}}
                        <button wire:click="edit({{ $item->id }})" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded text-sm">
                            Editar
                        </button>
                        <button wire:click="delete({{ $item->id }})" onclick="confirm('¿Estás seguro de eliminar esta especie?') || event.stopImmediatePropagation()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                            Borrar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>