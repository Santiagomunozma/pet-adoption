@props([
    'assets' => ['resources/css/app.css', 'resources/js/app.js'],
])

@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite($assets)
@endif
