<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

// Ejercicio 06: php artisan academia:copia-seguridad --mantener=7
class CopiaSeguridad extends Command
{
    protected $signature = 'academia:copia-seguridad {--mantener=7 : Cuántas copias se guardan}';

    protected $description = 'Hace una copia comprimida de la base de datos en storage/app/private/copias';

    public function handle(): int
    {
        $bd = config('database.connections.' . config('database.default'));

        if ($bd['driver'] !== 'mysql' && $bd['driver'] !== 'mariadb') {
            $this->error('Este comando solo sabe copiar bases de datos MySQL o MariaDB.');

            return self::FAILURE;
        }

        // Los argumentos van en un array, NUNCA pegados en un texto: así ningún dato
        // puede colarse como una orden del sistema. La contraseña, por una variable de entorno
        $proceso = Process::env(['MYSQL_PWD' => $bd['password']])
            ->timeout(300)
            ->run([
                'mysqldump',
                '--host=' . $bd['host'],
                '--port=' . $bd['port'],
                '--user=' . $bd['username'],
                '--single-transaction',   // copia coherente sin bloquear las tablas
                '--routines',
                $bd['database'],
            ]);

        if ($proceso->failed()) {
            $this->error('La copia ha fallado: ' . $proceso->errorOutput());

            return self::FAILURE;
        }

        $fichero = 'copias/' . $bd['database'] . '-' . now()->format('Ymd-His') . '.sql.gz';
        Storage::put($fichero, gzencode($proceso->output(), 9));

        $this->info("✅ Copia guardada en storage/app/private/{$fichero} (" . round(Storage::size($fichero) / 1024, 1) . ' KB)');

        $this->borrarLasAntiguas((int) $this->option('mantener'));

        return self::SUCCESS;
    }

    // Deja solo las N copias más recientes (los nombres llevan la fecha, así que se ordenan solos)
    private function borrarLasAntiguas(int $mantener): void
    {
        $copias = collect(Storage::files('copias'))->sort()->values();
        $sobran = $copias->slice(0, max(0, $copias->count() - $mantener));

        foreach ($sobran as $copia) {
            Storage::delete($copia);
            $this->line("🗑️ Borrada la copia antigua {$copia}");
        }
    }
}
