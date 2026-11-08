<?php

use App\Models\Categoria;
use App\Models\Curso;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
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
Artisan::command('academia:estadisticas', function () {
    $this->info('📊 Estadísticas de la academia');
    $this->line('Cursos: ' . DB::table('cursos')->count());
    $this->line('Alumnos: ' . DB::table('alumnos')->count());
    $this->line('Matrículas: ' . DB::table('alumno_curso')->count());
    $this->line('Precio medio: ' . number_format(DB::table('cursos')->avg('precio'), 2, ',', '.') . ' €');
    $this->line('Curso más caro: ' . DB::table('cursos')->orderByDesc('precio')->value('titulo'));
})->purpose('Muestra unas cifras de la academia');

// Ejercicio 05: php artisan academia:categoria "Idiomas"
Artisan::command('academia:categoria {nombre}', function (string $nombre) {
    // Busca por el slug; si no existe, la crea (el mutator del ejercicio 08 rellena el slug)
    $categoria = Categoria::firstOrCreate(['slug' => Str::slug($nombre)], ['nombre' => $nombre]);

    $this->info($categoria->wasRecentlyCreated ? "Categoría «{$categoria->nombre}» creada." : "Ya existía: «{$categoria->nombre}».");
})->purpose('Crea una categoría si no existe');

// Ejercicio 09: php artisan academia:papelera 5  /  --restaurar  /  --forzar
Artisan::command('academia:papelera {id} {--restaurar} {--forzar}', function (int $id) {
    $curso = Curso::withTrashed()->find($id);

    if ($curso === null) {
        $this->error('Ese curso no existe ni en la papelera.');

        return 1;
    }

    if ($this->option('restaurar')) {
        $curso->restore();
        $this->info("«{$curso->titulo}» restaurado.");
    } elseif ($this->option('forzar')) {
        $curso->forceDelete();
        $this->warn("«{$curso->titulo}» borrado para siempre.");
    } else {
        $curso->delete();
        $this->info("«{$curso->titulo}» a la papelera. Cursos en la papelera: " . Curso::onlyTrashed()->count() . '.');
    }
})->purpose('Borra, restaura o elimina definitivamente un curso');

// Ejercicio 10: php artisan academia:resumen (métodos de colección sobre modelos)
Artisan::command('academia:resumen', function () {
    $filas = Curso::with('categoria')->get()
        ->groupBy(fn (Curso $curso) => $curso->categoria->nombre)
        ->map(fn ($cursos, $categoria) => [
            $categoria,
            $cursos->count(),
            number_format($cursos->avg('precio'), 2, ',', '.') . ' €',
            $cursos->sortByDesc('precio')->first()->titulo,
        ])
        ->sortBy(0)
        ->values();

    $this->table(['Categoría', 'Cursos', 'Precio medio', 'El más caro'], $filas);
})->purpose('Resumen de cursos por categoría');
