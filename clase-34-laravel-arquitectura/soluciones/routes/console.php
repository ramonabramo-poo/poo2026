<?php

use App\Models\Curso;
use App\Servicios\CalculadoraPrecios;
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

// Ejercicio 03: php artisan academia:presupuesto 3 --descuento=10
// Los comandos también reciben servicios del contenedor como parámetros
Artisan::command('academia:presupuesto {curso} {--descuento=0}', function (CalculadoraPrecios $calculadora, int $curso) {
    $datos = Curso::find($curso);

    if ($datos === null) {
        $this->error('Ese curso no existe.');

        return 1;
    }

    $base = $calculadora->conDescuento((float) $datos->precio, (int) $this->option('descuento'));

    $this->info("🧾 {$datos->titulo}");
    $this->table(['Concepto', 'Importe'], [
        ['Precio', $calculadora->formatear((float) $datos->precio)],
        ['Con descuento', $calculadora->formatear($base)],
        ['Total con IVA', $calculadora->formatear($calculadora->conIva($base))],
    ]);
})->purpose('Calcula el presupuesto de un curso');
