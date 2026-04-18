# Task API - Prueba Técnica Erick Bernett

## Descripción
API REST desarrollada con Laravel para gestión de tareas.
Incluye autenticación, integración con API externa, validación, manejo de errores y tests.

## Tecnologías
- PHP 8+
- Laravel 11
- MySQL
- Laravel Sanctum


## Arquitectura
El proyecto sigue una arquitectura basada en separación de responsabilidades:
- Controllers 
- Services 
- Requests 
- Resources
- Exceptions

## Autenticación
Se implementó autenticación basada en tokens usando Laravel Sanctum.

## Instalación
git clone -b main https://github.com/Erick-Jr-Bernett/task-api.git task-api
cd task-api
composer install
cp .env.example .env
php artisan key:generate

## Base de datos
php artisan migrate

## Ejecución
php artisan serve

## Endpoints
### Auth
- POST /api/register
- POST /api/login

### Tasks
- GET /api/tasks
- GET /api/tasks/{id}
- POST /api/tasks
- PUT /api/tasks/{id}
- DELETE /api/tasks/{id}

### External
- GET /api/tasks/{id}/suggestion


## Cómo probar la API
### 1. Registrar usuario
    POST /api/register

    Body:
    {
    "name": "Test",
    "email": "test@test.com",
    "password": "123456"
    }

    Respuesta:
    {
    "token": "..."
    }

### 2. Autenticación
## Login
    POST /api/login

    Body:
    {
    "email": "test@test.com",
    "password": "123456"
    }

    Respuesta:
    {
    "token": "..."
    }

Para los siguientes endpoints usar header:
Authorization: Bearer {token}
Accept: application/json

### 3. Crear tarea
    POST /api/tasks

    Body:
    {
    "title": "Mi tarea",
    "description": "Descripción"
    }

### 4. Listar tareas
    GET /api/tasks

### 5. Ver tarea
    GET /api/tasks/{id}

### 6. Actualizar tarea
    PUT /api/tasks/{id}

    Body:
    {
    "title": "Nueva tarea",
    "status": "completed"
    }

### 7. Eliminar tarea
    DELETE /api/tasks/{id}

### 8. API externa
    GET /api/tasks/{id}/suggestion

    Retorna una tarea junto con una sugerencia obtenida desde una API externa.
    La API externa utilizada no soporta internacionalización.
    En un entorno productivo, se integraría un servicio de traducción (ej. Google Translate) para adaptar las sugerencias al idioma del usuario.

## Formato de respuestas
Las respuestas siguen una estructura consistente:

{
  "data": ...
}

Errores:

{
  "message": "Error message",
  "errors": { ... }
}

## Códigos de estado
- 200 OK
- 201 Created
- 204 No Content (delete)
- 401 Unauthorized
- 404 Not Found
- 422 Validation error

## Notas
- Todos los endpoints requieren autenticación excepto register/login
- Las respuestas de error están estandarizadas
- Se implementó cache en la integración externa
- Los tokens de autenticación se gestionan mediante Laravel Sanctum.
- Por defecto no expiran, pero pueden configurarse según necesidades de seguridad.


## Tests
php artisan test

Incluye pruebas de:
- creación
- listado
- validación
- errores

## Decisiones técnicas
Uso de Service Layer para desacoplar lógica
Uso de API Resources para respuestas consistentes
Manejo global de errores centralizado
Uso de cache en integración externa

## Mejoras posibles
- Implementar paginación avanzada y filtros dinámicos
- Agregar documentación con Swagger / OpenAPI
- Implementar Docker para despliegue
- Aumentar cobertura de tests 
- Asociar tareas a usuarios (user_id) para identificar el creador y propietario de cada recurso
- Implementar auditoría de cambios para registrar quién crea, actualiza, completa o cancela tareas
- Registrar timestamps específicos por estado (completed_at, canceled_at) para trazabilidad del flujo