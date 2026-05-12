<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    // 1. Campos seguros para llenar
    protected $fillable = [
        'species_id', 
        'name', 
        'age', 
        'breed', 
        'status', 
        'image_path'
    ];

    // 2. Definimos la relación: Una mascota PERTENECE A una especie (belongsTo)
    public function species()
    {
        return $this->belongsTo(Species::class);
    }
}