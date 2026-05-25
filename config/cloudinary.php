<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Credenciales Cloudinary
    |--------------------------------------------------------------------------
    |
    | Lo más simple es definir CLOUDINARY_URL en .env (Dashboard → API Keys).
    | Formato: cloudinary://API_KEY:API_SECRET@CLOUD_NAME
    |
    | También puedes usar las variables sueltas si lo prefieres.
    |
    */

    'url' => env('CLOUDINARY_URL'),

    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
    'api_key' => env('CLOUDINARY_API_KEY'),
    'api_secret' => env('CLOUDINARY_API_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Carpeta en Cloudinary
    |--------------------------------------------------------------------------
    |
    | Todas las fotos de mascotas se suben bajo esta carpeta.
    |
    */

    'folder' => env('CLOUDINARY_FOLDER', 'pet-adoption/pets'),

    /*
    |--------------------------------------------------------------------------
    | Disco local de respaldo (desarrollo sin Cloudinary)
    |--------------------------------------------------------------------------
    */

    'fallback_disk' => env('PET_IMAGES_FALLBACK_DISK', 'public'),

];
