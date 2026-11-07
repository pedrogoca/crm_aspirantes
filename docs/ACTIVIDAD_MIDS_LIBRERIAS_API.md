# Actividad: Librerías y API — CRM de Aspirantes

**a) Identificación y justificación de tres librerías o API**

Como continuidad del Sistema Web de Registro y Seguimiento de Aspirantes (CRM), desarrollado con PHP, Laravel 12 y MySQL, se seleccionaron tres API integradas en el framework: **Eloquent ORM**, **Laravel Validation** y **Laravel Filesystem (Storage)**. Eloquent permite representar las tablas como objetos y gestionar sus relaciones sin escribir manualmente cada consulta SQL; se eligió porque favorece la reutilización de código y la organización mediante modelos. Validation permite verificar datos de registro y archivos antes de procesarlos; se utiliza para evitar información incompleta o con formatos no permitidos. Storage permite guardar y recuperar documentos del expediente del aspirante utilizando un sistema de archivos configurable; se eligió por su integración con Laravel y porque facilita el manejo ordenado de expedientes digitales.

**b) Implementación en el proyecto**

Las tres API ya están utilizadas en el código del CRM y se documentaron sus puntos de integración. Eloquent se observa en los modelos `Aspirante`, `ProgramaAcademico` y `User`, así como en las consultas del controlador de aspirantes. Validation aparece en los métodos `store()` de los controladores de aspirantes y documentos. Storage se implementa en `DocumentoController`, donde se guardan archivos en el disco `local` y se descargan tras verificar los permisos de acceso. Se corrigió adicionalmente la relación `User::aspirante()` para indicar que la clave foránea real es `id_usuario`.

**c) Código y evidencias de funcionamiento**

El repositorio incluye el código fuente y el archivo `README.md` con las instrucciones de instalación. Las evidencias consisten en: (1) el listado de aspirantes y sus programas, junto al código Eloquent; (2) la validación de un formulario con datos o archivo inválidos; y (3) la carga y descarga de un documento de prueba mediante Storage. Se adjuntarán capturas de pantalla de cada función ejecutada en el entorno local, así como de los fragmentos de código respectivos.

**Enlace de GitHub:** [PEGAR URL REAL DEL REPOSITORIO PUBLICADO]

**Conclusión**

La integración de estas API permite aplicar los principios de abstracción, modularidad y reutilización en un caso práctico de programación orientada a objetos, y proporciona una base para continuar el desarrollo funcional del CRM en la siguiente unidad.

## Evidencias verificables y ubicación

| Evidencia requerida | Archivo / pantalla sugerida | Estado |
|---|---|---|
| Código Eloquent | `AspiranteController::index`, `Aspirante::programa` | Incluido en el ZIP |
| Funcionamiento Eloquent | `/aspirantes` mostrando programas | Captura local pendiente |
| Código Validation | `DocumentoController::store` | Incluido en el ZIP |
| Funcionamiento Validation | Rechazo de archivo no permitido | Captura local pendiente |
| Código Storage | `DocumentoController::store` y `download` | Incluido en el ZIP |
| Funcionamiento Storage | Documento PDF de prueba cargado y descargado | Captura local pendiente |

**Nota de alcance:** Se emplean tres API propias de Laravel, no tres dependencias nuevas. No se comprobó la aplicación ejecutándose ni se obtuvieron capturas del navegador del usuario. La evidencia solo debe declararse completada después de verificarla.


## Ampliación: librería 4 JWT y librería 5 DomPDF

**JWT:** `php-open-source-saver/jwt-auth` implementa autenticación mediante tokens firmados para las rutas REST `/api/auth/login`, `/api/auth/me` y `/api/auth/logout`, con guard independiente `api` y control básico de intentos. Se eligió por su integración con autenticación y modelos de Laravel. Los tokens no sustituyen la sesión web existente.

**DomPDF:** `barryvdh/laravel-dompdf` transforma una vista Blade HTML en una ficha PDF descargable del aspirante. Su uso facilita la impresión y conservación de la información de su expediente, respetando los permisos de acceso configurados.

**Evidencias por obtener en el equipo local:** captura de Postman con respuesta JWT (token oculto), consulta protegida del usuario, botón de descarga, PDF obtenido y fragmentos de controlador. La entrega contiene código, no capturas funcionales verificadas.
