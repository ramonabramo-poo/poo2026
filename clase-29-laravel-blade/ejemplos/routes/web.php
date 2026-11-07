<?php

use App\Http\Controllers\CursoController;
use App\Http\Controllers\PaginaController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Rutas con controlador y con nombre
Route::get('/', [PaginaController::class, 'inicio'])->name('inicio');
Route::get('/contacto', [PaginaController::class, 'contacto'])->name('contacto');

// Las 7 rutas REST de los cursos; de momento solo usamos dos
Route::resource('cursos', CursoController::class)->only(['index', 'show']);

// Atajos: redirigir y mostrar una vista sin controlador
Route::redirect('/cursos-online', '/cursos');
Route::view('/aviso-legal', 'paginas.aviso-legal')->name('aviso-legal');

// Una página para practicar las directivas de Blade
Route::get('/blade', function () {
    return view('ejemplos.directivas', [
        'html' => '<strong>negrita</strong>',
        'nota' => 7.5,
        'esAdmin' => false,
        'dia' => now()->locale('es')->dayName,
        'alumnos' => ['Lucía', 'Pablo', 'Marta', 'Iván'],
        'notas' => [7.5, 6, 9, 4.5],
    ]);
})->name('blade');

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

// Rutas de la clase 27
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
