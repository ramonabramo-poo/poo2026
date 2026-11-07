# Temario detallado

> Temario **previsto**: puede ajustarse según el ritmo del grupo. Las clases 1 a 26 ya están publicadas. A partir de la Parte 2, la numeración corresponde a **bloques temáticos** (del 08 en adelante) (cada bloque puede ocupar una o varias clases), y cada uno tendrá su carpeta con apuntes, ejemplos y ejercicios resueltos.
>
> 🌱 El curso está pensado para personas **sin experiencia previa en programación**. Lo marcado con ⭐ es **para saber más**: se presenta para que os suene, pero no es imprescindible para seguir avanzando.

## Parte 0: Introducción y entorno (clases 1 a 6)

### Clase 1. El mundo de la programación hoy · [ver](clase-01-mundo-programacion/README.md)
- Qué es programar y qué es un lenguaje de programación
- Programación de escritorio frente a programación web
- Cliente, servidor y HTTP
- Frontend, backend y fullstack
- HTML, CSS, JavaScript, PHP, MySQL y Laravel: qué hace cada uno
- Recorrido del curso (solo teoría, sin instalar nada)

### Clase 2. Entorno de desarrollo con Laragon · [ver](clase-02-entorno-laragon/README.md)
- Instalación de Laragon 6 (última versión con licencia gratuita)
- Cambio de versión de PHP: siempre versiones NTS
- Cambio de versión de MySQL y copia de los datos
- Carpeta raíz de los proyectos y cómo cambiarla
- Virtual hosts automáticos (`proyecto.test`)

### Clase 3. Visual Studio Code y sus extensiones · [ver](clase-03-visual-studio-code/README.md)
- Instalación y uso básico
- Extensiones generales, de PHP, de HTML, CSS y JavaScript, de Laravel, de Git y de bases de datos
- Ajustes recomendados y atajos de teclado

### Clases 4 a 6. Primeros pasos con PHP · [ver](clase-04-primeros-pasos-php/README.md)
> Ejemplos de introducción para entender la programación web. Cada tema se estudia en profundidad en la Parte 1.
- **Clase 4:** qué es PHP, `phpinfo()`, primer script, sintaxis básica (`echo` y echo corto `<?=`), variables, tipos y operadores
- **Clase 5:** condicionales, `switch` y `match`, bucles, sintaxis alternativa, arrays y funciones
- **Clase 6:** formularios GET y POST, errores frecuentes, primera conexión con MySQL (PDO) y ejercicios

## Parte 1: PHP paso a paso (clases 7 a 13)

> Volvemos sobre lo visto en las clases 4 a 6, ahora despacio y con ejercicios resueltos. Todas las clases se trabajan en el proyecto `php-paso-a-paso` de Laragon.

### Clase 7 · Bloque 02. Datos y operadores · [ver](clase-07-datos-y-operadores/README.md)
- Las variables como cajas con etiqueta; los cinco tipos básicos y `var_dump()`
- Textos: comillas simples, dobles y llaves (`"{$variable}"`)
- Constantes con `const` y `define()`
- Conversión de tipos automática y forzada (*casting*); qué valores son «falsos»
- Comparación estricta: `==` frente a `===`
- `null`, el operador `??` y el operador ternario
- Operadores lógicos, precedencia y paréntesis (y por qué no usar `and`/`or`)
- Redondear y mostrar números: `round()`, `number_format()`, `intdiv()` y `%`
- Errores típicos: olvidar el `$`, guiones en los nombres, `echo` de un `false`

### Clase 8 · Bloque 03. Decidir y repetir · [ver](clase-08-decidir-y-repetir/README.md)
- Pensar antes de programar: pseudocódigo y pruebas de todos los caminos
- `if`, `elseif` y `else` sin anidar: descartar primero los casos que no cumplen
- La trampa de `if ($x = 10)`
- `match` (y `UnhandledMatchError`) frente a `elseif`
- Qué bucle elegir: `for`, `while`, `do while` y `foreach`
- Patrones imprescindibles: contador, acumulador y buscar el máximo
- Bucles infinitos, `break`, `continue` y bucles anidados

### Clase 9 · Bloque 04. Funciones · [ver](clase-09-funciones/README.md)
- Por qué usar funciones: el principio DRY
- `echo` frente a `return`
- Parámetros con valor por defecto y argumentos con nombre
- Tipos de parámetros y de retorno (`void`, `bool`…) y `declare(strict_types=1)`
- Ámbito de las variables
- Primer vistazo a las funciones flecha (`fn`)
- Cómo escribir buenas funciones
- ⭐ Paso por referencia, funciones variádicas y *closures* con `use` (se retoman en la Parte 2)

### Clase 10 · Bloque 05. Arrays y textos · [ver](clase-10-arrays-y-textos/README.md)
- Arrays indexados, asociativos y multidimensionales (tablas de datos)
- Añadir, modificar y eliminar elementos; `print_r()`
- Funciones útiles: `count`, `in_array`, `array_key_exists`, `array_search`, `array_merge`…
- Ordenar: `sort`, `rsort`, `asort`, `arsort` y `ksort`
- `array_map()` y `array_filter()`
- Textos con tildes: funciones `mb_`; `trim`, `str_contains`, `str_replace`…
- `explode()` e `implode()`
- Validar emails con `filter_var()`; ⭐ primeras expresiones regulares
- Fechas con `date()` y `DateTime`; zona horaria
- ⭐ Desestructuración, operador *spread* (`...`) y `array_reduce`

### Clase 11 · Bloque 06 (I). Formularios, archivos y ficheros · [ver](clase-11-formularios-archivos/README.md)
- `$_GET` y `$_POST`: cuándo usar cada uno
- El patrón del formulario profesional: `REQUEST_METHOD`, recoger, validar y conservar datos
- Validar en el servidor con `filter_var()`, longitudes y listas de valores
- Escapar la salida con `htmlspecialchars()` y ataques XSS
- Guardar datos en ficheros JSON
- Patrón *Post/Redirect/Get*, `header()` y `exit`
- Subida de archivos con `$_FILES` de forma segura
- ⭐ Leer y escribir ficheros CSV

### Clase 12 · Bloque 06 (II). Sesiones, login y seguridad · [ver](clase-12-sesiones-seguridad/README.md)
- Por qué la web no tiene memoria: cookies frente a sesiones
- Sesiones con `session_start()` y `$_SESSION`
- Cookies con `setcookie()` y sus opciones de seguridad
- Contraseñas con `password_hash()` y `password_verify()`
- Un login completo: inicio de sesión, páginas protegidas y cierre de sesión
- Los tres ataques que hay que conocer: XSS, inyección SQL y CSRF
- Tokens CSRF en los formularios

### Clase 13 · Bloque 07. Organizar el código y controlar los errores · [ver](clase-13-organizar-codigo-errores/README.md)
- `include`, `require` y `require_once`; rutas con `__DIR__`
- Una web con cabecera, menú y pie comunes
- Leer los mensajes de error: *parse error*, *fatal error*, `TypeError`, *warning*…
- Depurar con método: `var_dump()`, `print_r()` y `dd()`; ⭐ Xdebug
- Excepciones: `try`, `catch`, `finally` y `throw`
- Errores en desarrollo y en producción: `display_errors` y registro de errores

## Parte 2: Bases de datos con PHP

> Antes del bloque 08 conviene haber visto los bloques S01 a S06 del itinerario de SQL.

### Clase 14 · Bloque 08. Bases de datos con PDO · [ver](clase-14-bases-datos-pdo/README.md)
- La despensa: tablas, filas, columnas, clave primaria y clave foránea; `utf8mb4`
- La base de datos de prácticas `academia_alpe` (cursos y alumnos)
- Repaso de SQL: `SELECT`, `INSERT`, `UPDATE` y `DELETE` (siempre con `WHERE`) e `INNER JOIN`
- Conexión con PDO: DSN, `ERRMODE_EXCEPTION`, `FETCH_ASSOC` y sin emulación de consultas preparadas
- Leer datos: `query()`, `fetch()`, `fetchAll()` y `fetchColumn()`
- Consultas preparadas con `prepare()` y `execute()` y marcadores con nombre: adiós a la inyección SQL
- Escribir datos: `lastInsertId()`, `rowCount()`, valores duplicados y borrar siempre por POST
- Transacciones: todo o nada (`beginTransaction`, `commit`, `rollBack`)
- Botiquín de errores típicos de base de datos

### Clase 15 · Bloque 09. Proyecto CRUD paso a paso · [ver](clase-15-proyecto-crud/README.md)
- Qué es un CRUD y qué vamos a construir: el catálogo de cursos de la academia
- Estructura de carpetas: configuración, piezas comunes y páginas cortas
- Caja de herramientas: `redirigir()` (tipo `never`), mensajes *flash*, CSRF y guardián de login
- Todas las consultas de una tabla en su propio archivo
- Listado con buscador y paginación (`LIMIT`, `OFFSET` y `bindValue`)
- Alta con validación y un formulario compartido con la edición
- Edición con formulario precargado
- Borrado seguro: solo POST, confirmación, token CSRF y clave foránea
- Login contra la base de datos con contraseñas cifradas
- Lista de pruebas para dar el proyecto por terminado

## Parte 3: Programación orientada a objetos

### Clase 16 · Bloque 10. Clases y objetos · [ver](clase-16-clases-y-objetos/README.md)
- Por qué objetos: los problemas de los arrays sueltos
- El molde y la galleta: clase, objeto, `new` y la flecha `->`
- Métodos y `$this`
- El constructor y la promoción de propiedades en el constructor (PHP 8)
- Encapsulación: `public`, `private` (y `protected`, que se usa con la herencia)
- *Getters*, *setters* y propiedades `readonly`
- Constantes de clase, propiedades y métodos `static`, `self::` y `::`
- Una clase por archivo, cargada con `require_once`; del array de la base de datos al objeto con `desdeArray()`
- Errores típicos con objetos

### Clase 17 · Bloque 11. Herencia, interfaces y polimorfismo · [ver](clase-17-herencia-interfaces/README.md)
- El problema del código repetido entre clases
- Herencia con `extends` y la prueba del «es un»
- `parent::__construct()`, sobrescribir métodos y `parent::metodo()`; ahora sí, `protected`
- Clases y métodos abstractos; `final`
- Interfaces: el contrato (`implements`) y las interfaces como tipo de un parámetro
- Polimorfismo: la misma orden, distintas respuestas; `instanceof`
- Traits: compartir código entre clases que no son familia
- ¿Herencia, interfaz o trait?
- Clases en archivos: el padre se carga primero

### Clase 18 · Bloque 12. PHP moderno y POO avanzada · [ver](clase-18-php-moderno/README.md)
- Tipos *nullable* (`?string`) y tipos unión (`int|float`)
- Operador *nullsafe* (`?->`) junto con `??`
- Enumeraciones (`enum`): casos, `name`, `cases()` y `match`
- Enums respaldados: `value`, `from()`, `tryFrom()` y métodos dentro del enum
- Clases `readonly`: objetos inmutables (ejemplo con dinero en céntimos)
- `__toString()`, comparación de objetos (`==` frente a `===`) y `clone`
- Excepciones propias que heredan de las de PHP y traen sus datos
- ⭐ Otros métodos mágicos, enlace estático tardío (`static::`) y tipos *intersection*

### Clase 19 · Bloque 13. Namespaces, Composer y autocarga · [ver](clase-19-namespaces-composer/README.md)
- El problema: `require_once` por todas partes y nombres de clase que chocan
- Namespaces: el «apellido» de las clases; `Clase::class`
- `use` y alias con `as`; las clases de PHP (`DateTime`, `PDO`…) dentro de un namespace
- La autocarga hecha a mano con `spl_autoload_register()`
- PSR-4: namespace = carpetas, clase = archivo
- Composer: `composer.json`, `composer dump-autoload` y `vendor/autoload.php`
- Instalar librerías de terceros: Carbon para las fechas
- `composer.json`, `composer.lock` y `vendor/`; `install`, `update` y `require`
- ⭐ Scripts de Composer

### Clase 20 · Bloque 14. Bases de datos con objetos · [ver](clase-20-bases-datos-objetos/README.md)
- El proyecto CRUD de la clase 15 rehecho con clases, Composer y PSR-4
- Una clase `Conexion` que reutiliza una sola conexión (idea del *Singleton*)
- Entidades: `Curso` y `Usuario`, con `desdeFila()`, `desdeFormulario()` y su propia validación
- Patrón *Repository*: `CursoRepositorio` y `UsuarioRepositorio`, los únicos que hablan SQL
- Inyección de dependencias: el repositorio recibe la conexión en el constructor
- Un `guardar()` que decide entre `INSERT` y `UPDATE`
- Excepciones propias para traducir los errores de MySQL
- La sesión en una clase; `files` en la autocarga de Composer
- ⭐ Un repositorio en memoria con la misma interfaz

### Clase 21 · Bloque 15. Calidad y buenas prácticas · [ver](clase-21-calidad-buenas-practicas/README.md)
- Qué es código de calidad: se lee, se cambia sin miedo y se puede probar
- Nombres que se explican solos; números mágicos con nombre
- Funciones cortas; DRY, KISS y YAGNI
- Estilo común con PSR-12 y formateo automático
- Manejo global de errores con `set_exception_handler()` y `set_error_handler()`
- Inyección de dependencias explicada sin complicaciones
- Principios SOLID, con ejemplos de responsabilidad única y abierto/cerrado
- ⭐ PHPStan, PHPUnit y PHP-CS-Fixer en un proyecto pequeño
- ⭐ Patrones de diseño: *Repository*, *Singleton*, *Factory*, *Strategy* y *Observer*

## Itinerario paralelo: SQL con MySQL

> Se imparte a lo largo del curso, **antes de empezar PDO (bloque 08)**: lo ideal es empezar tras la clase 8 o 9 e ir alternando con PHP. Los bloques S01 a S06 son **imprescindibles**; S07 a S09 son de **ampliación** ⭐ y se pueden dejar para el final.

### S01. Introducción a las bases de datos
- Qué es una base de datos y modelo relacional: tablas, filas, columnas, claves
- Servidor y clientes MySQL (HeidiSQL, phpMyAdmin, línea de comandos)
- Crear y usar una base de datos, juegos de caracteres (`utf8mb4`)

### S02. Definición de datos (DDL)
- `CREATE`, `ALTER`, `DROP` y `TRUNCATE`
- Tipos de datos: numéricos, texto, fechas, `ENUM`, `JSON`
- Restricciones: `PRIMARY KEY`, `AUTO_INCREMENT`, `NOT NULL`, `UNIQUE`, `DEFAULT`, `CHECK`

### S03. Manipulación y consulta básica
- `INSERT`, `UPDATE` y `DELETE`
- `SELECT`: columnas, alias y `DISTINCT`
- Filtros con `WHERE`: operadores, `AND`/`OR`/`NOT`, `IN`, `BETWEEN`, `LIKE`, `IS NULL`
- `ORDER BY`, `LIMIT` y paginación

### S04. Funciones y expresiones
- Funciones de cadenas, numéricas y de fecha
- `CASE`, `IF`, `IFNULL` y `COALESCE`
- Conversión de tipos

### S05. Agregación y agrupación
- `COUNT`, `SUM`, `AVG`, `MIN`, `MAX`
- `GROUP BY` y `HAVING`
- Diferencia entre `WHERE` y `HAVING`

### S06. Diseño relacional y JOINs
- Diagramas entidad-relación y relaciones 1:1, 1:N y N:M
- Claves foráneas e integridad referencial
- Normalización explicada con ejemplos (1FN, 2FN, 3FN)
- `INNER JOIN` y `LEFT JOIN` (⭐ `RIGHT JOIN`, `CROSS JOIN` y *self join*)
- Taller: diseño de la base de datos de una academia, paso a paso

### S07. ⭐ Consultas avanzadas
- Subconsultas y subconsultas correlacionadas, `EXISTS`
- `UNION` y operaciones de conjuntos
- Expresiones de tabla comunes (`WITH`) y recursivas
- Funciones de ventana: `ROW_NUMBER`, `RANK`, `LAG`, `LEAD`, `SUM() OVER`
- Vistas

### S08. ⭐ Transacciones, índices y rendimiento
- Transacciones y propiedades ACID, niveles de aislamiento
- Índices y análisis de consultas con `EXPLAIN`
- Optimización de consultas
- Motores de almacenamiento (InnoDB)

### S09. ⭐ Programación en MySQL y administración
- Procedimientos almacenados y funciones
- *Triggers* y eventos
- Trabajo con `JSON` en MySQL
- Usuarios y privilegios
- Copias de seguridad y restauración (`mysqldump`), importación y exportación

## Parte 4: Construimos nuestro propio MVC

> Objetivo: construir paso a paso un pequeño *framework* MVC para entender cómo funcionan Laravel y cualquier otro framework por dentro.

### Clase 22 · Bloque 16. Arquitectura MVC y front controller · [ver](clase-22-mvc-front-controller/README.md)
- Qué es MVC: modelo, vista y controlador (la analogía del restaurante)
- El problema de los archivos sueltos y el *front controller*
- Estructura de carpetas: solo `public/` es visible desde el navegador
- Reescritura de URLs con `.htaccess` y rutas bonitas (`/cursos/5`)
- El recorrido completo de una petición
- El primer controlador
- Vistas sin lógica y un *layout* común con `extract()` y `ob_start()`
- El modelo de la clase 20, reutilizado sin cambios

### Clase 23 · Bloque 17. Router, peticiones y respuestas · [ver](clase-23-router-peticiones/README.md)
- Del `if/elseif` a una lista de rutas en `config/rutas.php`
- La clase `Peticion`: método, ruta, `$_GET` y `$_POST` en un objeto
- La clase `Respuesta`: contenido, código de estado y cabeceras; un único `enviar()`
- El router por dentro: `get()`, `post()` y `despachar()`
- Parámetros dinámicos (`/cursos/{id}`) con grupos con nombre
- Rutas atendidas por funciones anónimas
- Errores 404 y 405 y página 500 con el manejador global de errores
- El modo depuración y por qué se desactiva en producción

### Clase 24 · Bloque 18. Controladores, vistas y modelos · [ver](clase-24-controladores-vistas-modelos/README.md)
- Configuración y variables de entorno en un `.env` (y por qué no se sube a Git)
- Un modelo base (mini ORM) al estilo de Eloquent: `Curso::buscar()`, `$curso->guardar()`
- Enlace estático tardío (`static::`) y lista blanca de columnas
- *Repository* frente a *Active Record*
- Motor de vistas con *layout* y vistas parciales
- Controlador base: `vista()`, `redirigir()`, `noEncontrado()` y CSRF
- Excepciones HTTP para los errores 403, 404 y 405
- Las siete rutas y acciones de un recurso; código 422 para datos no válidos

### Clase 25 · Bloque 19. Servicios del framework · [ver](clase-25-servicios-framework/README.md)
- Contenedor de inyección de dependencias y *autowiring* con `Reflection`
- Middleware: las capas entre la petición y el controlador
- Middleware global y grupos de rutas protegidas
- Mensajes *flash* que duran exactamente una petición
- Validación con reglas (`obligatorio|min:3`) que vuelve atrás con los errores y los datos
- Autenticación sencilla como servicio y modelo `Usuario`
- Funciones de atajo para las vistas: `auth()`, `viejo()`, `error()`, `campoCsrf()`
- Comparativa: qué parte de nuestro MVC equivale a cada pieza de Laravel

### Clase 26 · Bloque 20. APIs REST con PHP puro · [ver](clase-26-api-rest/README.md)
- Qué es una API REST: recursos, verbos HTTP y códigos de estado
- Responder en JSON con `Respuesta::json()` y la interfaz `JsonSerializable`
- Recibir datos en JSON desde `php://input`
- Rutas `PUT` y `DELETE` en el router y API de ejemplo con nuestro MVC
- Proteger la API con un token `Bearer` (y por qué no necesita CSRF)
- Errores de la API en JSON: 401, 404, 405, 409, 422 y 500
- Probar la API con el navegador, Thunder Client, Postman o `curl`
- Consumir APIs (propias y externas) con cURL

## Parte 5: Laravel 13

### 21. Primeros pasos con Laravel
- Instalación y estructura del proyecto
- Ciclo de vida de una petición
- Configuración y archivo `.env`
- Artisan y comandos básicos
- Frontend con Vite

### 22. Rutas y controladores
- Rutas básicas, con parámetros, nombradas y agrupadas
- Controladores y controladores de recurso
- *Route model binding*
- Rutas de la API y de la consola

### 23. Vistas con Blade
- Sintaxis y directivas de Blade
- *Layouts*, secciones y componentes
- Paso de datos a las vistas
- Recursos estáticos y Vite

### 24. Base de datos: migraciones, seeders y factories
- Configuración de la base de datos
- Migraciones y modificación de tablas
- *Seeders* y *factories*
- Query Builder

### 25. Eloquent ORM
- Modelos y convenciones
- CRUD con Eloquent
- Relaciones: uno a uno, uno a muchos, muchos a muchos
- Carga ansiosa (*eager loading*) y problema N+1
- *Scopes*, *accessors*, *mutators* y *casts*
- Borrado lógico (*soft deletes*)
- Paginación

### 26. Formularios y validación
- Peticiones (`Request`) y validación
- *Form Requests*
- Mensajes de error personalizados
- Protección CSRF
- Subida y almacenamiento de archivos

### 27. Autenticación y autorización
- Sesiones y autenticación
- *Starter kits* oficiales
- *Gates* y *policies*
- Roles y permisos

### 28. Arquitectura interna de Laravel
- Contenedor de servicios (*service container*)
- *Service providers*
- *Facades* y contratos
- Middleware
- Comparación con nuestro MVC

### 29. API REST con Laravel
- *API Resources*
- Autenticación de APIs (tokens)
- Versionado, paginación y gestión de errores
- Documentación de la API

### 30. Pruebas
- Pruebas unitarias y de funcionalidad (*feature tests*)
- Base de datos de pruebas
- *Factories* en los tests

### 31. Funcionalidades avanzadas
- Eventos y *listeners*
- Colas (*queues*) y *jobs*
- Correo electrónico y notificaciones
- Caché
- Tareas programadas (*scheduler*)
- Registros (*logs*) y manejo de excepciones

### 32. Proyecto final y despliegue
- Desarrollo de un proyecto completo en grupo o individual
- Buenas prácticas y revisión de código
- Preparación y despliegue en un servidor

## Material de consulta

> Se irá publicando a lo largo del curso para tenerlo siempre a mano.

- **Chuleta rápida:** sintaxis, superglobales y códigos de estado HTTP
- **Atajos y extensiones** de Visual Studio Code
- **Botiquín de emergencias:** los errores típicos del principiante (PHP, bases de datos y POO) y su solución
- **Glosario** de términos para el futuro desarrollador
