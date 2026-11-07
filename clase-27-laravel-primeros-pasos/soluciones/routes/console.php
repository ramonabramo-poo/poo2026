<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Nuestro primer comando: php artisan academia:saludo Lucía
Artisan::command('academia:saludo {nombre=alumno}', function (string $nombre) {
    $this->info("¡Hola, {$nombre}! Bienvenido a " . config('app.name') . '.');
    $this->line('Hoy es ' . now()->format('d/m/Y') . '.');
})->purpose('Saluda a un alumno por la consola');

// Ejercicio 02: php artisan academia:info
Artisan::command('academia:info', function () {
    $this->info('📋 ' . config('app.name'));
    $this->table(['Dato', 'Valor'], [
        ['Entorno', app()->environment()],
        ['Laravel', app()->version()],
        ['PHP', PHP_VERSION],
        ['Base de datos', config('database.connections.mysql.database')],
        ['Idioma', config('app.locale')],
    ]);
})->purpose('Muestra los datos principales de la academia');
