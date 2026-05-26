<?php

namespace Tests\Feature;

use App\Livewire\PetCrud;
use App\Models\Species;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PetCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_un_usuario_puede_registrar_una_mascota()
    {
        // 1. Creamos una especie de prueba
        $species = Species::create(['name' => 'Gato']);

        // 2. Simulamos el flujo en el componente de Livewire
        Livewire::test(PetCrud::class)
            ->set('name', 'Arnold')
            ->set('species_id', $species->id)
            ->set('age', 5)
            ->set('breed', 'Angora')
            ->set('status', 'disponible')
            ->call('save');

        // 3. Verificamos que se haya guardado correctamente
        $this->assertDatabaseHas('pets', [
            'name' => 'Arnold',
            'breed' => 'Angora'
        ]);
    }
}