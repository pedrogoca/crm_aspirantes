# CRM de Registro y Seguimiento de Aspirantes

**Actividad académica:** Implementación del proyecto — Maestría en Ingeniería y Desarrollo de Software (MIDS)  
**Paradigma:** programación orientada a objetos (POO)  
**Lenguaje:** PHP 8.2 o superior · **Framework:** Laravel 12 · **Base de datos:** MySQL  
**Editor recomendado:** Visual Studio Code

## 1. Descripción y objetivo

Sistema web académico para administrar solicitudes de admisión a una institución educativa. Centraliza el registro de cuentas, programas académicos, expedientes de aspirantes, documentos, pagos registrados manualmente, observaciones de seguimiento y estadísticas básicas del personal. El proyecto representa una **implementación académica**, no una exportación de un sistema institucional existente; no incluye datos reales de estudiantes ni conexión con una pasarela bancaria.

**Objetivo general:** desarrollar una aplicación de gestión de aspirantes que aplique modelado orientado a objetos, relaciones entre clases, validación de datos y persistencia mediante un ORM.

## 2. Tecnologías

| Tecnología | Uso | Justificación |
|---|---|---|
| PHP 8.2+ | Lenguaje de desarrollo | Permite crear clases, objetos, métodos, visibilidades y relaciones; compatible con Laravel 12. |
| Laravel 12 | Framework MVC y Eloquent ORM | Separa controladores, modelos y vistas; ofrece validación, autenticación y migraciones. |
| MySQL 8.x (o compatible) | Base de datos relacional | Gestiona las tablas y relaciones referenciales del CRM. |
| Blade + CSS | Interfaz web | Construye las vistas del proyecto sin depender de un frontend con Node. |
| Visual Studio Code | Editor de código | Facilita edición PHP, navegación, terminal integrada y control de versiones Git. |
| Composer 2 | Dependencias PHP | Instala paquetes definidos en `composer.json` y `composer.lock`. |

No hay `package.json` en este proyecto, por lo que **no es necesario ejecutar `npm install`** para utilizar la versión entregada.


## 3. Diseño orientado a objetos y diagrama UML

**Diagrama de clases:** [`docs/diagrama_clases.mmd`](docs/diagrama_clases.mmd) (Mermaid, visible en GitHub) y [`docs/diagrama_clases.puml`](docs/diagrama_clases.puml) (PlantUML).

### Principales clases

| Clase | Responsabilidad / atributos esenciales | Relaciones / métodos |
|---|---|---|
| `User` | `id`, `name`, `email`, `password`, `rol` | `aspirante()`, `esPersonal()` |
| `ProgramaAcademico` | `id_programa`, `nombre`, `modalidad`, `activo` | `aspirantes()` |
| `Aspirante` | `id_aspirante`, `id_usuario`, `id_programa`, nombres, `estatus` | `usuario()`, `programa()`, `documentos()`, `pagos()`, `seguimientos()` |
| `Documento` | `id_documento`, `tipo_documento`, `ruta_archivo`, `estatus` | `aspirante()` |
| `Pago` | `id_pago`, `concepto`, `monto`, `estatus` | `aspirante()` |
| `Seguimiento` | `id_seguimiento`, `id_usuario`, `estatus`, `observaciones` | `aspirante()`, `usuario()` |

Los modelos heredan de `Illuminate\Database\Eloquent\Model` (excepto `User`, que hereda de `Authenticatable`). Las relaciones `hasOne`, `hasMany` y `belongsTo` se implementan con Eloquent, y los atributos asignables se limitan con `$fillable`. Los controladores `AuthController`, `AspiranteController`, `ProgramaController`, `DocumentoController`, `PagoController`, `SeguimientoController` y `DashboardController` gestionan las solicitudes HTTP y coordinan los modelos.

**Principios POO identificables:** abstracción del dominio en clases, herencia de modelos/controladores, encapsulación parcial mediante métodos y `$fillable`, composición/asociación mediante relaciones ORM, y reutilización de los métodos heredados de Eloquent. El código no contiene una capa `Service` independiente ni interfaces de dominio personalizadas: no se atribuyen patrones no implementados.

## 4. Estructura del repositorio

```text
crm_aspirantes/
├── app/
│   ├── Http/Controllers/          # Autenticación y módulos del CRM
│   └── Models/                    # User, ProgramaAcademico, Aspirante, Documento, Pago, Seguimiento
├── bootstrap/
├── config/
├── database/
│   ├── migrations/2026_01_01_000001_create_crm_tables.php
│   └── seeders/DatabaseSeeder.php
├── docs/
│   ├── diagrama_clases.mmd
│   └── diagrama_clases.puml
├── public/css/app.css
├── resources/views/              # Blade: auth, dashboard, aspirantes, programas
├── routes/web.php
├── tests/Feature/               # Sin pruebas automatizadas implementadas
├── .env.example
├── composer.json
├── composer.lock
└── artisan
```

## 5. Instalación desde cero (Windows, XAMPP y PowerShell)

**Prerequisitos:** PHP 8.2+ en terminal, Composer 2, extensiones PHP `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `xml` y una instancia MySQL accesible. Para esta versión use el código del **repositorio directamente**; **no cree otro proyecto Laravel ni reemplace sus archivos**.

1. Descargue o clone el repositorio, abra una terminal dentro de su raíz (donde está `artisan`) y verifique:

```powershell
php -v
composer --version
```

2. Instale las dependencias PHP:

```powershell
composer install
```

3. Cree su configuración local y la clave:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

4. Inicie MySQL desde XAMPP. En phpMyAdmin (`http://localhost/phpmyadmin`), ejecute:

```sql
CREATE DATABASE crm_aspirantes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

5. Ajuste `.env` de acuerdo con la conexión de MySQL. Ejemplo **solo para desarrollo local**:

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

6. Construya las tablas y los registros de ejemplo, limpie configuración y arranque:

```powershell
php artisan config:clear
php artisan migrate --seed
php artisan serve --host=127.0.0.1 --port=8000
```

7. Abra **http://127.0.0.1:8000/login**.

**Cuenta demo creada por el seeder (solo local):** correo `admin@crm.local`, contraseña `CrmDemo123!`.

## 6. Recorrido funcional para evaluación

1. Entre con `admin@crm.local` en un entorno **local de prueba**.
2. Compruebe el panel de indicadores y el catálogo de programas académicos precargados.
3. Cierre sesión y cree una cuenta de prueba en `/registro`.
4. Registre una solicitud de admisión seleccionando un programa académico activo.
5. Consulte su expediente y adjunte un PDF/JPG/PNG de prueba sin datos personales reales.
6. Inicie sesión como administrador para revisar el expediente, cambiar su estatus y agregar una observación.

## 7. Verificación y pruebas

Se recomienda ejecutar:

```powershell
php artisan route:list
php artisan migrate:status
php artisan test
```

## 8. Licencia

Proyecto preparado con fines académicos para la Maestría en Ingeniería y Desarrollo de Software (MIDS).
