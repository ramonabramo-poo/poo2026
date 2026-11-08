# Curso de Programación Orientada a Objetos con PHP (2026)

<p align="center"><img src="img/emojis/hola.webp" width="140" alt="Saludo del profesor"></p>

¡Bienvenidos y bienvenidas! 👋 Este repositorio es vuestro punto de partida: aquí iréis encontrando, clase a clase, la teoría, los ejemplos y los ejercicios del curso, desde lo más básico de la programación web hasta desarrollar aplicaciones completas con **Laravel**.

---

## <img src="img/emojis/explica.webp" width="40" alt=""> Presentación

Buenas, soy **Ramón Abramo**, profesor con más de 25 años de experiencia docente, y voy a acompañaros durante todo el curso.

No necesitáis saber programar. Empezaremos desde cero: qué es la programación web, qué hace cada tecnología, cómo se monta un entorno de trabajo… y solo entonces escribiremos nuestras primeras líneas de PHP. A partir de ahí iremos subiendo el nivel poco a poco, siempre con ejemplos pequeños que podréis escribir, probar y modificar vosotros mismos.

Mi forma de trabajar es sencilla: primero entender, luego practicar. Y preguntar todo lo que haga falta. 🙂

---

## <img src="img/emojis/ok.webp" width="40" alt=""> Objetivo del curso

Al terminar el curso seréis capaces de:

1. 🌐 **Entender cómo funciona la web**: cliente, servidor, frontend, backend y el papel de cada tecnología.
2. 🛠️ **Montar vuestro propio entorno de desarrollo** con Laragon y Visual Studio Code.
3. 🐘 **Programar en PHP**: variables, condiciones, bucles, arrays, funciones y formularios.
4. 🐬 **Trabajar con bases de datos MySQL** usando SQL y conectarlas con PHP.
5. 🧱 **Programar con orientación a objetos**: clases, objetos, herencia, interfaces y buenas prácticas.
6. 🏗️ **Entender cómo funciona un framework** construyendo nuestro propio MVC.
7. 🚀 **Desarrollar aplicaciones web completas con Laravel**.

---

## <img src="img/emojis/curioso.webp" width="40" alt=""> Esquema general del curso

![Hoja de ruta del curso](img/hoja-de-ruta.webp)

### Primeras clases

| Clase | Tema | Contenido |
|---|---|---|
| **1** | [🌍 El mundo de la programación hoy](clase-01-mundo-programacion/README.md) | Programación web y de escritorio, cliente y servidor, frontend, backend y fullstack, HTML, CSS, JavaScript, PHP y MySQL. **Solo teoría** |
| **2** | [🛠️ Entorno de desarrollo con Laragon](clase-02-entorno-laragon/README.md) | Instalación de Laragon 6, cambio de versión de PHP (NTS) y MySQL, carpeta raíz y virtual hosts automáticos |
| **3** | [🧩 Visual Studio Code y sus extensiones](clase-03-visual-studio-code/README.md) | Extensiones para PHP, HTML, CSS, JavaScript y Laravel, ajustes y atajos |
| **4 a 6** | [🐘 Primeros pasos con PHP](clase-04-primeros-pasos-php/README.md) | Ejemplos de introducción: phpinfo, sintaxis, variables, operadores, condicionales, bucles, arrays, funciones, formularios, errores y primera conexión con MySQL |

### PHP paso a paso

| Clase | Tema | Contenido |
|---|---|---|
| **7** | [🔢 Datos y operadores, ahora con calma](clase-07-datos-y-operadores/README.md) | Tipos, comillas, constantes, conversiones, `===`, `??`, ternario y formato de números |
| **8** | [🔀 Condicionales: tomar decisiones](clase-08-condicionales/README.md) | `if`, `elseif`, condiciones compuestas, pseudocódigo, `switch`, `match`, ternario, `?:`, `??`, `??=`, `?->` y `<=>` |
| **9** | [🔁 Bucles: repetir sin cansarse](clase-09-bucles/README.md) | `while`, `do…while`, `for`, primera visita a los arrays, `foreach`, patrones, `break`, `continue`, bucles anidados y en HTML |
| **10** | [🧰 Funciones](clase-10-funciones/README.md) | `echo` frente a `return`, parámetros, argumentos con nombre, tipos, `strict_types` y ámbito |
| **11** | [🗂️ Arrays y textos](clase-11-arrays-y-textos/README.md) | Arrays asociativos y tablas de datos, ordenar, `array_map`, textos con tildes, validar y fechas |
| **12** | [📝 Formularios, archivos y ficheros](clase-12-formularios-archivos/README.md) | Validar y escapar, XSS, ficheros JSON, *Post/Redirect/Get* y subida de archivos |
| **13** | [🔐 Sesiones, login y seguridad](clase-13-sesiones-seguridad/README.md) | Cookies y sesiones, contraseñas cifradas, login completo, XSS, inyección SQL y CSRF |
| **14** | [🧩 Organizar el código y controlar los errores](clase-14-organizar-codigo-errores/README.md) | `require_once`, cabecera y pie comunes, leer errores, depurar y excepciones |

### Bases de datos con PHP

| Clase | Tema | Contenido |
|---|---|---|
| **15** | [🐬 Bases de datos con PDO](clase-15-bases-datos-pdo/README.md) | Conexión con PDO, consultas preparadas, inyección SQL, `INSERT`, `UPDATE`, `DELETE` y transacciones |
| **16** | [🛠️ Proyecto CRUD paso a paso](clase-16-proyecto-crud/README.md) | Catálogo de cursos completo: listado con buscador y paginación, alta, edición, borrado seguro y login |

### Programación orientada a objetos

| Clase | Tema | Contenido |
|---|---|---|
| **17** | [🧱 Clases y objetos](clase-17-clases-y-objetos/README.md) | Clase y objeto, métodos y `$this`, constructor, encapsulación, `readonly`, `static` y una clase por archivo |
| **18** | [🌳 Herencia, interfaces y polimorfismo](clase-18-herencia-interfaces/README.md) | `extends`, `parent::`, clases abstractas, `final`, interfaces, polimorfismo y traits |
| **19** | [✨ PHP moderno y POO avanzada](clase-19-php-moderno/README.md) | `?tipo` y tipos unión, `?->`, enums, clases `readonly`, `__toString`, `clone` y excepciones propias |
| **20** | [📦 Namespaces, Composer y autocarga](clase-20-namespaces-composer/README.md) | Namespaces y `use`, autocarga, PSR-4, Composer e instalación de librerías como Carbon |
| **21** | [🗄️ Bases de datos con objetos](clase-21-bases-datos-objetos/README.md) | El CRUD rehecho con una clase de conexión, entidades, repositorios y excepciones propias |
| **22** | [🧹 Calidad y buenas prácticas](clase-22-calidad-buenas-practicas/README.md) | Nombres, funciones cortas, PSR-12, errores globales, inyección de dependencias, SOLID y herramientas |

### Nuestro propio MVC

| Clase | Tema | Contenido |
|---|---|---|
| **23** | [🏗️ Arquitectura MVC y front controller](clase-23-mvc-front-controller/README.md) | MVC, una sola puerta de entrada (`public/index.php`), `.htaccess`, controlador, vistas con layout y el modelo de la clase 21 |
| **24** | [🧭 Router, peticiones y respuestas](clase-24-router-peticiones/README.md) | Clases `Peticion` y `Respuesta`, un router con parámetros (`/cursos/{id}`), errores 404, 405 y 500 |
| **25** | [🧩 Controladores, vistas y modelos](clase-25-controladores-vistas-modelos/README.md) | `.env` propio, modelo base al estilo de Eloquent, vistas parciales, controlador base, excepciones HTTP y el CRUD completo |
| **26** | [⚙️ Servicios del framework](clase-26-servicios-framework/README.md) | Contenedor de dependencias con *autowiring*, middleware, validación con reglas, mensajes *flash*, autenticación y la comparativa con Laravel |
| **27** | [🔌 APIs REST con PHP puro](clase-27-api-rest/README.md) | API REST de cursos en JSON, verbos y códigos de estado, token `Bearer`, errores en JSON y cliente cURL |

### Laravel

| Clase | Tema | Contenido |
|---|---|---|
| **28** | [🚀 Primeros pasos con Laravel](clase-28-laravel-primeros-pasos/README.md) | Instalación, estructura del proyecto, ciclo de vida de una petición, `.env` y `config()`, primeras rutas y vistas, Artisan y Vite |
| **29** | [🧭 Rutas y controladores](clase-29-laravel-rutas-controladores/README.md) | Rutas con parámetros, restricciones, nombres y grupos; controladores, `Request`, controladores de recurso, *route model binding*, rutas de la API y comandos de consola |
| **30** | [🎨 Vistas con Blade](clase-30-laravel-blade/README.md) | Directivas de Blade, `$loop`, *layouts* con `@extends` y `@yield`, pilas, `@include`, componentes con `@props` y `$slot`, paso de datos y Vite |
| **31** | [🗃️ Base de datos: migraciones, seeders y factories](clase-31-laravel-base-datos/README.md) | Conexión a MySQL, migraciones y claves foráneas, modificar tablas, *factories* con Faker, *seeders* y el Query Builder |
| **32** | [🧬 Eloquent ORM](clase-32-laravel-eloquent/README.md) | Modelos y convenciones, CRUD, relaciones 1:1, 1:N y N:M, carga ansiosa y N+1, *scopes*, *casts*, *accessors* y *mutators*, borrado lógico y paginación |
| **33** | [📝 Formularios y validación](clase-33-laravel-formularios-validacion/README.md) | Protección CSRF, `validate()`, `old()` y `@error`, mensajes en español, *Form Requests*, el CRUD de cursos con `@method`, mensajes *flash* y subida de imágenes |
| **34** | [🔐 Autenticación y autorización](clase-34-laravel-autenticacion/README.md) | Login, registro y *logout* con `Auth`, middleware `auth`, `guest` y `throttle`, *starter kits*, roles con un enum, *gates* y *policies* |
| **35** | [⚙️ Arquitectura interna de Laravel](clase-35-laravel-arquitectura/README.md) | Servicios, contenedor con `bind` y `singleton`, *service providers* y *view composers*, contratos, *facades* propias, middleware con parámetros y la comparativa final con nuestro MVC |
| **36** | [🔌 API REST con Laravel](clase-36-laravel-api-rest/README.md) | API versionada con `apiResource`, *API Resources*, paginación y filtros, tokens con Sanctum, permisos con las *policies*, errores en JSON y documentación |
| **37** | [🧪 Pruebas](clase-37-laravel-pruebas/README.md) | PHPUnit y `php artisan test`, pruebas unitarias y de funcionalidad, base de datos de pruebas, *factories* y estados, `actingAs`, *fakes* y pruebas de la API |
| **38** | [🚀 Funcionalidades avanzadas](clase-38-laravel-avanzado/README.md) | Eventos y *listeners*, correo con *Mailables*, colas y *jobs*, notificaciones por correo y base de datos, caché, tareas programadas, logs y excepciones propias |
| **39** | [🏁 Proyecto final y despliegue](clase-39-laravel-proyecto-final/README.md) | La academia completa en `proyecto/`, buenas prácticas, revisión de código con Pint, preparación para producción, despliegue en un servidor con Nginx, Supervisor y `cron`, y el proyecto final |

### SQL con MySQL

Con la clase 39 termina el recorrido del curso. El itinerario de **SQL con MySQL** (diseño de tablas, consultas, funciones, agrupaciones y JOINs y, como ampliación, subconsultas, transacciones e índices) tiene **su propio repositorio**, aparte de este. En el temario veréis qué bloques conviene haber visto antes de la clase 15.

Consultad el **[temario detallado](TEMARIO.md)** para ver el contenido de cada bloque.

> 📌 El temario puede ajustarse según el ritmo del grupo.

---

## <img src="img/emojis/pensando.webp" width="40" alt=""> Estructura del repositorio

```text
cursoPoo2026/
├── README.md                        ← Estás aquí: presentación y esquema del curso
├── TEMARIO.md                       ← Temario detallado
├── img/                             ← Imágenes comunes
├── clase-01-mundo-programacion/     ← Clase 1: teoría de introducción
├── clase-02-entorno-laragon/        ← Clase 2: instalación y configuración de Laragon
├── clase-03-visual-studio-code/     ← Clase 3: VS Code y extensiones
├── clase-04-primeros-pasos-php/     ← Clases 4 a 6: ejemplos de introducción a PHP
│   └── ejemplos/                    ← Todos los ejemplos, numerados en orden
├── clase-07-datos-y-operadores/     ← Clases 7 a 14: PHP paso a paso
│   ├── ejemplos/                    ← Los ejemplos de la explicación
│   └── soluciones/                  ← Una solución de cada ejercicio
├── clase-08-condicionales/
├── clase-09-bucles/
├── ...
├── clase-14-organizar-codigo-errores/
├── clase-15-bases-datos-pdo/        ← Clase 15: bases de datos con PDO
├── clase-16-proyecto-crud/          ← Clase 16: proyecto CRUD (carpeta proyecto/)
├── clase-17-clases-y-objetos/       ← Clase 17: primera clase de POO
├── clase-18-herencia-interfaces/    ← Clase 18: herencia, interfaces y polimorfismo
├── clase-19-php-moderno/           ← Clase 19: PHP moderno y POO avanzada
├── clase-20-namespaces-composer/   ← Clase 20: namespaces, Composer y autocarga
├── clase-21-bases-datos-objetos/   ← Clase 21: el CRUD con objetos (carpeta proyecto/)
├── clase-22-calidad-buenas-practicas/ ← Clase 22: calidad y buenas prácticas
├── clase-23-mvc-front-controller/  ← Clases 23 a 27: nuestro propio MVC (carpeta proyecto/)
├── clase-24-router-peticiones/
├── clase-25-controladores-vistas-modelos/
├── clase-26-servicios-framework/
├── clase-27-api-rest/
├── clase-28-laravel-primeros-pasos/ ← Clases 28 a 39: Laravel (carpetas ejemplos/ con las rutas del proyecto)
├── clase-29-laravel-rutas-controladores/
├── clase-30-laravel-blade/
├── clase-31-laravel-base-datos/
├── clase-32-laravel-eloquent/
├── clase-33-laravel-formularios-validacion/
├── clase-34-laravel-autenticacion/
├── clase-35-laravel-arquitectura/
├── clase-36-laravel-api-rest/
├── clase-37-laravel-pruebas/
├── clase-38-laravel-avanzado/
├── clase-39-laravel-proyecto-final/ ← Clase 39: la academia completa (carpeta proyecto/) y el despliegue
└── ...                              ← Se irán añadiendo carpetas con cada clase
```

Cada carpeta tiene su propio `README.md` con la explicación de la clase y los mismos apuntes en **PDF** (📕), listos para descargar, imprimir o leer en la tableta.

---

## <img src="img/emojis/atencion.webp" width="40" alt=""> Qué vais a necesitar

No instaléis nada todavía: lo haremos juntos en la clase 2 y en la clase 3. Solo para que lo tengáis en el radar:

- 💻 Un ordenador con **Windows 10 u 11**.
- 🛠️ **Laragon 6.0**, que nos dará Apache, PHP y MySQL.
- 🧩 **Visual Studio Code** como editor.
- 🌐 Un navegador moderno: Chrome, Firefox o Edge.
- 🔀 Más adelante, **Git** para descargar el material y, de forma opcional, **Node.js** para Vite en Laravel.

---

## <img src="img/emojis/bien.webp" width="40" alt=""> Cómo trabajar durante el curso

- ⌨️ **Escribid el código vosotros**, no copiéis y peguéis: así es como se aprende.
- 🔧 **Modificad los ejemplos**, rompedlos y arregladlos. Es la mejor forma de entenderlos.
- 🙋 **Preguntad** cualquier duda, por básica que parezca.
- 🔁 **Repasad** la clase anterior antes de empezar la siguiente: cada una se apoya en lo que ya sabéis.

¡Empezamos! 👉 [Clase 1 · El mundo de la programación hoy](clase-01-mundo-programacion/README.md)

---

### Fuentes y Documentación Oficial

En esta presentación no he utilizado fuentes técnicas externas; cada clase incluye al final su propia documentación oficial.
