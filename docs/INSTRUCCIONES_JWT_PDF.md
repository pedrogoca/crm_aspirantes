# Guía breve de instalación JWT y PDF

1. Requiere PHP 8.3+, Composer 2, MySQL y extensiones PHP necesarias (especialmente `sodium`, `dom` y `mbstring`).
2. En la raíz: `composer install` (resolverá el `composer.lock` nuevo).
3. Configurar `.env` desde `.env.example` únicamente si aún no existe, y ejecutar `php artisan key:generate`.
4. Ejecutar `php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"`.
5. Ejecutar `php artisan jwt:secret` y `php artisan optimize:clear`.
6. Comprobar `php artisan route:list --path=api` y `php artisan route:list --name=aspirantes.pdf`.
7. Probar `POST /api/auth/login`, `GET /api/auth/me`, `POST /api/auth/logout` con Postman.
8. Desde el CRM web descargar el PDF en el detalle del aspirante.
9. No publicar `.env`, contraseñas ni tokens. El guard `web` no se reemplaza.

**Notas:** no se instala ni ejecuta Composer automáticamente dentro del ZIP. No se han realizado pruebas HTTP ni de generación de PDF en un servidor Laravel activo. El PDF contiene información personal: protege y controla su distribución.
