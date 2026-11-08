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

// Ejercicio 07: php artisan academia:sumar 4 7
Artisan::command('academia:sumar {a} {b}', function (string $a, string $b) {
    if (!is_numeric($a) || !is_numeric($b)) {
        $this->error('Los dos argumentos tienen que ser números.');

        return 1;
    }

    $this->info("$a + $b = " . ($a + $b));
})->purpose('Suma dos números');

// Ejercicio 08: php artisan academia:tabla 7
Artisan::command('academia:tabla {numero=1}', function (int $numero) {
    $filas = [];
    for ($i = 1; $i <= 10; $i++) {
        $filas[] = ["$numero × $i", $numero * $i];
    }

    $this->table(['Operación', 'Resultado'], $filas);
})->purpose('Muestra una tabla de multiplicar');

// Ejercicio 09: php artisan academia:ficha (hace preguntas)
Artisan::command('academia:ficha', function () {
    $nombre = $this->ask('¿Cómo te llamas?', 'invitado');
    $curso = $this->choice('¿Qué curso te interesa?', ['PHP', 'Laravel', 'JavaScript'], 0);
    $avisos = $this->confirm('¿Quieres recibir avisos?', true);

    $this->info("Ficha: $nombre · $curso · avisos: " . ($avisos ? 'sí' : 'no'));
})->purpose('Rellena una ficha respondiendo preguntas');

// Ejercicio 10: php artisan academia:limpiar
Artisan::command('academia:limpiar', function () {
    // $this->call() ejecuta otro comando de Artisan desde el nuestro
    $this->call('optimize:clear');
    $this->info('✨ Cachés borradas. Si el .env no te hacía caso, prueba ahora.');
})->purpose('Borra todas las cachés de la aplicación');
