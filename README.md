# CRM de Registro y Seguimiento de Aspirantes

**Proyecto académico:** Maestría en Ingeniería y Desarrollo de Software (MIDS)  
**Paradigma:** Programación orientada a objetos (POO)  
**Lenguaje y framework:** PHP 8.3+ · Laravel 12  
**SGBD:** MySQL 8.x / InnoDB  
**Editor recomendado:** Visual Studio Code  
**Integraciones:** Eloquent ORM, Validation, Storage, JWT Auth y DomPDF

## 1. Descripción, antecedentes y objetivos

El **CRM de Aspirantes** es una aplicación web académica para gestionar el proceso de admisión de una institución educativa: creación de cuentas, catálogo de programas, registro y seguimiento de aspirantes, expedientes documentales, pagos registrados manualmente e indicadores administrativos.

El proyecto continúa el trabajo de análisis y diseño de sistemas y aplica conceptos de POO y bases de datos relacionales. Es un **prototipo académico**: no procesa cobros bancarios ni debe utilizarse con datos personales reales sin una revisión de seguridad, privacidad y operación.

**Objetivo general:** desarrollar una aplicación web modular para administrar el ciclo de admisión, aplicando POO, validación, persistencia relacional y mecanismos de acceso a información y generación de documentos.

**Objetivos específicos:**

1. Registrar y consultar aspirantes y sus programas académicos.
2. Administrar expedientes digitales, documentos, pagos manuales y seguimientos.
3. Aplicar relaciones Eloquent y validaciones para preservar la consistencia de los datos.
4. Implementar una API REST con autenticación JWT separada del inicio de sesión web.
5. Generar fichas PDF de expedientes con verificación de autorización.
6. Documentar el código y las evidencias de uso para la actividad MIDS.

## 2. Tecnologías y justificación

| Tecnología | Función en el CRM | Justificación |
|---|---|---|
| PHP 8.3+ | Lenguaje backend orientado a objetos | Compatible con la versión de las dependencias declaradas y con Laravel 12. |
| Laravel 12 | Framework MVC | Proporciona rutas, controladores, modelos, validación, migraciones y autenticación web. |
| MySQL 8.x / InnoDB | Persistencia | Claves primarias y foráneas, transacciones e índices. |
| Eloquent ORM | Acceso a la base de datos | Relaciones entre entidades, consultas y paginación. |
| Laravel Validation | Validación de solicitudes | Comprueba formatos, campos obligatorios, referencias y archivos. |
| Laravel Filesystem / Storage | Gestión documental | Almacena y descarga documentos del expediente con control de acceso en la aplicación. |
| `php-open-source-saver/jwt-auth` | Autenticación para API REST | Tokens firmados en endpoints separados de la sesión web. |
| `barryvdh/laravel-dompdf` | Generación de PDF | Produce una ficha descargable a partir de una vista Blade. |
| Blade + CSS | Vistas web | Interfaz del CRM sin compilación frontend. |
| Composer 2 | Dependencias | Instala paquetes y registra versiones en `composer.lock`. |
| Visual Studio Code + Git | Desarrollo y control de cambios | Edición, depuración, terminal y versionado. |

No se requiere `npm install` para esta versión del proyecto si no se han añadido dependencias frontend.

## 3. Diseño orientado a objetos y diagrama UML

Diagramas incluidos:
- [Diagrama de clases Mermaid](docs/diagrama_clases.mmd)
- [Diagrama de clases PlantUML](docs/diagrama_clases.puml)

| Clase | Información principal | Métodos o relaciones |
|---|---|---|
| `User` | Identidad, correo, contraseña con hash, rol | `aspirante()`, `esPersonal()`, `getJWTIdentifier()`, `getJWTCustomClaims()` |
| `ProgramaAcademico` | Programa, modalidad, estado | `aspirantes()` |
| `Aspirante` | Datos de solicitud, usuario, programa, estatus | `usuario()`, `programa()`, `documentos()`, `pagos()`, `seguimientos()` |
| `Documento` | Tipo, ruta, validación | `aspirante()` |
| `Pago` | Concepto, monto, estado | `aspirante()` |
| `Seguimiento` | Observaciones y responsable | `aspirante()`, `usuario()` |

Los modelos heredan de Eloquent (`User` hereda de `Authenticatable`) y usan asociaciones `hasOne`, `hasMany` y `belongsTo`. La relación de `User` a `Aspirante` especifica expresamente la clave foránea **`id_usuario`** en lugar de la convención `user_id`:

```php
public function aspirante()
{
    return $this->hasOne(Aspirante::class, 'id_usuario', 'id');
}
```

La abstracción se observa en el modelado de entidades; la herencia, en los modelos y controladores; la modularidad, en los distintos controladores y vistas; y el polimorfismo, en los contratos y comportamientos que proveen las clases de Laravel. `$fillable` limita la asignación masiva, pero **no sustituye** la autorización ni equivale por sí solo a encapsulación estricta de atributos.

## 4. Estructura principal

```text
crm_aspirantes/
├── app/
│   ├── Http/Controllers/
│   │   ├── Api/JwtAuthController.php
│   │   ├── ExpedientePdfController.php
│   │   ├── AuthController.php
│   │   ├── AspiranteController.php
│   │   ├── DocumentoController.php
│   │   └── ...
│   └── Models/                    # User, Aspirante, ProgramaAcademico, etc.
├── bootstrap/app.php
├── config/auth.php
├── database/migrations/
├── database/seeders/
├── docs/                          # UML y evidencias académicas
├── public/css/app.css
├── resources/views/
│   └── pdf/expediente.blade.php
├── routes/
│   ├── web.php
│   └── api.php
├── .env.example
├── composer.json
├── composer.lock                 # Debe subirse tras sincronizar dependencias
└── artisan
```

## 5. Instalación en Windows con XAMPP

**Requisitos:** PHP 8.3 o superior, Composer 2, MySQL 8.x, extensiones PHP necesarias para Laravel y las librerías (`pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `dom`, `xml`, `sodium`) y acceso a terminal. La instalación local mostrada durante la actividad utilizó PHP 8.4.25 y Laravel 12.70.1.

**1. Abrir el proyecto** desde la carpeta que contiene `artisan`. No es necesario crear otro proyecto Laravel.

```powershell
cd C:\xampp\htdocs\mwc2\proyecto\crm_aspirantes
php -v
composer --version
```

**2. Instalar las dependencias:**

```powershell
composer install
```

El `composer.json` incluye `php-open-source-saver/jwt-auth` (`^2.10`) y `barryvdh/laravel-dompdf` (`^3.1`). Si aparece un error porque `composer.lock` **no contiene** esas dependencias, utiliza esta solución focalizada en vez de actualizar indiscriminadamente todo el proyecto:

```powershell
composer require php-open-source-saver/jwt-auth:^2.10 barryvdh/laravel-dompdf:^3.1
```

En la instalación de la actividad, Composer ya confirmó ambos paquetes. Tras ello, conserva y versiona **juntos** `composer.json` y `composer.lock`.

**3. Configurar el entorno** (solo en una instalación nueva):

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

> Si ya existe un `.env` configurado, **no lo sobrescribas** ni regeneres `APP_KEY`: hacerlo podría invalidar datos cifrados y sesiones existentes.

**4. Crear la base de datos** en MySQL/phpMyAdmin:

```sql
CREATE DATABASE crm_aspirantes
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

Establecer en `.env` (ejemplo solo para desarrollo local):

```dotenv
APP_NAME="CRM Aspirantes"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crm_aspirantes
DB_USERNAME=root
DB_PASSWORD=
SESSION_DRIVER=file
FILESYSTEM_DISK=local
```

**5. Preparar esquema y datos de prueba.** Si la base **está vacía**:

```powershell
php artisan migrate --seed
```

Si ya tiene tablas y datos, verifica primero `php artisan migrate:status`; no importes un dump y ejecutes migraciones destructivas sobre la misma estructura sin revisar conflictos. **No uses `php artisan migrate:fresh` con información que quieras conservar.**

**6. Configurar JWT:**

```powershell
php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
php artisan optimize:clear
```

`jwt:secret` crea `JWT_SECRET` en `.env`. Si ya existe y el proyecto está en uso, **no lo regeneres**, pues invalidaría los JWT emitidos. La publicación de la configuración de DomPDF es opcional; puede hacerse con `php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"` si se requiere personalizarla.

**7. Ejecutar el CRM:**

```powershell
php artisan route:list
php artisan serve --host=127.0.0.1 --port=8000
```

- Acceso web: `http://127.0.0.1:8000/login`
- Panel: `http://127.0.0.1:8000/` (requiere inicio de sesión)
- Usuario demo generado por el seeder en instalaciones locales nuevas: `admin@crm.local`, contraseña `CrmDemo123!`. **Cambiar o desactivar estas credenciales fuera de pruebas aisladas.**

## 6. Librerías y API implementadas

### 6.1 Eloquent ORM

En `AspiranteController` se consultan aspirantes junto con su programa académico usando carga anticipada y paginación:

```php
Aspirante::with('programa')->latest('fecha_registro');
```

**Evidencia sugerida:** listado de aspirantes con programa y código de la relación `programa()`.

### 6.2 Laravel Validation

En `DocumentoController` se validan campos y archivos:

El controlador utiliza reglas como `required`, `file`, `mimes:pdf,jpg,jpeg,png` y `max:5120` para restringir archivos a tipos permitidos y tamaño máximo de 5 MiB. **Evidencia:** rechazo de un archivo `.txt` y captura de las reglas PHP.

### 6.3 Laravel Storage

```php
$r->file('archivo')->store(
    'expedientes/'.$aspirante->id_aspirante,
    'local'
);
```

Los documentos se descargan mediante el sistema de almacenamiento tras verificar acceso. **Evidencia:** expediente con un archivo de prueba y descarga autorizada.

### 6.4 JWT Auth — Autenticación de la API REST

**Paquete:** `php-open-source-saver/jwt-auth`.

La autenticación web tradicional mediante sesiones permanece separada de la API JWT. Los tokens se devuelven solo después de autenticar credenciales válidas. Las rutas relevantes están en `routes/api.php` y el controlador en `app/Http/Controllers/Api/JwtAuthController.php`.

| Método | Endpoint | Requisito |
|---|---|---|
| POST | `/api/auth/login` | JSON con `email` y `password`; limitación `throttle:5,1` |
| GET | `/api/auth/me` | Token válido en `Authorization: Bearer` |
| POST | `/api/auth/logout` | Token válido; invalida el token |

**Prueba de inicio de sesión en Postman:**

```http
POST http://127.0.0.1:8000/api/auth/login
Content-Type: application/json
Accept: application/json
```

```json
{
  "email": "admin@crm.local",
  "password": "CONTRASEÑA_LOCAL_DE_PRUEBA"
}
```

Una respuesta satisfactoria contiene `token_type`, `access_token` y `expires_in`. Para consultar el usuario autenticado:

```http
GET http://127.0.0.1:8000/api/auth/me
Authorization: Bearer TOKEN_OBTENIDO
Accept: application/json
```

**Evidencia:** capturas de Postman con código HTTP, respuesta y rutas, **ocultando JWT y contraseñas**. El uso de JWT no reemplaza las verificaciones de permisos de negocio y debe utilizarse sobre HTTPS fuera de localhost.

### 6.5 DomPDF — Generación de ficha de expediente

**Paquete:** `barryvdh/laravel-dompdf`.

La ruta protegida por sesión `GET /aspirantes/{aspirante}/pdf` invoca `ExpedientePdfController::download()`. El controlador permite descargar la ficha solo al propio aspirante o al personal autorizado; carga programa, documentos, pagos y seguimientos y produce un PDF tamaño A4 desde `resources/views/pdf/expediente.blade.php`.

Ejemplo del núcleo de generación:

```php
$pdf = Pdf::loadView('pdf.expediente', ['a' => $aspirante])
    ->setPaper('a4', 'portrait');

return $pdf->download(
    'expediente-aspirante-'.$aspirante->id_aspirante.'.pdf'
);
```

**Prueba:** iniciar sesión, abrir un aspirante autorizado y descargar la ficha desde `/aspirantes/1/pdf` (cambiar el ID por uno existente). La ficha resume el expediente, **no adjunta los archivos originales ni es una factura**.

## 7. Recorrido funcional y evidencias MIDS

1. Iniciar sesión localmente y mostrar los programas y aspirantes registrados.
2. Registrar un aspirante de prueba y consultar su expediente (Eloquent).
3. Probar campos incorrectos o un archivo no permitido (Validation).
4. Cargar un archivo permitido y verificar su descarga (Storage).
5. Obtener JWT en Postman y consultar `/api/auth/me` con `Bearer` (JWT Auth).
6. Descargar y abrir la ficha PDF de un aspirante autorizado (DomPDF).
7. Adjuntar capturas claras del código y los resultados reales. No mostrar datos personales, contraseñas o tokens.

**Importante:** Que una ruta aparezca en `php artisan route:list` acredita su registro, **no prueba que su funcionamiento haya sido validado**. Las capturas de ejecución se deben obtener en el entorno local; no están incluidas como evidencia simulada.

## 8. Verificación técnica

```powershell
composer validate
php artisan route:list
php artisan route:list --path=api
php artisan migrate:status
php artisan test
```

`php artisan test` ejecuta únicamente las pruebas que existan; la presencia de archivos de prueba por defecto no implica que JWT, PDF o los módulos del CRM tengan pruebas funcionales automatizadas completas.

## 9. Seguridad y publicación en GitHub

- **No publicar** `.env`, `JWT_SECRET`, credenciales, sesiones, respaldos con datos personales ni directorios `vendor/` y `.git/`.
- Versionar `composer.json`, `composer.lock`, código fuente, migraciones, README y UML.
- Mantener el inicio de sesión web y los endpoints JWT bajo sus respectivos mecanismos de autenticación y autorización.
- Usar HTTPS y contraseñas de prueba distintas de las credenciales reales en cualquier entorno público.
- No utilizar datos personales reales sin un proceso adecuado de privacidad y seguridad.

## 10. Documentación académica y licencia

- [Actividad MIDS: librerías y API](docs/ACTIVIDAD_MIDS_LIBRERIAS_API.md)
- [Instrucciones complementarias JWT y PDF](docs/INSTRUCCIONES_JWT_PDF.md)
- [Diagrama UML Mermaid](docs/diagrama_clases.mmd)
- [Diagrama UML PlantUML](docs/diagrama_clases.puml)

Proyecto elaborado con **fines académicos** para la Maestría en Ingeniería y Desarrollo de Software (MIDS). **No se ha declarado una licencia de software abierto**; el uso y distribución requieren autorización del titular.
