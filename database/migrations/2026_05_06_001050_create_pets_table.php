<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            
            // Llave foránea: conecta la mascota con su especie.
            // constrained() busca automáticamente la tabla 'species' y onDelete('cascade') borra la mascota si se borra la especie.
            $table->foreignId('species_id')->constrained()->onDelete('cascade'); 
            
            $table->string('name');
            $table->integer('age')->nullable(); // Edad en meses o años
            $table->string('breed')->nullable(); // Raza
            $table->enum('status', ['disponible', 'adoptado'])->default('disponible'); // Solo permite estos dos valores
            $table->string('image_path')->nullable(); // Aquí guardaremos la ruta de la foto más adelante
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
