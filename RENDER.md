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

**Importante:** debes crear `APP_KEY` manualmente (ver abajo). Render **no** puede generarla automáticamente con el formato que Laravel exige.

### Crear APP_KEY (obligatorio)

En tu PC, dentro del proyecto:

```bash
php artisan key:generate --show
```

Copia la línea completa (empieza por `base64:`) y en Render → tu servicio → **Environment** → `APP_KEY` → pega el valor → **Save Changes** → redeploy.

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

## Fotos de mascotas (Cloudinary)

Las imágenes **no** van en PostgreSQL: en la base solo se guarda el identificador (`image_path`). Los archivos se suben a **Cloudinary** para que sobrevivan a cada redeploy en Render.

### 1. Vincular tu cuenta de Cloudinary

1. Entra en [Cloudinary Console](https://console.cloudinary.com/).
2. En el panel izquierdo: **Home** o **Dashboard**.
3. Busca la sección **API Keys** (o **Product environment credentials**).
4. Copia el valor **CLOUDINARY_URL**. Tiene este formato:
   ```
   cloudinary://123456789012345:abcdefghijklmnopqrstuvwxyz@tu-cloud-name
   ```
   No compartas esta URL en GitHub; es tu clave secreta.

### 2. Configurar en tu PC (desarrollo local)

En el archivo `.env` del proyecto (no subas este archivo al repo):

```env
CLOUDINARY_URL=cloudinary://TU_API_KEY:TU_API_SECRET@TU_CLOUD_NAME
```

Opcional (carpeta dentro de Cloudinary):

```env
CLOUDINARY_FOLDER=pet-adoption/pets
```

Reinicia el servidor si lo tienes corriendo (`php artisan serve`).

### 3. Configurar en Render (producción)

1. Render → servicio **pet-adoption** → **Environment**.
2. **Add Environment Variable**:
   - **Key:** `CLOUDINARY_URL`
   - **Value:** pega la misma URL del paso 1.
3. **Save Changes** → el servicio hará **redeploy** solo.
4. Vuelve a **subir las fotos** de las mascotas que ya tenías: las rutas antiguas en la base apuntaban al disco efímero del contenedor y esas imágenes ya no existen.

### 4. Comprobar que funciona

1. Inicia sesión en la app.
2. Registra o edita una mascota con una foto nueva.
3. En Cloudinary → **Media Library** deberías ver la carpeta `pet-adoption/pets` (o la que definiste en `CLOUDINARY_FOLDER`).
4. Haz un redeploy en Render y verifica que la foto sigue visible.

### Sin Cloudinary en local

Si no defines `CLOUDINARY_URL` en `.env`, las fotos se guardan en `storage/app/public/pets` (como antes). En **Render** debes definir siempre `CLOUDINARY_URL`.

## Plan Free — avisos

- El servicio **se apaga** tras inactividad; el primer acceso puede tardar ~30–60 s.
- El disco del contenedor es **efímero**: las fotos deben ir a Cloudinary (ya integrado en el código).
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
| Fotos rotas tras deploy | Falta `CLOUDINARY_URL` en Render o hay rutas viejas; sube las fotos de nuevo |

Documentación oficial: [Deploy Laravel on Render](https://render.com/docs/deploy-php-laravel-docker)
