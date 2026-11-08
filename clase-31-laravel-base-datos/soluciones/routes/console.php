<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

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
    $cursos = DB::table('cursos')
        ->join('categorias', 'categorias.id', '=', 'cursos.categoria_id')
        ->when($this->option('categoria'), function ($consulta, string $categoria) {
            $consulta->where('categorias.slug', $categoria);
        })
        ->orderBy('cursos.id')
        ->get(['cursos.id', 'cursos.titulo', 'categorias.nombre', 'cursos.horas', 'cursos.precio']);

    if ($cursos->isEmpty()) {
        $this->warn('No hay cursos en esa categoría.');

        return;
    }

    // table() quiere arrays, y el Query Builder devuelve objetos
    $this->table(['Id', 'Título', 'Categoría', 'Horas', 'Precio'], $cursos->map(fn ($curso) => (array) $curso));
})->purpose('Lista los cursos de la academia');

// php artisan academia:estadisticas
Artisan::command('academia:estadisticas', function () {
    $this->info('📊 Estadísticas de la academia');
    $this->line('Cursos: ' . DB::table('cursos')->count());
    $this->line('Alumnos: ' . DB::table('alumnos')->count());
    $this->line('Matrículas: ' . DB::table('alumno_curso')->count());
    $this->line('Precio medio: ' . number_format(DB::table('cursos')->avg('precio'), 2, ',', '.') . ' €');
    $this->line('Curso más caro: ' . DB::table('cursos')->orderByDesc('precio')->value('titulo'));
})->purpose('Muestra unas cifras de la academia');

// Ejercicio 03: php artisan academia:matricular 5 2
Artisan::command('academia:matricular {alumno} {curso}', function (int $alumno, int $curso) {
    $datosAlumno = DB::table('alumnos')->find($alumno);
    $datosCurso = DB::table('cursos')->find($curso);

    if ($datosAlumno === null || $datosCurso === null) {
        $this->error('El alumno o el curso no existen.');

        return 1;
    }

    $yaMatriculado = DB::table('alumno_curso')
        ->where('alumno_id', $alumno)
        ->where('curso_id', $curso)
        ->exists();

    if ($yaMatriculado) {
        $this->warn("{$datosAlumno->nombre} ya está matriculado en {$datosCurso->titulo}.");

        return 1;
    }

    $ocupadas = DB::table('alumno_curso')->where('curso_id', $curso)->count();

    if ($ocupadas >= $datosCurso->plazas) {
        $this->error("No quedan plazas en {$datosCurso->titulo}.");

        return 1;
    }

    DB::table('alumno_curso')->insert([
        'alumno_id' => $alumno,
        'curso_id' => $curso,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->info("✅ {$datosAlumno->nombre} {$datosAlumno->apellidos} matriculado en {$datosCurso->titulo}.");
})->purpose('Matricula a un alumno en un curso');
