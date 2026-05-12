<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Pet;

// Esta es la ruta que consumirán otras aplicaciones
Route::get('/mascotas', function () {
    // Traemos todas las mascotas con su respectiva especie
    return Pet::with('species')->get();
});