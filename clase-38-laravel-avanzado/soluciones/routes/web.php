<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistroController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\PaginaController;
use App\Jobs\ExportarAlumnos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

    // Matricular a un alumno: quien pueda editar el curso
    Route::post('/cursos/{curso}/matriculas', [MatriculaController::class, 'store'])
        ->middleware('can:update,curso')
        ->name('matriculas.store');

    // Ejercicio 05
    Route::delete('/cursos/{curso}/matriculas/{alumno}', [MatriculaController::class, 'destroy'])
        ->middleware('can:update,curso')
        ->name('matriculas.destroy');

    // Ejercicio 06: pedir la exportación (va a la cola) y descargar el fichero cuando esté
    Route::middleware('can:ver-panel')->group(function () {
        Route::post('/admin/exportaciones', function (Request $request) {
            ExportarAlumnos::dispatch($request->user());

            return back()->with('exito', 'Estamos preparando el fichero. Te avisaremos aquí cuando esté listo.');
        })->name('exportaciones.store');

        Route::get('/admin/exportaciones/{fichero}', function (string $fichero) {
            // basename() evita que nos pidan ../../.env
            $ruta = 'exportaciones/' . basename($fichero);
            abort_unless(Storage::exists($ruta), 404);

            return Storage::download($ruta);
        })->name('exportaciones.show');
    });

    // Marcar como leídas las notificaciones del usuario
    Route::post('/notificaciones/leidas', function (Request $request) {
        $request->user()->unreadNotifications->markAsRead();

        return back();
    })->name('notificaciones.leidas');

    // Con nuestro middleware: solo el administrador
    Route::get('/admin/sistema', [PaginaController::class, 'sistema'])->middleware('rol:admin')->name('admin.sistema');
});

// Ver los cursos es público (va después para que /cursos/create no se tome como un {curso})
Route::resource('cursos', CursoController::class)->only(['index', 'show']);
Route::get('/cursos/{curso}/presupuesto', [CursoController::class, 'presupuesto'])->name('cursos.presupuesto');

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
