# API de la Academia Alpe · versión 1

Dirección base: `http://academia-laravel.test/api/v1`

Todas las peticiones y respuestas van en JSON. Enviad siempre la cabecera `Accept: application/json`.

## Autenticación

Las rutas marcadas con 🔒 necesitan un token en la cabecera:

```text
Authorization: Bearer 1|abcdef...
```

El token se pide con `POST /tokens`.

## Rutas

| Verbo | Dirección | 🔒 | Descripción | Respuesta correcta |
|---|---|---|---|---|
| POST | `/tokens` | | Pide un token. Cuerpo: `email`, `password`, `dispositivo` | 201 + `token` |
| DELETE | `/tokens/actual` | 🔒 | Anula el token usado en la petición | 200 |
| GET | `/yo` | 🔒 | Datos del usuario del token | 200 |
| GET | `/cursos` | | Cursos publicados, paginados | 200 |
| GET | `/cursos/{id}` | | Un curso | 200 |
| POST | `/cursos` | 🔒 | Crea un curso (editor o administrador) | 201 |
| PUT | `/cursos/{id}` | 🔒 | Modifica un curso (editor o administrador) | 200 |
| DELETE | `/cursos/{id}` | 🔒 | Borra un curso (solo administrador) | 204 |

### Parámetros de `GET /cursos`

| Parámetro | Ejemplo | Qué hace |
|---|---|---|
| `buscar` | `?buscar=php` | Filtra por el título |
| `categoria` | `?categoria=diseno` | Filtra por el *slug* de la categoría |
| `por_pagina` | `?por_pagina=5` | Cursos por página (máximo 50; 10 por defecto) |
| `page` | `?page=2` | Página que se quiere |

### Campos para crear o modificar un curso

| Campo | Reglas |
|---|---|
| `categoria_id` | Obligatorio; una categoría existente |
| `titulo` | Obligatorio; entre 3 y 120 caracteres; único |
| `descripcion` | Opcional; hasta 2000 caracteres |
| `horas` | Obligatorio; entero entre 1 y 500 |
| `precio` | Obligatorio; número entre 0 y 9999,99 |
| `plazas` | Obligatorio; entero entre 1 y 100 |
| `fecha_inicio` | Opcional; fecha (`AAAA-MM-DD`) a partir de hoy |
| `publicado` | Opcional; `true` o `false` |

## Errores

Todos los errores devuelven un objeto con `mensaje`:

| Código | Cuándo |
|---|---|
| 401 | Falta el token o no es válido |
| 403 | El usuario no tiene permiso para esa acción |
| 404 | El recurso no existe |
| 405 | Ese verbo no existe para esa dirección |
| 422 | Los datos no son válidos (además, `errors` con un array por campo) |
| 429 | Demasiadas peticiones: máximo 60 por minuto (5 para pedir tokens) |
