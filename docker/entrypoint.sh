#!/usr/bin/env bash
set -e

php artisan storage:link --force 2>/dev/null || true

if [ ! -f public/build/manifest.json ]; then
    echo "ERROR: Falta public/build/manifest.json. El build de Vite no se incluyó en la imagen."
    echo "En Render, el servicio debe usar Runtime: Docker (no PHP nativo sin build)."
    exit 1
fi

php artisan migrate --force
php artisan config:cache

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
