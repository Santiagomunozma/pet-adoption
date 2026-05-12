<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    use HasFactory;

    // 1. Definimos los campos que se pueden llenar desde un formulario
    protected $fillable = ['name', 'description'];

    // 2. Definimos la relación: Una especie tiene MUCHAS mascotas (hasMany)
    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}