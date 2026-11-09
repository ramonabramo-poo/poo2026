# Clase 39 · Proyecto final y despliegue

<p align="center"><img src="../img/emojis/hola.webp" width="120" alt="El profesor, saludando"></p>

> 📕 **Apuntes en PDF:** [clase-39-laravel-proyecto-final.pdf](clase-39-laravel-proyecto-final.pdf)

Llegamos a la última clase. Empezamos el curso sin saber qué era una variable, y hoy tenemos una aplicación con rutas, vistas, base de datos, relaciones, formularios, usuarios con roles, una API con tokens, pruebas automáticas, colas, correos y tareas programadas. No está nada mal, ¿eh? 😄

Hoy hacemos tres cosas: **juntar** la academia completa en una carpeta, aprender a **revisar** el código como se hace en una empresa y, sobre todo, **publicarla en Internet**, que una web que solo funciona en vuestro ordenador es media web. Y al final os propongo vuestro **proyecto final**.

---

## Índice

- [Cómo vamos a trabajar](#-cómo-vamos-a-trabajar)
1. [La academia completa](#-1-la-academia-completa)
2. [Instalar el proyecto desde cero](#-2-instalar-el-proyecto-desde-cero)
3. [Buenas prácticas en Laravel](#-3-buenas-prácticas-en-laravel)
4. [Revisión de código](#-4-revisión-de-código)
5. [Preparar la aplicación para producción](#-5-preparar-la-aplicación-para-producción)
6. [Dónde publicar una aplicación Laravel](#-6-dónde-publicar-una-aplicación-laravel)
7. [Despliegue paso a paso en un servidor](#-7-despliegue-paso-a-paso-en-un-servidor)
8. [Actualizar sin romper nada](#-8-actualizar-sin-romper-nada)
9. [El proyecto final](#-9-el-proyecto-final)
10. [Ejercicios](#-10-ejercicios)
11. [Lo que tenéis que llevaros del curso](#-11-lo-que-tenéis-que-llevaros-del-curso)

---

## <img src="../img/emojis/ok.webp" width="40" alt=""> Cómo vamos a trabajar

Esta clase es de proyecto, así que en lugar de `ejemplos/` tiene dos carpetas:

```text
proyecto/      ← la academia COMPLETA: todos los ficheros nuestros de las clases 28 a 38
despliegue/    ← los ficheros de configuración del servidor
   deploy.sh                       ← el script para actualizar la aplicación
   nginx-academia.conf             ← la configuración del servidor web
   supervisor-academia-worker.conf ← mantiene vivo el worker de la cola
   crontab.txt                     ← la línea del planificador de tareas
```

---

## <img src="../img/emojis/genial.webp" width="40" alt=""> 1. La academia completa

Esto es lo que hace nuestra aplicación y en qué clase lo construimos:

| Funcionalidad | Dónde está | Clase |
|---|---|---|
| Configuración propia y comandos de Artisan | `config/academia.php`, `routes/console.php` | 27 y 28 |
| Portada, contacto y listado de cursos con buscador | `PaginaController`, `CursoController` | 28 |
| Layout, menú y componentes | `resources/views/layouts`, `components` | 29 |
| Tablas, datos de prueba y consultas | `database/` | 30 |
| Modelos con relaciones, *scopes*, *accessors* y paginación | `app/Models` | 31 |
| CRUD de cursos con imagen y validación en español | `CursoRequest`, `lang/es` | 32 |
| Login, registro, roles, *gates* y *policies* | `Auth/`, `Rol`, `CursoPolicy` | 33 |
| Servicios, contratos, fachada, middleware y *view composer* | `app/Servicios`, `AcademiaServiceProvider` | 34 |
| API REST versionada con tokens | `Api/V1`, `Resources`, `routes/api.php` | 35 |
| 24 pruebas automáticas | `tests/` | 36 |
| Matrícula con evento, correos en cola, notificaciones, caché y tareas programadas | `Events`, `Listeners`, `Mail`, `Notifications`, `Jobs` | 37 |

Además, para esta última versión he pasado **Pint** por todo el código (lo vemos en el punto 4).

> 💡 He dejado también las rutas de práctica de las primeras clases (`/hola`, `/blade`, `/edad/{edad}`…). En vuestro proyecto final, borrad todo lo que no forme parte de la aplicación.

---

## <img src="../img/emojis/ok.webp" width="40" alt=""> 2. Instalar el proyecto desde cero

Si os habéis perdido alguna clase o queréis empezar limpios, así se monta la academia completa:

```bash
composer create-project laravel/laravel academia-laravel
```

```bash
cd academia-laravel
composer require laravel/sanctum
```

Después:

1. Borrad `tests/Feature/ExampleTest.php` y `tests/Unit/ExampleTest.php`.
2. Copiad el contenido de [`proyecto/`](proyecto/) encima de la carpeta del proyecto (incluido el fichero oculto `.env.example`).
3. Cread en HeidiSQL la base de datos `academia_laravel`.
4. Y ejecutad:

```bash
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan test
```

En Windows, si `cp` no funciona en vuestra terminal, copiad y renombrad el fichero desde el explorador. Para tener **todo** funcionando, abrid además dos terminales más:

```bash
php artisan queue:work      # los correos y las notificaciones (clase 38)
php artisan schedule:work   # las tareas programadas (clase 38)
```

Los usuarios del *seeder* son `ramon@`, `marta@` y `pablo@academia-alpe.test`, con la contraseña `password` (clase 34).

---

## <img src="../img/emojis/explica.webp" width="40" alt=""> 3. Buenas prácticas en Laravel

Todo lo que hemos ido diciendo a lo largo del bloque, junto en una lista:

**Organización**

- Controladores **delgados**: reciben la petición, llaman a quien haga el trabajo y devuelven la respuesta. La validación, en *Form Requests*; los permisos, en *policies*; la lógica de negocio, en servicios o modelos.
- Una clase, una tarea. Si un método no cabe en la pantalla, probablemente hace demasiado.
- Seguid las **convenciones** de Laravel: nombres de tablas, rutas de recurso, carpetas… El que venga detrás os lo agradecerá.

**Base de datos**

- Siempre **migraciones**; nunca cambiéis la estructura a mano en HeidiSQL.
- Una migración ya compartida no se modifica: se crea otra.
- `with()` y `withCount()` para evitar el problema N+1 (y `preventLazyLoading()` para que os avise).
- `Fillable` en todos los modelos: nunca `create($request->all())`.

**Seguridad**

- Validad **todo** lo que llega del usuario, en el servidor.
- `{{ }}` en las vistas; `{!! !!}` solo con HTML vuestro.
- `@csrf` en cada formulario y `POST` para todo lo que cambie datos.
- Autorizad en el servidor (rutas, controladores, *Form Requests*), no solo ocultando botones.
- El `.env` nunca va a Git, y en producción `APP_DEBUG=false`.

**Configuración**

- `env()` solo dentro de `config/`; en el código, `config()`.
- Nada de valores «mágicos» repetidos (el IVA, el teléfono): a `config/academia.php`.

**Calidad**

- Pruebas para lo importante, y una prueba nueva por cada error que arregléis.
- Pint antes de cada *commit*.
- Commits pequeños, con mensajes que expliquen el **porqué**.

---

## <img src="../img/emojis/curioso.webp" width="40" alt=""> 4. Revisión de código

En un equipo, nadie sube código a la rama principal sin que **otra persona lo revise**. Se hace con las ***pull requests*** de GitHub (o *merge requests* de GitLab): proponéis vuestros cambios en una rama, un compañero los lee, comenta y, cuando todo está bien, se fusionan. Sirve para encontrar errores, pero sobre todo para **aprender unos de otros**.

### Antes de pedir una revisión: las herramientas

Lo primero es que las máquinas revisen lo que pueden revisar solas.

**Pint** viene instalado con Laravel y deja el código con un estilo uniforme [1]:

```bash
./vendor/bin/pint          # corrige el estilo de todos los ficheros
./vendor/bin/pint --test   # solo avisa, sin cambiar nada
```

Pint usa por defecto el estilo de Laravel, que tiene un par de diferencias con el que hemos usado en el curso. En [`pint.json`](proyecto/pint.json) lo adaptamos:

```json
{
    "preset": "laravel",
    "exclude": [
        "bootstrap",
        "config",
        "public"
    ],
    "rules": {
        "concat_space": {
            "spacing": "one"
        },
        "php_unit_method_casing": {
            "case": "camel_case"
        },
        "new_with_parentheses": {
            "named_class": true,
            "anonymous_class": false
        }
    }
}
```

- `concat_space`: un espacio a cada lado del punto al concatenar (`'Hola ' . $nombre`), como hemos escrito siempre.
- `php_unit_method_casing`: los nombres de las pruebas en *camelCase* (`unEditorPuedeCrearUnCurso`), como el resto de métodos.
- `exclude`: no tocamos los ficheros que trae Laravel.

Cuando lo pasé por la academia, cambió cosas como esta, que Laravel prefiere en una línea:

```php
// Antes
public function __construct(
    public Curso $curso,
) {
}

// Después de Pint
public function __construct(
    public Curso $curso,
) {}
```

> 💡 **Larastan** (`larastan/larastan`) es PHPStan (clase 22) adaptado a Laravel: encuentra errores de tipos, métodos que no existen o relaciones mal escritas **sin ejecutar** el código.

### Qué mirar en una revisión

| Pregunta | Ejemplo de comentario |
|---|---|
| ¿Funciona? ¿Hay pruebas? | «¿Qué pasa si el curso no tiene fecha de inicio? Añadiría una prueba» |
| ¿Es seguro? | «Este `orderBy()` usa un dato de la URL sin comprobarlo» |
| ¿Valida y autoriza? | «Falta el `Gate::authorize()` en `destroy()`» |
| ¿Hay consultas de más? | «Aquí hay un N+1: falta un `with('categoria')`» |
| ¿Se entiende? | «`$d` no dice nada; ¿`$descuento`?» |
| ¿Está en su sitio? | «Este cálculo se repite en la API: lo llevaría a un servicio» |
| ¿Sigue las convenciones? | «La tabla debería llamarse `profesores` y el modelo `Profesor`» |

Y dos normas de convivencia: se comenta **el código, no a la persona** («esta función es larga», no «haces funciones larguísimas»), y se explica **por qué** se propone un cambio.

---

## <img src="../img/emojis/atencion.webp" width="40" alt=""> 5. Preparar la aplicación para producción

**Producción** es el servidor donde la usan los clientes de verdad. Allí, la configuración cambia [2]:

```ini
APP_NAME="Academia Alpe"
APP_ENV=production
APP_KEY=base64:...            # una NUEVA, generada en el servidor
APP_DEBUG=false               # ¡IMPRESCINDIBLE!
APP_URL=https://academia-alpe.es

LOG_CHANNEL=daily
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=academia
DB_USERNAME=academia          # un usuario propio, nunca root
DB_PASSWORD=una-contraseña-larga-y-difícil

QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=smtp              # un servidor de correo de verdad
MAIL_HOST=smtp.proveedor.com
MAIL_USERNAME=...
MAIL_PASSWORD=...
```

> ⚠️ Con `APP_DEBUG=true` en producción, cualquier error enseña al mundo vuestro código, las rutas del servidor y, a veces, las contraseñas del `.env`. Es el fallo de seguridad más común en aplicaciones Laravel publicadas.

### Optimizar

En producción, Laravel puede juntar la configuración, las rutas, las vistas y los eventos en ficheros de caché, para no leerlos en cada petición:

```bash
php artisan optimize        # config:cache + route:cache + view:cache + event:cache
php artisan optimize:clear  # deshace todo lo anterior
```

Recordad lo de la clase 28: con la configuración en caché, `env()` fuera de `config/` devuelve `null`.

---

## <img src="../img/emojis/pensando.webp" width="40" alt=""> 6. Dónde publicar una aplicación Laravel

| Opción | Cómo es | Para… |
|---|---|---|
| **Hosting compartido** | Barato, con cPanel. Muchos no dejan usar la terminal, ni Composer, ni colas, ni elegir la carpeta `public/` | Webs muy sencillas (y con cuidado) |
| **Servidor virtual (VPS)** | Un Linux entero para vosotros (DigitalOcean, Hetzner, OVH, Arsys…). Lo configuráis todo | Aprender cómo funciona todo y tener control total |
| **Laravel Forge** o **Ploi** | Paneles que configuran y mantienen vuestro VPS: Nginx, PHP, MySQL, colas, cron, HTTPS… | Trabajo profesional sin ser administrador de sistemas |
| **Laravel Cloud** | La plataforma oficial: conectáis el repositorio de GitHub y se encarga de todo | Despreocuparse del servidor |

Antes de pagar nada, comprobad que el servidor tiene lo que pide Laravel 13 [3]: **PHP 8.3** o superior con las extensiones `ctype`, `curl`, `dom`, `fileinfo`, `filter`, `hash`, `mbstring`, `openssl`, `pcre`, `pdo`, `session`, `tokenizer` y `xml`, **Composer**, una base de datos y poder apuntar el dominio a la carpeta **`public/`**.

---

## <img src="../img/emojis/explica.webp" width="40" alt=""> 7. Despliegue paso a paso en un servidor

Estos son los pasos en un VPS con Ubuntu, Nginx, PHP-FPM y MySQL ya instalados. Merece la pena hacerlo **al menos una vez** a mano: después, Forge o Cloud os parecerán magia comprensible. 😉

**1. Bajar el código**

```bash
cd /var/www
git clone https://github.com/vuestro-usuario/academia-laravel.git academia
cd academia
```

**2. Instalar las dependencias, sin las de desarrollo**

```bash
composer install --no-dev --optimize-autoloader
```

`--no-dev` no instala lo que solo sirve en desarrollo (PHPUnit, Pint…), y `--optimize-autoloader` genera una autocarga más rápida.

**3. El `.env` de producción**

```bash
cp .env.example .env
nano .env                    # rellenad los datos del punto 5
php artisan key:generate
```

**4. La base de datos y los archivos**

```bash
php artisan migrate --force
php artisan db:seed --class=CategoriaSeeder --force
php artisan storage:link
```

`--force` es obligatorio en producción: Laravel pide confirmación antes de tocar la base de datos de verdad. Y ojo: en producción **no** ejecutamos `migrate:fresh` ni el `DatabaseSeeder` completo, que llenaría la web de alumnos inventados. Solo los datos fijos, como las categorías.

**5. Los permisos**

El servidor web tiene que poder escribir en `storage/` y en `bootstrap/cache/`:

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

**6. El servidor web**

Nginx tiene que apuntar a la carpeta **`public/`** y mandar todas las peticiones a `index.php`, igual que hacía nuestro `.htaccess` de la clase 23. Os dejo la configuración recomendada en [`nginx-academia.conf`](despliegue/nginx-academia.conf):

```nginx
root /var/www/academia/public;

location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

**7. HTTPS**

Hoy ninguna web puede ir sin HTTPS (y las cookies de sesión lo necesitan). **Let's Encrypt** da certificados gratuitos:

```bash
sudo certbot --nginx -d academia-alpe.es -d www.academia-alpe.es
```

**8. Las colas**

En el servidor no hay nadie para abrir una terminal con `queue:work`. **Supervisor** es un programa que mantiene el *worker* siempre en marcha y lo relanza si se cae ([`supervisor-academia-worker.conf`](despliegue/supervisor-academia-worker.conf)):

```ini
[program:academia-worker]
command=php /var/www/academia/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=2
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start "academia-worker:*"
```

**9. Las tareas programadas**

Una sola línea en el `cron` del sistema ([`crontab.txt`](despliegue/crontab.txt)): cada minuto, Laravel mira si toca alguna tarea de las que programamos en la clase 38.

```text
* * * * * cd /var/www/academia && php artisan schedule:run >> /dev/null 2>&1
```

**10. Optimizar**

```bash
php artisan optimize
```

¡Y a probar en el navegador! 🎉

---

## <img src="../img/emojis/sorpresa.webp" width="40" alt=""> 8. Actualizar sin romper nada

Cada vez que haya cambios, se repite una parte de lo anterior. Para no olvidar ningún paso, lo guardamos en un script, [`deploy.sh`](despliegue/deploy.sh):

```bash
#!/bin/bash
# Actualiza la academia en el servidor: bash deploy.sh
set -e

php artisan down --retry=60                          # modo mantenimiento
git pull origin main                                 # el código nuevo
composer install --no-dev --optimize-autoloader --no-interaction
php artisan migrate --force                          # las migraciones nuevas
php artisan optimize                                 # rehacer las cachés
php artisan queue:restart                            # los workers cargan el código nuevo
php artisan up                                       # ¡de vuelta!
```

- `set -e` detiene el script en cuanto un paso falle: mejor parar que seguir a medias.
- **`php artisan down`** pone la web en **modo mantenimiento**: los visitantes ven un aviso (un error 503) mientras actualizamos. Con `--secret=una-clave` podéis entrar vosotros por `https://academia-alpe.es/una-clave` para comprobar que todo va bien antes del `up`.
- **`queue:restart`**: ¿recordáis que el *worker* carga el código al arrancar (clase 38)? Esto le dice que termine lo que está haciendo y vuelva a empezar con la versión nueva.

> 💡 Forge, Ploi y Laravel Cloud hacen este proceso con **cero segundos de corte** (*zero-downtime deployment*): preparan la versión nueva en otra carpeta y, cuando está lista, cambian un enlace simbólico. El visitante ni se entera.

---

## <img src="../img/emojis/genial.webp" width="40" alt=""> 9. El proyecto final

Ahora os toca a vosotros. El proyecto final es una aplicación Laravel **vuestra**, de principio a fin. Se puede hacer de forma individual o en grupos de dos o tres personas.

### Propuestas

| Proyecto | Idea |
|---|---|
| 📚 **Biblioteca** | Libros, autores y socios; préstamos con fecha de devolución y aviso por correo de los retrasados |
| 🏋️ **Gimnasio** | Clases, monitores y reservas con plazas limitadas; los socios ven sus reservas |
| 🍽️ **Restaurante** | Carta por categorías, reservas de mesa y panel para el personal |
| 🏠 **Inmobiliaria** | Pisos con fotos, filtros por precio y zona, y formulario de contacto por anuncio |
| 🎫 **Incidencias** | Usuarios que abren incidencias, técnicos que las resuelven, estados y comentarios |
| 💡 **La vuestra** | Una idea propia, con mi visto bueno antes de empezar |

### Requisitos mínimos

- [ ] Al menos **cuatro tablas** con migraciones, con una relación uno a muchos y otra muchos a muchos.
- [ ] *Seeders* y *factories* para tener datos de prueba con un solo comando.
- [ ] Un **CRUD completo** con validación en un *Form Request* y mensajes en español.
- [ ] Subida de al menos un tipo de archivo (imagen o documento).
- [ ] **Login** y al menos **dos roles** con permisos distintos (*policy* o *gates*).
- [ ] Un *layout* Blade con componentes y paginación en los listados.
- [ ] Una **API** con al menos un recurso de lectura (*API Resource*).
- [ ] Al menos **diez pruebas** automáticas que pasen.
- [ ] Un **evento** con su *listener*, o un correo enviado desde la cola.
- [ ] El código pasado por **Pint**, en un repositorio de **Git** con *commits* frecuentes y con sentido.
- [ ] Un `README.md` que explique qué hace y cómo instalarla.
- [ ] ⭐ Para nota: publicada en Internet.

### Cómo lo valoraré

| Aspecto | Qué miro |
|---|---|
| Funciona | Se instala siguiendo el `README` y hace lo que promete |
| Código | Organizado, legible, con los nombres y las convenciones del curso |
| Seguridad | Valida, autoriza y no tiene los fallos que hemos ido viendo |
| Pruebas | Prueban lo importante, y pasan |
| Git | La historia de *commits* cuenta cómo se construyó el proyecto |
| Presentación | Una demo de diez minutos explicando qué habéis hecho y qué habéis aprendido |

> 💡 **Mi consejo:** empezad por las **migraciones** y los **modelos** (dibujad antes las tablas en un papel), después el CRUD más importante, y dejad para el final lo «bonito». Una aplicación pequeña que funciona bien vale mucho más que una enorme a medio hacer.

---

## <img src="../img/emojis/genial.webp" width="40" alt=""> 10. Ejercicios

Las soluciones se copian dentro del proyecto, respetando sus carpetas.

- [ ] **01 · Página de mantenimiento.** Cread `resources/views/errors/503.blade.php` con un aviso amable y el teléfono de la academia, y probadla con `php artisan down`. Cuidado: **no** uséis el layout, porque durante el mantenimiento puede que la base de datos no esté disponible (y el menú consulta las categorías). → [`errors/503.blade.php`](soluciones/resources/views/errors/503.blade.php)
- [ ] **02 · Lista de comprobación.** Cread con `php artisan make:command ComprobarDespliegue` un comando **de clase** (en `app/Console/Commands`) llamado `academia:comprobar` que revise que la aplicación está lista para producción: `APP_KEY` generada, `APP_DEBUG` desactivado, entorno `production`, `https` en `APP_URL`, conexión con la base de datos, enlace `public/storage`, permisos de `storage/`, cola distinta de `sync` y correo distinto de `log`. Que termine con error si algo falla. → [`ComprobarDespliegue.php`](soluciones/app/Console/Commands/ComprobarDespliegue.php)
- [ ] **03 · Integración continua.** Cread un *workflow* de **GitHub Actions** que, en cada `push` y en cada *pull request*, instale el proyecto, compruebe el estilo con Pint y ejecute las pruebas. Así nadie puede fusionar código que rompa algo. → [`.github/workflows/pruebas.yml`](soluciones/.github/workflows/pruebas.yml)
- [ ] **04 · Una acción para matricular.** Sacad la lógica de `MatriculaController` a una clase `App\Acciones\MatricularAlumno` con un método `ejecutar(Curso $curso, Alumno $alumno)` que, dentro de una transacción y con `lockForUpdate()`, compruebe que el alumno no está ya matriculado y que quedan plazas, lo matricule y lance el evento. El controlador la recibe por inyección y queda en cuatro líneas. Demostrad que se puede reutilizar con un comando `academia:matricular {curso} {alumno}`. → [`MatricularAlumno.php`](soluciones/app/Acciones/MatricularAlumno.php), [`MatriculaController.php`](soluciones/app/Http/Controllers/MatriculaController.php) y [`routes/console.php`](soluciones/routes/console.php)
- [ ] **05 · Una revisión de código.** Leed con ojo crítico [`InformeController-con-fallos.php`](soluciones/revision/InformeController-con-fallos.php), como si os hubiera llegado a revisión, y apuntad todos los fallos que encontréis (de seguridad, de rendimiento y de estilo) antes de mirar la versión corregida. Hay más de diez. → [`InformeController-revisado.php`](soluciones/revision/InformeController-revisado.php)
- [ ] **06 · Copias de seguridad.** Cread el comando de clase `academia:copia-seguridad {--mantener=7}`, que ejecute `mysqldump` con la *facade* `Process` (los argumentos en un array y la contraseña en la variable `MYSQL_PWD`), guarde la copia comprimida con `gzencode()` en el disco privado y borre las más antiguas. Programadlo cada noche. → [`CopiaSeguridad.php`](soluciones/app/Console/Commands/CopiaSeguridad.php) y [`routes/console.php`](soluciones/routes/console.php)
- [ ] **07 · Las páginas de error.** Cread `errors/404.blade.php` con el *layout*, un buscador de cursos y un enlace a la portada, y `errors/500.blade.php` **sin** el *layout* (¿por qué?) y sin ninguna consulta. Probadlas con `APP_DEBUG=false` y una ruta que lance una excepción a propósito. → [`errors/404.blade.php`](soluciones/resources/views/errors/404.blade.php) y [`errors/500.blade.php`](soluciones/resources/views/errors/500.blade.php)
- [ ] **08 · Ajustes para producción.** En el `boot()` de `AppServiceProvider`: `Model::shouldBeStrict()` fuera de producción, `DB::prohibitDestructiveCommands()` y `URL::forceHttps()` en producción. Pasad las pruebas: el modo estricto destapará que un usuario recién creado no tiene `rol` en memoria. Arregladlo con `$attributes` en el modelo y comprobad que `migrate:fresh` se niega a funcionar con `APP_ENV=production`. → [`AppServiceProvider.php`](soluciones/app/Providers/AppServiceProvider.php) y [`User.php`](soluciones/app/Models/User.php)
- [ ] **09 · Pruebas de humo.** Cread el comando `academia:humo {url?}`, que pida con la *facade* `Http` las páginas principales (la portada, los cursos, el login, la API, `/up`…), compare el código recibido con el esperado (`/admin` debe redirigir y una página inventada, dar 404) y muestre una tabla con los tiempos. Ejecutadlo al final de cada despliegue. → [`PruebasHumo.php`](soluciones/app/Console/Commands/PruebasHumo.php)
- [ ] **10 · Probar la acción.** Escribid las pruebas de `MatricularAlumno`: matricula y lanza el evento, no matricula dos veces al mismo alumno, sin plazas lanza `SinPlazasException` sin tocar nada, el controlador la usa (y vuelve atrás con el error cuando el curso está lleno) y el comando de la consola funciona. → [`MatricularAlumnoTest.php`](soluciones/tests/Feature/MatricularAlumnoTest.php)

> 🏆 **Reto final:** publicad la academia (o vuestro proyecto) en Internet. Un VPS de los más pequeños cuesta unos pocos euros al mes, y Laravel Cloud tiene opciones para empezar. Mandadme el enlace: ¡quiero verla! 🚀

---

## <img src="../img/emojis/hola.webp" width="40" alt=""> 11. Lo que tenéis que llevaros del curso

| Idea | En una frase |
|---|---|
| Programar | Pensar el problema antes de escribir el código |
| PHP y POO | Clases pequeñas, con una tarea, que colaboran entre sí |
| Nuestro MVC | Ya sabéis qué hay debajo de cualquier *framework* |
| Laravel | Las mismas piezas, probadas por millones de proyectos |
| Seguridad | Validar, escapar, autorizar y no confiar nunca en lo que llega del usuario |
| Calidad | Pruebas, Pint y revisiones de código |
| Producción | `APP_DEBUG=false`, HTTPS, colas con Supervisor y una línea de `cron` |
| Seguir aprendiendo | La documentación oficial es vuestra mejor amiga |

### 🎓 Despedida

Si habéis llegado hasta aquí, habéis hecho algo que mucha gente empieza y pocos terminan. Recordad cómo os sentíais la primera vez que visteis un `<?php` en la clase 4, y mirad ahora vuestra academia: rutas, base de datos, usuarios, API, pruebas, colas…

No os voy a engañar: esto no se acaba aquí. En informática **nunca** se termina de aprender, y eso es precisamente lo bonito. Seguid haciendo proyectos, leed código de otros, equivocaos mucho (es la única forma de aprender), y cuando algo no salga, respirad hondo, leed el mensaje de error con calma… y a por ello. 💪

Ha sido un placer acompañaros. ¡Nos vemos en el código!

Ramón

---

**Clase anterior:** 👈 [Clase 38 · Funcionalidades avanzadas](../clase-38-laravel-avanzado/README.md)

---

### Fuentes y Documentación Oficial

1. [Laravel: Pint](https://laravel.com/docs/pint)
2. [Laravel: Configuration, Environment Configuration](https://laravel.com/docs/configuration#environment-configuration)
3. [Laravel: Deployment](https://laravel.com/docs/deployment)
4. [Laravel: Queues, Supervisor Configuration](https://laravel.com/docs/queues#supervisor-configuration)
5. [Laravel: Task Scheduling, Running the Scheduler](https://laravel.com/docs/scheduling#running-the-scheduler)
6. [Laravel: Configuration, Maintenance Mode](https://laravel.com/docs/configuration#maintenance-mode)
7. [Let's Encrypt: Certbot](https://certbot.eff.org/)
8. [GitHub Docs: GitHub Actions](https://docs.github.com/es/actions)
