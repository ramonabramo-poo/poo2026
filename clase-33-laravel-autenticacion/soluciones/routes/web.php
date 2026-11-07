<?php

use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistroController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;

// Rutas con controlador y con nombre
Route::get('/', [PaginaController::class, 'inicio'])->name('inicio');
Route::get('/contacto', [PaginaController::class, 'contacto'])->name('contacto');
Route::post('/contacto', [PaginaController::class, 'enviarContacto'])->name('contacto.enviar');

// Solo para quien NO ha iniciado sesión
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,1');
    Route::get('/registro', [RegistroController::class, 'create'])->name('registro');
    Route::post('/registro', [RegistroController::class, 'store']);
});

// Solo para quien SÍ ha iniciado sesión
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    // Crear, editar y borrar cursos (la policy decide además según el rol)
    Route::resource('cursos', CursoController::class)->except(['index', 'show']);

    // El panel, solo para quien pase la gate 'ver-panel'
    Route::view('/admin', 'admin.panel')->middleware('can:ver-panel')->name('admin.panel');

    // Ejercicios 01 y 02
    Route::get('/perfil', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
    Route::put('/perfil/password', [PerfilController::class, 'cambiarPassword'])->name('perfil.password');

    // Ejercicio 03
    Route::middleware('can:administrar-usuarios')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::put('/usuarios/{user}', [UsuarioController::class, 'update'])->name('usuarios.update');
    });
});

// Ver los cursos es público (va después para que /cursos/create no se tome como un {curso})
Route::resource('cursos', CursoController::class)->only(['index', 'show']);

// Route model binding por otra columna: /categorias/programacion
Route::get('/categorias/{categoria:slug}', [CategoriaController::class, 'show'])->name('categorias.show');

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
