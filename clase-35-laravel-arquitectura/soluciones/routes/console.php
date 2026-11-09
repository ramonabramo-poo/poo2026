<?php

use App\Models\Categoria;
use App\Models\Curso;
use App\Servicios\CalculadoraPrecios;
use App\Servicios\EstadisticasAcademia;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
// Ejercicio 04: las cifras salen del servicio, el mismo que usa el panel
Artisan::command('academia:estadisticas', function (EstadisticasAcademia $estadisticas) {
    $this->info('📊 Estadísticas de la academia');
    $this->line('Cursos: ' . $estadisticas->totalCursos());
    $this->line('Alumnos: ' . $estadisticas->totalAlumnos());
    $this->line('Matrículas: ' . $estadisticas->totalMatriculas());
    $this->line('Precio medio: ' . number_format($estadisticas->precioMedio(), 2, ',', '.') . ' €');
    $this->line('Curso más popular: ' . ($estadisticas->cursoMasPopular()?->titulo ?? '—'));
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

// Ejercicio 10: php artisan academia:categoria   (pregunta lo que falte)
// La facade Validator valida datos que no vienen de una petición
Artisan::command('academia:categoria {nombre?}', function (?string $nombre = null) {
    $nombre ??= $this->ask('¿Cómo se llama la nueva categoría?');

    $validador = Validator::make(['nombre' => $nombre], [
        'nombre' => ['required', 'string', 'min:3', 'max:60', 'unique:categorias,nombre'],
    ]);

    if ($validador->fails()) {
        $this->error($validador->errors()->first('nombre'));

        return 1;
    }

    $slug = Str::slug($nombre);

    if (! $this->confirm("Se creará «{$nombre}» con la dirección /categorias/{$slug}. ¿Seguimos?", true)) {
        $this->warn('No se ha creado nada.');

        return 0;
    }

    Categoria::create(['nombre' => $nombre, 'slug' => $slug]);
    $this->info('✅ Categoría creada.');
})->purpose('Crea una categoría desde la consola');
