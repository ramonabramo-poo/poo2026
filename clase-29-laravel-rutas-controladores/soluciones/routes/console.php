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

// php artisan academia:cursos   o   php artisan academia:cursos --categoria=diseno
Artisan::command('academia:cursos {--categoria=}', function () {
    $categoria = $this->option('categoria');
    $cursos = config('academia.cursos');

    if ($categoria !== null) {
        $cursos = array_filter($cursos, fn (array $curso) => $curso['categoria'] === $categoria);
    }

    if ($cursos === []) {
        $this->warn('No hay cursos en esa categoría.');

        return;
    }

    $this->table(['Id', 'Título', 'Categoría', 'Horas', 'Precio'], $cursos);
})->purpose('Lista los cursos de la academia');

// Ejercicio 09: php artisan academia:curso 3
Artisan::command('academia:curso {id}', function (int $id) {
    $curso = config("academia.cursos.$id");

    if ($curso === null) {
        $this->error("No existe el curso $id.");

        return 1;
    }

    $this->info("📘 {$curso['titulo']}");
    $this->line("Categoría: {$curso['categoria']} · {$curso['horas']} horas · " . number_format($curso['precio'], 2, ',', '.') . ' €');
})->purpose('Muestra la ficha de un curso');
