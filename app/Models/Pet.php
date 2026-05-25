<?php

namespace App\Models;

use App\Services\PetImageStorage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'species_id',
        'name',
        'age',
        'breed',
        'status',
        'image_path',
    ];

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(
            fn () => app(PetImageStorage::class)->url($this->image_path)
        );
    }
}