<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Todas estas rutas empiezan por /api y devuelven JSON

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Un array se convierte en JSON automáticamente
Route::get('/estado', function () {
    return [
        'aplicacion' => config('app.name'),
        'estado' => 'ok',
        'hora' => now()->toIso8601String(),
    ];
});

Route::get('/cursos', function () {
    return array_values(config('academia.cursos'));
});

// Ejercicio 03
Route::get('/cursos/{id}', function (int $id) {
    $curso = config("academia.cursos.$id");

    if ($curso === null) {
        abort(404, 'Curso no encontrado');
    }

    return $curso;
})->whereNumber('id');
