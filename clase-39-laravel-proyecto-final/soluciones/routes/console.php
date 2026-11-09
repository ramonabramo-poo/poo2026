<?php

use App\Acciones\MatricularAlumno;
use App\Exceptions\SinPlazasException;
use App\Jobs\EnviarRecordatoriosCurso;
use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Validation\ValidationException;

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

// php artisan academia:recordatorios: un job a la cola por cada curso que empieza mañana
Artisan::command('academia:recordatorios', function () {
    $cursos = Curso::publicados()->whereDate('fecha_inicio', today()->addDay())->get();

    foreach ($cursos as $curso) {
        EnviarRecordatoriosCurso::dispatch($curso);
    }

    $this->info("Recordatorios en cola: {$cursos->count()} cursos.");
})->purpose('Avisa a los alumnos de los cursos que empiezan mañana');

// Ejercicio 04: la MISMA acción que usa el controlador, ahora desde la consola
// php artisan academia:matricular 3 17
Artisan::command('academia:matricular {curso} {alumno}', function (MatricularAlumno $matricular, int $curso, int $alumno) {
    $cursoElegido = Curso::findOrFail($curso);
    $alumnoElegido = Alumno::findOrFail($alumno);

    try {
        $matricular->ejecutar($cursoElegido, $alumnoElegido);
    } catch (SinPlazasException|ValidationException $error) {
        $this->error($error->getMessage());

        return 1;
    }

    $this->info("✅ {$alumnoElegido->nombre_completo} matriculado en «{$cursoElegido->titulo}».");
})->purpose('Matricula a un alumno en un curso');

// TAREAS PROGRAMADAS: el planificador las ejecuta cuando toca (php artisan schedule:work)
Schedule::command('academia:recordatorios')->dailyAt('09:00');
Schedule::command('sanctum:prune-expired --hours=24')->daily();
Schedule::command('academia:copia-seguridad --mantener=7')->dailyAt('02:30');   // Ejercicio 06
