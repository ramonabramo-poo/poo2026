<?php

use App\Enums\Rol;
use App\Jobs\EnviarRecordatoriosCurso;
use App\Models\Curso;
use App\Models\User;
use App\Notifications\InformeSemanal;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schedule;

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

// Ejercicio 04: php artisan academia:informe-semanal
Artisan::command('academia:informe-semanal', function () {
    $cursos = Curso::publicados()
        ->whereBetween('fecha_inicio', [now()->startOfWeek(), now()->endOfWeek()])
        ->withCount('alumnos')
        ->orderBy('fecha_inicio')
        ->get()
        ->map(fn (Curso $curso) => [
            'titulo' => $curso->titulo,
            'fecha' => $curso->fecha_inicio->format('d/m/Y'),
            'alumnos' => $curso->alumnos_count,
            'plazas' => $curso->plazas,
        ])
        ->all();

    $administradores = User::where('rol', Rol::Admin)->get();
    Notification::send($administradores, new InformeSemanal($cursos));

    $this->info('Informe enviado a ' . $administradores->count() . ' administradores (' . count($cursos) . ' cursos).');
})->purpose('Envía a los administradores los cursos que empiezan esta semana');

// Ejercicio 10: php artisan academia:limpiar-notificaciones --dias=30
Artisan::command('academia:limpiar-notificaciones {--dias=30}', function () {
    $borradas = DB::table('notifications')
        ->whereNotNull('read_at')
        ->where('read_at', '<', now()->subDays((int) $this->option('dias')))
        ->delete();

    $this->info("Notificaciones leídas borradas: {$borradas}.");
})->purpose('Borra las notificaciones leídas hace tiempo');

// TAREAS PROGRAMADAS: el planificador las ejecuta cuando toca (php artisan schedule:work)
Schedule::command('academia:recordatorios')->dailyAt('09:00');
Schedule::command('sanctum:prune-expired --hours=24')->daily();
Schedule::command('academia:informe-semanal')->weeklyOn(1, '08:00');     // Ejercicio 04: lunes a las 8:00
Schedule::command('academia:limpiar-notificaciones')->dailyAt('03:00')    // Ejercicio 10
    ->withoutOverlapping();
