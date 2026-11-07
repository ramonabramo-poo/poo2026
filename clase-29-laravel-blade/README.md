# Clase 29 · Vistas con Blade

<p align="center"><img src="../img/emojis/bien.webp" width="120" alt="El profesor, contento"></p>

> 📕 **Apuntes en PDF:** [clase-29-laravel-blade.pdf](clase-29-laravel-blade.pdf)

En la clase 28 dejamos las vistas con un problema evidente: todas repetían la cabecera, el menú y la hoja de estilos. Si mañana añadimos un enlace al menú, hay que tocar cinco ficheros. En nuestro MVC lo arreglamos con un *layout* y vistas parciales (clase 24). Hoy lo hacemos con **Blade**, el motor de plantillas de Laravel.

Blade no es un lenguaje nuevo: es HTML con unas cuantas **directivas** (`@if`, `@foreach`…) que Laravel traduce a PHP normal y guarda en caché. Lo que aprendáis hoy lo vais a usar en todas las clases que quedan.

---

## Índice

- [Cómo vamos a trabajar](#-cómo-vamos-a-trabajar)
1. [Qué es Blade](#-1-qué-es-blade)
2. [Mostrar datos](#-2-mostrar-datos)
3. [Condiciones](#-3-condiciones)
4. [Bucles y la variable $loop](#-4-bucles-y-la-variable-loop)
5. [Layouts: @extends, @section y @yield](#-5-layouts-extends-section-y-yield)
6. [Vistas parciales con @include](#-6-vistas-parciales-con-include)
7. [Componentes](#-7-componentes)
8. [Pasar datos a las vistas](#-8-pasar-datos-a-las-vistas)
9. [Recursos estáticos y Vite](#-9-recursos-estáticos-y-vite)
10. [Ejercicios](#-10-ejercicios)
11. [Lo que tenéis que llevaros de hoy](#-11-lo-que-tenéis-que-llevaros-de-hoy)

---

## <img src="../img/emojis/ok.webp" width="40" alt=""> Cómo vamos a trabajar

Copiad el contenido de [`ejemplos/`](ejemplos/) encima del proyecto `academia-laravel`:

```text
resources/views/layouts/app.blade.php          ← NUEVO: el layout de toda la web
resources/views/partials/menu.blade.php        ← NUEVO: el menú
resources/views/components/alerta.blade.php    ← NUEVO: componente <x-alerta>
resources/views/components/tarjeta-curso.blade.php ← NUEVO: componente <x-tarjeta-curso>
resources/views/ejemplos/directivas.blade.php  ← NUEVO: la página /blade para practicar
resources/views/paginas/ y cursos/             ← reescritas con el layout
config/academia.php                            ← añade los nombres de las categorías
app/Http/Controllers/PaginaController.php      ← la portada recibe los cursos destacados
routes/web.php                                 ← nueva ruta /blade
public/css/academia.css                        ← marca el enlace activo del menú
```

---

## <img src="../img/emojis/explica.webp" width="40" alt=""> 1. Qué es Blade

Las vistas de Blade son ficheros que terminan en **`.blade.php`** y viven en `resources/views/` [1]. Cuando una vista se usa por primera vez, Laravel la **compila** a PHP normal y guarda el resultado en `storage/framework/views/`. Las siguientes veces usa directamente esa versión, así que Blade no hace más lenta la web.

| En nuestro MVC (PHP puro) | En Blade |
|---|---|
| `<?= e($nombre) ?>` | `{{ $nombre }}` |
| `<?php if ($nota >= 5): ?> ... <?php endif; ?>` | `@if ($nota >= 5) ... @endif` |
| `<?php foreach ($cursos as $curso): ?> ... <?php endforeach; ?>` | `@foreach ($cursos as $curso) ... @endforeach` |
| `$this->parcial('menu')` | `@include('partials.menu')` |
| El layout que envuelve la vista | `@extends('layouts.app')` |

Para practicar las directivas he preparado una página con todo junto: abrid `/blade` y tened al lado su vista, [`ejemplos/directivas.blade.php`](ejemplos/resources/views/ejemplos/directivas.blade.php).

> 💡 Instalad en VS Code la extensión **Laravel Blade Snippets** o la oficial **Laravel**: colorean la sintaxis de Blade y autocompletan las directivas.

---

## <img src="../img/emojis/bien.webp" width="40" alt=""> 2. Mostrar datos

```html
<p>Escapado: {{ $html }}</p>
<p>Sin escapar: {!! $html !!}</p>
<p>Con valor por defecto: {{ $apodo ?? 'sin apodo' }}</p>
```

Si `$html` vale `'<strong>negrita</strong>'`, el resultado es:

```html
<p>Escapado: &lt;strong&gt;negrita&lt;/strong&gt;</p>
<p>Sin escapar: <strong>negrita</strong></p>
<p>Con valor por defecto: sin apodo</p>
```

- `{{ }}` pasa el valor por `htmlspecialchars()`. Es lo que usaréis el 99 % de las veces: **protege contra XSS** (clase 12).
- `{!! !!}` imprime tal cual. Solo para HTML que hayamos generado **nosotros** y del que nos fiemos. **Nunca** con datos que haya escrito un usuario.
- Dentro de `{{ }}` cabe cualquier expresión de PHP: `{{ strtoupper($nombre) }}`, `{{ count($cursos) }}`, `{{ $precio * 1.21 }}`…

Otras tres cosas útiles:

```html
{{-- Comentario de Blade: no llega al HTML, a diferencia de <!-- --> --}}

@php
    $media = array_sum($notas) / count($notas);
@endphp

<script>
    const alumnos = @json($alumnos);   // convierte el array de PHP en JSON para JavaScript
</script>
```

> ⚠️ `@php` existe, pero si os veis escribiendo mucho PHP en una vista, ese código debería estar en el controlador. La vista **muestra**, no calcula.

---

## <img src="../img/emojis/pensando.webp" width="40" alt=""> 3. Condiciones

```html
@if ($nota >= 9)
    <p>Sobresaliente</p>
@elseif ($nota >= 5)
    <p>Aprobado</p>
@else
    <p>Suspenso</p>
@endif

@unless ($esAdmin)
    <p>No eres administrador.</p>     {{-- @unless = "si NO" --}}
@endunless

@isset($apodo)
    <p>Tienes apodo.</p>              {{-- existe y no es null --}}
@endisset

@empty($alumnos)
    <p>No hay alumnos.</p>            {{-- está vacío --}}
@endempty

@switch($dia)
    @case('sábado')
    @case('domingo')
        <p>¡Fin de semana!</p>
        @break
    @default
        <p>Día de clase.</p>
@endswitch
```

Y una directiva muy práctica para las clases de CSS: `@class` añade solo las clases cuya condición sea verdadera. Así marcamos el enlace activo del menú:

```html
<a href="{{ route('cursos.index') }}" @class(['activo' => request()->routeIs('cursos.*')])>Cursos</a>
```

`request()->routeIs('cursos.*')` es verdadero si la ruta actual tiene un nombre que empieza por `cursos.`: otra ventaja de nombrar las rutas.

---

## <img src="../img/emojis/genial.webp" width="40" alt=""> 4. Bucles y la variable $loop

Tenemos los bucles de siempre (`@foreach`, `@for`, `@while`) y uno exclusivo de Blade, **`@forelse`**, que incluye el caso de que la lista esté vacía. Mirad el listado de cursos ([`cursos/index.blade.php`](ejemplos/resources/views/cursos/index.blade.php)):

```html
<div class="tarjetas">
    @forelse ($cursos as $curso)
        <x-tarjeta-curso :curso="$curso">
            @if ($loop->first)
                <p>⭐ El primero de la lista</p>
            @endif
        </x-tarjeta-curso>
    @empty
        <x-alerta tipo="error">No hay ningún curso que coincida con la búsqueda.</x-alerta>
    @endforelse
</div>
```

Dentro de cualquier `@foreach` o `@forelse` tenemos gratis la variable **`$loop`**, que nos ahorra contadores:

| Propiedad | Qué vale |
|---|---|
| `$loop->iteration` | La vuelta actual, empezando en 1 |
| `$loop->index` | La vuelta actual, empezando en 0 |
| `$loop->count` | El total de elementos |
| `$loop->first` / `$loop->last` | Si es la primera / la última vuelta |
| `$loop->even` / `$loop->odd` | Si es una vuelta par / impar |
| `$loop->remaining` | Cuántas vueltas quedan |

```html
@foreach ($alumnos as $alumno)
    <tr @class(['par' => $loop->even])>
        <td>{{ $loop->iteration }} de {{ $loop->count }}</td>
        <td>{{ $alumno }}</td>
    </tr>
@endforeach
```

---

## <img src="../img/emojis/sorpresa.webp" width="40" alt=""> 5. Layouts: @extends, @section y @yield

El **layout** es el esqueleto común de todas las páginas: cabecera, menú, pie y hoja de estilos. Lo guardamos en [`layouts/app.blade.php`](ejemplos/resources/views/layouts/app.blade.php) y marcamos con **`@yield`** los huecos que rellenará cada página [2]:

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Inicio') · {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/academia.css') }}">
    @stack('estilos')
</head>
<body>
    @include('partials.menu')

    <main>
        @yield('contenido')
    </main>

    <footer>
        © {{ date('Y') }} {{ config('app.name') }} · Santander
        · <a href="{{ route('aviso-legal') }}">Aviso legal</a>
    </footer>

    @stack('scripts')
</body>
</html>
```

Cada página dice qué layout usa con **`@extends`** y rellena los huecos con **`@section`** ([`contacto.blade.php`](ejemplos/resources/views/paginas/contacto.blade.php)):

```html
@extends('layouts.app')

@section('titulo', 'Contacto')

@section('contenido')
    <h1>📞 Contacto</h1>
    <p>Teléfono: {{ $telefono }}</p>
    <p>Correo: <a href="mailto:{{ $email }}">{{ $email }}</a></p>
@endsection
```

- `@section('titulo', 'Contacto')` es la forma corta, para un texto.
- `@section('contenido') ... @endsection` es la forma larga, para un bloque de HTML.
- `@yield('titulo', 'Inicio')` usa `'Inicio'` si la página no define esa sección.

### Pilas: @stack y @push

¿Y si una sola página necesita un poco de CSS o de JavaScript propio? La empuja a una **pila** con `@push`, y el layout la pinta donde esté el `@stack`:

```html
@push('estilos')
    <style>
        .par { background: #fff4e6; }
    </style>
@endpush
```

Ahora el menú está en **un solo sitio**. ¡Añadid un enlace y comprobad que aparece en todas las páginas! 🎉

---

## <img src="../img/emojis/explica.webp" width="40" alt=""> 6. Vistas parciales con @include

Un trozo de vista que se repite se guarda aparte y se incluye con `@include`. Nuestro menú está en [`partials/menu.blade.php`](ejemplos/resources/views/partials/menu.blade.php):

```html
<header>
    <a class="marca" href="{{ route('inicio') }}">🎓 {{ config('app.name') }}</a>
    <nav>
        <a href="{{ route('cursos.index') }}" @class(['activo' => request()->routeIs('cursos.*')])>Cursos</a>
        <a href="{{ route('contacto') }}" @class(['activo' => request()->routeIs('contacto')])>Contacto</a>
    </nav>
</header>
```

La vista incluida ve las mismas variables que la que la incluye, y además se le pueden pasar más: `@include('partials.aviso', ['texto' => 'Plazas limitadas'])`.

---

## <img src="../img/emojis/genial.webp" width="40" alt=""> 7. Componentes

Los **componentes** son la evolución de los parciales: piezas reutilizables que se usan **como si fueran etiquetas HTML** y que reciben datos a través de atributos [3]. Los más sencillos (componentes **anónimos**) son una vista dentro de `resources/views/components/`.

### Un componente con contenido: <x-alerta>

[`components/alerta.blade.php`](ejemplos/resources/views/components/alerta.blade.php):

```html
@props(['tipo' => 'info'])

<div {{ $attributes->merge(['class' => "alerta alerta-$tipo"]) }}>
    {{ $slot }}
</div>
```

Y se usa así:

```html
<x-alerta tipo="exito">
    ¡Matrícula abierta! Tenemos <strong>{{ $totalCursos }}</strong> cursos esperándoos.
</x-alerta>
```

- El fichero `components/alerta.blade.php` se convierte en la etiqueta **`<x-alerta>`**.
- `@props` declara los atributos que acepta, con sus valores por defecto.
- **`$slot`** es lo que escribimos entre la etiqueta de apertura y la de cierre.
- `$attributes` son el resto de atributos (una `id`, otra clase…): `merge()` los junta con los nuestros.

### Un componente que recibe datos: <x-tarjeta-curso>

[`components/tarjeta-curso.blade.php`](ejemplos/resources/views/components/tarjeta-curso.blade.php):

```html
@props(['curso'])

<article class="tarjeta">
    <h3>{{ $curso['titulo'] }}</h3>
    <p>
        <span class="etiqueta">{{ config("academia.categorias.{$curso['categoria']}") }}</span>
        {{ $curso['horas'] }} horas
    </p>
    <p><strong>{{ number_format($curso['precio'], 2, ',', '.') }} €</strong></p>

    {{-- Si quien usa el componente le pasa contenido, se pinta aquí --}}
    {{ $slot }}

    <a class="boton" href="{{ route('cursos.show', $curso['id']) }}">Ver curso</a>
</article>
```

```html
<x-tarjeta-curso :curso="$curso" />
```

> ⚠️ **Fijaos en los dos puntos.** `curso="$curso"` le pasaría el **texto** «$curso». Con `:curso="$curso"`, lo de dentro de las comillas se evalúa como **PHP** y se pasa la variable. Lo mismo con `:href="route('inicio')"`.

La tarjeta aparece en la portada (los tres cursos destacados) y en el listado. Si mañana cambiamos su diseño, cambia en los dos sitios.

| | `@include` | Componente |
|---|---|---|
| Uso | `@include('partials.menu')` | `<x-alerta tipo="error">...</x-alerta>` |
| Recibe datos | Las variables de la vista + un array | Atributos declarados con `@props` |
| Contenido dentro | No | Sí, con `$slot` |
| Para… | Trozos fijos (menú, pie) | Piezas reutilizables con variaciones |

> 💡 También hay componentes **con clase**, que se crean con `php artisan make:component` y permiten lógica en PHP. Para la mayoría de los casos, los anónimos bastan.

---

## <img src="../img/emojis/curioso.webp" width="40" alt=""> 8. Pasar datos a las vistas

Ya lo hemos hecho muchas veces con un array, que es la forma más clara:

```php
return view('paginas.contacto', [
    'telefono' => config('academia.telefono'),
    'email' => config('academia.email'),
]);
```

Pero os encontraréis estas otras en ejemplos de internet:

```php
return view('cursos.show')->with('curso', $curso);   // dato a dato
return view('cursos.index', compact('cursos', 'buscar'));  // compact() crea el array con esos nombres
```

Y para datos que necesitan **todas** las vistas (por ejemplo, el teléfono en el pie), se puede usar `View::share('telefono', ...)` en el método `boot()` de `AppServiceProvider`. Lo veremos en la clase 34.

La portada ahora recibe también los cursos destacados ([`PaginaController.php`](ejemplos/app/Http/Controllers/PaginaController.php)):

```php
public function inicio(): View
{
    $cursos = config('academia.cursos');

    return view('paginas.inicio', [
        'totalCursos' => count($cursos),
        'destacados' => array_slice($cursos, 0, 3),
    ]);
}
```

---

## <img src="../img/emojis/atencion.webp" width="40" alt=""> 9. Recursos estáticos y Vite

Todo lo que está en `public/` se sirve directamente. Para enlazarlo, **siempre con `asset()`**, que genera la dirección completa y funciona aunque la web esté en una subcarpeta:

```html
<link rel="stylesheet" href="{{ asset('css/academia.css') }}">
<img src="{{ asset('img/logo.png') }}" alt="Logo de la academia">
```

Si un día pasáis a **Vite** (clase 27), el cambio en el layout es una línea:

```html
{{-- Antes --}}
<link rel="stylesheet" href="{{ asset('css/academia.css') }}">

{{-- Con Vite: npm install y npm run dev --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

Con `npm run dev`, Vite vigila `resources/css` y `resources/js` y recarga el navegador cada vez que guardáis. Con `npm run build`, genera los ficheros finales en `public/build/` y `@vite` los enlaza solo [4].

---

## <img src="../img/emojis/genial.webp" width="40" alt=""> 10. Ejercicios

Las soluciones se copian dentro del proyecto, respetando sus carpetas.

- [ ] **01 · Un componente botón.** Cread el componente `<x-boton>`, que reciba `href` y un `tipo` (`principal`, `secundario` o `peligro`) y pinte un enlace con la clase CSS adecuada. Usadlo en la ficha del curso para «Volver a los cursos» y «Pedir información». → [`components/boton.blade.php`](soluciones/resources/views/components/boton.blade.php) y [`cursos/show.blade.php`](soluciones/resources/views/cursos/show.blade.php)
- [ ] **02 · Tabla de precios.** Cread la página `/precios` con una tabla de todos los cursos: número de fila (`$loop`), título con enlace, horas, precio y precio con IVA, con las filas pares de otro color (`@class` y `@push`) y una fila final con los totales. → [`paginas/precios.blade.php`](soluciones/resources/views/paginas/precios.blade.php) y [`routes/web.php`](soluciones/routes/web.php)
- [ ] **03 · Nuestra propia página 404.** Si existe la vista `resources/views/errors/404.blade.php`, Laravel la usa para los errores 404. Cread una que use el layout y una alerta, y probadla con `/cursos/99`. → [`errors/404.blade.php`](soluciones/resources/views/errors/404.blade.php)

> 🏆 **Reto:** cread un componente `<x-tarjeta>` genérico con un **slot con nombre** para el título (`<x-slot:titulo>...</x-slot>`) y el contenido en `$slot`, y usadlo en la página de contacto. Buscad «Named Slots» en la documentación de Blade.

---

## <img src="../img/emojis/hola.webp" width="40" alt=""> 11. Lo que tenéis que llevaros de hoy

| Idea | En una frase |
|---|---|
| Blade | HTML con directivas; se compila a PHP y se guarda en caché |
| `{{ }}` / `{!! !!}` | Escapado (siempre) / sin escapar (solo HTML nuestro) |
| `@if`, `@unless`, `@isset`, `@switch` | Condiciones sin abrir y cerrar `<?php ?>` |
| `@forelse ... @empty` | Un bucle con el caso «no hay nada» incluido |
| `$loop` | Vuelta actual, total, primera, última, par… gratis en cada bucle |
| `@extends` + `@section` + `@yield` | Un layout para todas las páginas |
| `@stack` + `@push` | CSS o JS propio de una página |
| `@include` | Trozos fijos, como el menú |
| `<x-componente>` | Piezas reutilizables con `@props` y `$slot` |
| `:atributo="$variable"` | Los dos puntos pasan PHP, no texto |
| `asset()` / `@vite` | Enlazar ficheros de `public/` / compilados por Vite |

---

**Clase anterior:** 👈 [Clase 28 · Rutas y controladores](../clase-28-laravel-rutas-controladores/README.md)

---

### Fuentes y Documentación Oficial

1. [Laravel: Blade Templates](https://laravel.com/docs/blade)
2. [Laravel: Blade, Layouts Using Template Inheritance](https://laravel.com/docs/blade#layouts-using-template-inheritance)
3. [Laravel: Blade, Components](https://laravel.com/docs/blade#components)
4. [Laravel: Asset Bundling (Vite)](https://laravel.com/docs/vite)
5. [Laravel: Views](https://laravel.com/docs/views)
