<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

// Ejercicio 02: un comando "de clase" (app/Console/Commands), que Laravel registra solo
class ComprobarDespliegue extends Command
{
    protected $signature = 'academia:comprobar';

    protected $description = 'Revisa que la aplicación está lista para producción';

    public function handle(): int
    {
        $comprobaciones = [
            'La clave APP_KEY está generada' => filled(config('app.key')),
            'APP_DEBUG está desactivado' => ! config('app.debug'),
            'APP_ENV es production' => app()->isProduction(),
            'APP_URL usa https' => str_starts_with(config('app.url'), 'https://'),
            'Hay conexión con la base de datos' => $this->hayBaseDeDatos(),
            'Existe el enlace public/storage' => file_exists(public_path('storage')),
            'storage/ se puede escribir' => is_writable(storage_path()),
            'La cola no es "sync"' => config('queue.default') !== 'sync',
            'El correo no va al log' => config('mail.default') !== 'log',
        ];

        $fallos = 0;

        foreach ($comprobaciones as $texto => $correcto) {
            if ($correcto) {
                $this->line("  ✅ {$texto}");
            } else {
                $this->line("  ❌ {$texto}");
                $fallos++;
            }
        }

        if ($fallos > 0) {
            $this->error("Hay {$fallos} cosas por revisar antes de publicar.");

            return self::FAILURE;
        }

        $this->info('Todo listo para producción. 🚀');

        return self::SUCCESS;
    }

    private function hayBaseDeDatos(): bool
    {
        try {
            DB::connection()->getPdo();

            return true;
        } catch (Throwable) {
            return false;
        }
    }
}
