<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Throwable;

// Ejercicio 09: después de desplegar, ¿responde lo importante?
// php artisan academia:humo   o   php artisan academia:humo https://academia.example.com
class PruebasHumo extends Command
{
    protected $signature = 'academia:humo {url? : La dirección de la web (por defecto, APP_URL)}';

    protected $description = 'Comprueba que las páginas principales responden después de desplegar';

    // Dirección => código que esperamos
    private const PAGINAS = [
        '/' => 200,
        '/cursos' => 200,
        '/contacto' => 200,
        '/login' => 200,
        '/admin' => 302,              // sin sesión, redirige al login
        '/api/estado' => 200,
        '/api/v1/cursos' => 200,
        '/up' => 200,
        '/esta-pagina-no-existe' => 404,
    ];

    public function handle(): int
    {
        $base = rtrim($this->argument('url') ?? config('app.url'), '/');
        $filas = [];
        $fallos = 0;

        foreach (self::PAGINAS as $ruta => $esperado) {
            $inicio = microtime(true);

            try {
                // withoutRedirecting(): queremos ver el 302, no seguirlo
                $codigo = Http::timeout(10)->withoutRedirecting()->get($base . $ruta)->status();
            } catch (Throwable $error) {
                $codigo = 0;   // ni siquiera ha respondido
            }

            $milisegundos = round((microtime(true) - $inicio) * 1000);
            $correcto = $codigo === $esperado;
            $fallos += $correcto ? 0 : 1;

            $filas[] = [$correcto ? '✅' : '❌', $ruta, $esperado, $codigo ?: 'sin respuesta', "{$milisegundos} ms"];
        }

        $this->table(['', 'Página', 'Esperado', 'Recibido', 'Tiempo'], $filas);

        if ($fallos > 0) {
            $this->error("{$fallos} páginas no responden como deberían.");

            return self::FAILURE;
        }

        $this->info('Todo responde. 🎉');

        return self::SUCCESS;
    }
}
