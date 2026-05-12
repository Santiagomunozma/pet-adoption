<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Species;

class SpeciesCrud extends Component
{
    public $name;
    public $description;
    
    // Nuevas variables para la edición
    public $species_id; 
    public $isEditMode = false; // Bandera para saber si estamos creando o editando

    protected $rules = [
        'name' => 'required|min:3',
        'description' => 'nullable|max:255',
    ];

    public function store()
    {
        $this->validate();

        Species::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->resetFields();
        $this->actualizarEstadisticas();
        $this->js("Swal.fire({title: '¡Éxito!', text: '¡Especie guardada!', icon: 'success', confirmButtonColor: '#16a34a'})");
    }

    // Función para cargar los datos en el formulario cuando le damos a "Editar"
    public function edit($id)
    {
        $species = Species::findOrFail($id);
        $this->species_id = $species->id;
        $this->name = $species->name;
        $this->description = $species->description;
        
        $this->isEditMode = true; // Cambiamos la bandera
    }

    // Función para guardar los cambios de la edición
    public function update()
    {
        $this->validate();

        $species = Species::find($this->species_id);
        $species->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->resetFields();
        $this->actualizarEstadisticas();
        $this->js("Swal.fire({title: '¡Éxito!', text: '¡Especie actualizada!', icon: 'info', confirmButtonColor: '#16a34a'})");
    }

    // Función para eliminar
    public function delete($id)
    {
        Species::findOrFail($id)->delete();
        $this->actualizarEstadisticas();
        $this->js("Swal.fire({title: '¡Éxito!', text: '¡Especie eliminada!', icon: 'warning', confirmButtonColor: '#16a34a'})");
    }

    // Función auxiliar para limpiar el formulario y resetear el modo
    public function resetFields()
    {
        $this->reset(['name', 'description', 'species_id', 'isEditMode']);
    }

    public function render()
    {
        $species = Species::orderBy('id', 'desc')->get();
        return view('livewire.species-crud', compact('species'));
    }
    public function actualizarEstadisticas()
    {
        $species = \App\Models\Species::withCount('pets')->get();

        $this->dispatch('recargar-graficas', datos: [
            'labels' => $species->pluck('name')->toArray(),
            'datosEspecies' => $species->pluck('pets_count')->toArray(),
            'disponibles' => \App\Models\Pet::where('status', 'disponible')->count(),
            'adoptados' => \App\Models\Pet::where('status', 'adoptado')->count()
        ]);
    }
}