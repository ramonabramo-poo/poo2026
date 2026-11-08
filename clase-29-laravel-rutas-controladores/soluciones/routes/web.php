<?php

use App\Http\Controllers\BuscarController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\ProfesorController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Rutas con controlador y con nombre
Route::get('/', [PaginaController::class, 'inicio'])->name('inicio');
Route::get('/contacto', [PaginaController::class, 'contacto'])->name('contacto');

// Las 7 rutas REST de los cursos; de momento solo usamos dos
Route::resource('cursos', CursoController::class)->only(['index', 'show']);

// Ejercicio 01: va antes que cualquier ruta que pudiera confundirse con ella
Route::get('/cursos/categoria/{categoria}', [CursoController::class, 'porCategoria'])
    ->where('categoria', '[a-z]+')
    ->name('cursos.categoria');

// Ejercicio 02: sin parameters(), el parámetro se llamaría {profesore}
Route::resource('profesores', ProfesorController::class)
    ->only(['index', 'show'])
    ->parameters(['profesores' => 'profesor']);

// Ejercicio 04: tres parámetros, cada uno con su restricción
Route::get('/calcular/{a}/{operacion}/{b}', function (int $a, string $operacion, int $b) {
    $resultado = match ($operacion) {
        'suma' => $a + $b,
        'resta' => $a - $b,
        'multiplica' => $a * $b,
    };

    return "$a $operacion $b = $resultado";
})->whereNumber(['a', 'b'])->whereIn('operacion', ['suma', 'resta', 'multiplica']);

// Ejercicio 05: un controlador de una sola acción (invocable): basta con la clase
Route::get('/buscar', BuscarController::class)->name('buscar');

// Ejercicio 06: direcciones antiguas que llevan a las nuevas por su NOMBRE
Route::get('/catalogo', fn () => redirect()->route('cursos.index'));
Route::permanentRedirect('/contactanos', '/contacto');

// Atajos: redirigir y mostrar una vista sin controlador
Route::redirect('/cursos-online', '/cursos');
Route::view('/aviso-legal', 'paginas.aviso-legal')->name('aviso-legal');

// Parámetros obligatorios, opcionales y con restricciones
Route::get('/hola/{nombre}', function (string $nombre) {
    return "¡Hola, {$nombre}! 👋";
});

Route::get('/bienvenida/{nombre?}', function (?string $nombre = null) {
    return '¡Bienvenido, ' . ($nombre ?? 'invitado') . '!';
});

Route::get('/edad/{edad}', function (int $edad) {
    return $edad >= 18 ? 'Eres mayor de edad' : 'Eres menor de edad';
})->whereNumber('edad');

// Route model binding: Laravel busca el usuario por su id (o da un 404)
Route::get('/usuarios/{user}', function (User $user) {
    return "Usuario {$user->id}: {$user->name} ({$user->email})";
})->name('usuarios.show');

// Un grupo: todas empiezan por /admin y su nombre por admin.
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return 'Panel de administración';
    })->name('panel');

    Route::get('/cursos', function () {
        return 'Gestión de cursos';
    })->name('cursos');
});

// Rutas de la clase 28
Route::get('/hola', function () {
    return '¡Hola desde Laravel! 👋';
});

Route::get('/saludo', function () {
    return view('saludo', [
        'nombre' => 'Ramón',
        'curso' => 'PHP y POO',
    ]);
});

Route::get('/info', function () {
    return view('info', [
        'nombreApp' => config('app.name'),
        'entorno' => app()->environment(),
        'depuracion' => config('app.debug'),
        'idioma' => config('app.locale'),
        'zonaHoraria' => config('app.timezone'),
        'versionLaravel' => app()->version(),
        'versionPhp' => PHP_VERSION,
        'ahora' => now()->format('d/m/Y H:i'),
    ]);
});

// Ejercicio 08: si ninguna ruta coincide, esta es la última oportunidad (va SIEMPRE al final)
Route::fallback(function () {
    return response('🤷 Esta página no existe. Prueba con <a href="/cursos">el catálogo</a>.', 404);
});
