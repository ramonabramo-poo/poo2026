<?php

use App\Http\Controllers\Api\V1\CategoriaController;
use App\Http\Controllers\Api\V1\CursoController;
use App\Http\Controllers\Api\V1\MatriculaController;
use App\Http\Controllers\Api\V1\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Todas estas rutas empiezan por /api y devuelven JSON

Route::get('/estado', function () {
    return [
        'aplicacion' => config('app.name'),
        'estado' => 'ok',
        'hora' => now()->toIso8601String(),
    ];
});

// Versión 1 de la API: /api/v1/...
Route::prefix('v1')->name('api.v1.')->middleware('throttle:60,1')->group(function () {
    // Públicas
    Route::post('/tokens', [TokenController::class, 'store'])->middleware('throttle:5,1')->name('tokens.store');
    Route::apiResource('cursos', CursoController::class)->only(['index', 'show']);
    Route::apiResource('categorias', CategoriaController::class)->only(['index', 'show']);  // Ejercicio 01

    // Con token: cabecera  Authorization: Bearer 1|abc...
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/yo', fn (Request $request) => $request->user()->only('id', 'name', 'email', 'rol'))->name('yo');
        Route::delete('/tokens/actual', [TokenController::class, 'destroy'])->name('tokens.destroy');
        Route::get('/cursos/{curso}/alumnos', [CursoController::class, 'alumnos'])->name('cursos.alumnos');  // Ejercicio 02

        // Ejercicio 08
        Route::get('/tokens', [TokenController::class, 'index'])->name('tokens.index');
        Route::delete('/tokens/{id}', [TokenController::class, 'destroyUno'])->whereNumber('id')->name('tokens.destroy-uno');

        // Ejercicio 09: para modificar hace falta un token con la habilidad cursos:escribir
        Route::middleware('abilities:cursos:escribir')->group(function () {
            Route::apiResource('cursos', CursoController::class)->except(['index', 'show']);

            // Ejercicios 05 y 06
            Route::post('/cursos/{curso}/alumnos', [MatriculaController::class, 'store'])->name('matriculas.store');
            Route::patch('/cursos/{curso}/alumnos/{alumno}', [MatriculaController::class, 'update'])->name('matriculas.update');
            Route::delete('/cursos/{curso}/alumnos/{alumno}', [MatriculaController::class, 'destroy'])->name('matriculas.destroy');

            // Ejercicio 10: solo el administrador, con el middleware rol de la clase 35
            Route::post('/categorias', [CategoriaController::class, 'store'])->middleware('rol:admin')->name('categorias.store');
            Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])->middleware('rol:admin')->name('categorias.destroy');
        });
    });
});
