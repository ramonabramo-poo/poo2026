<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Una ruta que devuelve un texto: Laravel lo convierte en la respuesta
Route::get('/hola', function () {
    return '¡Hola desde Laravel! 👋';
});

// Una ruta que devuelve una vista y le pasa datos
Route::get('/saludo', function () {
    return view('saludo', [
        'nombre' => 'Ramón',
        'curso' => 'PHP y POO',
    ]);
});

// Datos de la aplicación sacados de la configuración
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

// Ejercicio 01
Route::get('/sobre-mi', function () {
    return view('sobre-mi', [
        'nombre' => 'Lucía Pérez',
        'ciudad' => 'Santander',
        'aficiones' => 'la montaña, la fotografía y programar',
    ]);
});

// Ejercicio 03
Route::get('/hoy', function () {
    $hoy = now()->locale('es');

    return 'Hoy es ' . $hoy->isoFormat('dddd, D [de] MMMM [de] YYYY')
        . ' y son las ' . $hoy->format('H:i') . ' en ' . config('app.timezone') . '.';
});
