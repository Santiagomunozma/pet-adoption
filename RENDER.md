# Despliegue en Render (Gestor de adopción de perros)

Esta aplicación es **Laravel 13** con **PostgreSQL** en producción. Los archivos `Dockerfile`, `render.yaml` y `docker/entrypoint.sh` ya están preparados.

## Requisitos

1. Cuenta en [Render](https://render.com)
2. El código en **GitHub** o **GitLab** (Render se conecta al repositorio)
3. Rama con los archivos de despliegue subidos al remoto

## Opción A — Blueprint (recomendada)

1. Sube los cambios a tu repositorio (`git push`).
2. En Render: **New** → **Blueprint**.
3. Conecta el repositorio de `pet-adoption`.
4. Render leerá `render.yaml` y creará:
   - Base de datos PostgreSQL (`pet-adoption-db`)
   - Servicio web Docker (`pet-adoption`)
5. Pulsa **Apply** y espera el primer deploy (puede tardar varios minutos).

Render generará automáticamente `APP_KEY` y enlazará `DB_URL` con PostgreSQL.

## Opción B — Manual

1. **New** → **PostgreSQL** (plan Free). Anota el nombre.
2. **New** → **Web Service**:
   - **Runtime**: Docker
   - **Root Directory**: (raíz del repo)
   - **Health Check Path**: `/up`
3. En **Environment**:

| Variable | Valor |
|----------|--------|
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | Salida de `php artisan key:generate --show` en local |
| `DB_CONNECTION` | `pgsql` |
| `DB_URL` | **Internal Database URL** de PostgreSQL en Render |
| `LOG_CHANNEL` | `stderr` |
| `SESSION_DRIVER` | `file` |
| `CACHE_STORE` | `file` |
| `QUEUE_CONNECTION` | `sync` |
| `DB_SSLMODE` | `require` |

4. Conecta la base de datos al servicio (Render puede inyectar `DB_URL` desde el panel).

## Después del deploy

- URL pública: `https://<tu-servicio>.onrender.com`
- La app usa `RENDER_EXTERNAL_URL` para URLs HTTPS (no hace falta configurar `APP_URL` a mano si Render la inyecta).
- Las migraciones se ejecutan solas en cada arranque (`docker/entrypoint.sh`).
- Registra un usuario en `/register` para usar el panel (mascotas, especies, etc.).

## Plan Free — avisos

- El servicio **se apaga** tras inactividad; el primer acceso puede tardar ~30–60 s.
- El disco del contenedor es **efímero**: no guardes archivos importantes solo en `storage/` local.
- PostgreSQL Free tiene límites de tamaño; suficiente para desarrollo/demo.

## Comprobar en local (opcional)

```bash
docker build -t pet-adoption .
docker run --rm -p 8080:10000 -e PORT=10000 -e APP_KEY=base64:... -e DB_CONNECTION=sqlite -e DB_DATABASE=/tmp/test.sqlite pet-adoption
```

En producción usa siempre PostgreSQL (`DB_CONNECTION=pgsql` + `DB_URL`).

## Problemas frecuentes

| Síntoma | Qué revisar |
|---------|-------------|
| 500 al abrir la web | Logs del servicio en Render; suele faltar `APP_KEY` o `DB_URL` |
| CSS/JS rotos | Revisa que el build de Vite terminó en el log de Docker (`npm run build`) |
| Error de sesión/cache | `SESSION_DRIVER` y `CACHE_STORE` deben ser `database` y las migraciones deben haber corrido |
| Mixed content (HTTP/HTTPS) | Ya está `URL::forceScheme('https')` en producción |

Documentación oficial: [Deploy Laravel on Render](https://render.com/docs/deploy-php-laravel-docker)
