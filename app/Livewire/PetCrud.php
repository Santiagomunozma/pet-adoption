<?php

namespace App\Livewire;

use App\Models\Pet;
use App\Models\Species;
use App\Services\PetImageStorage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PetCrud extends Component
{
    use WithFileUploads;

    // Variables de la tabla Mascotas
    public $name, $age, $breed, $status = 'disponible', $species_id;
    
    // Variables para la imagen
    public $image; 
    public $old_image; 
    
    // Variables de control
    public $pet_id;
    public $isEditMode = false;
    public $iteration = 0; // Ayuda a limpiar el input de la foto

    // Reglas de validación
    protected $rules = [
        'name' => 'required|min:3',
        'age' => 'nullable|integer|min:0',
        'breed' => 'nullable|string|max:50',
        'status' => 'required|in:disponible,adoptado',
        'species_id' => 'required|exists:species,id',
        'image' => 'nullable|image|max:2048', 
    ];

    public function store(PetImageStorage $petImages)
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $petImages->store($this->image);
        }

        Pet::create([
            'species_id' => $this->species_id,
            'name' => $this->name,
            'age' => $this->age,
            'breed' => $this->breed,
            'status' => $this->status,
            'image_path' => $imagePath,
        ]);

        $this->resetFields();
        // Alerta elegante
        $this->actualizarEstadisticas();
        $this->js("Swal.fire({title: '¡Éxito!', text: '¡Mascota registrada correctamente!', icon: 'success', confirmButtonColor: '#16a34a'})");
    }

    public function edit($id)
    {
        $this->resetErrorBag(); // Limpiamos errores rojos previos
        
        $pet = Pet::findOrFail($id);
        
        $this->pet_id = $pet->id;
        $this->species_id = $pet->species_id;
        $this->name = $pet->name;
        $this->age = $pet->age;
        $this->breed = $pet->breed;
        $this->status = $pet->status;
        $this->old_image = $pet->image_path; 
        
        $this->isEditMode = true;
    }

    public function update(PetImageStorage $petImages)
    {
        $this->validate();

        $pet = Pet::findOrFail($this->pet_id);
        $imagePath = $pet->image_path;

        if ($this->image) {
            $petImages->delete($pet->image_path);
            $imagePath = $petImages->store($this->image);
        }

        $pet->update([
            'species_id' => $this->species_id,
            'name' => $this->name,
            'age' => $this->age,
            'breed' => $this->breed,
            'status' => $this->status,
            'image_path' => $imagePath,
        ]);

        $this->resetFields();
        // Alerta elegante
        // Cambia el dispatch por esto:
        $this->actualizarEstadisticas();
$this->js("Swal.fire({title: '¡Éxito!', text: '¡Mascota actualizada correctamente!', icon: 'info', confirmButtonColor: '#16a34a'})");
    }

    public function delete($id, PetImageStorage $petImages)
    {
        $pet = Pet::findOrFail($id);

        $petImages->delete($pet->image_path);

        $pet->delete();
        // Alerta elegante
        $this->actualizarEstadisticas();
        $this->js("Swal.fire({title: '¡Éxito!', text: '¡Mascota eliminada correctamente!', icon: 'warning', confirmButtonColor: '#16a34a'})");
    }

    public function resetFields()
    {
        $this->resetErrorBag(); // Limpiamos validaciones
        
        // Vaciamos explícitamente cada campo
        $this->name = '';
        $this->age = '';
        $this->breed = '';
        $this->status = 'disponible';
        $this->species_id = '';
        $this->image = null;
        $this->old_image = null;
        $this->pet_id = null;
        $this->isEditMode = false;
        
        $this->iteration++; // Obliga al HTML a soltar el archivo
    }

    public function render()
    {
        $pets = Pet::with('species')->orderBy('id', 'desc')->get();
        $species = Species::all();

        return view('livewire.pet-crud', compact('pets', 'species'));
    }
    public function getOldImageUrlProperty(): ?string
    {
        return app(PetImageStorage::class)->url($this->old_image);
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