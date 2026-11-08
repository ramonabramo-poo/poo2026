<?php

namespace App\Http\Controllers;

use App\Contracts\Notificador;
use App\Models\Curso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PaginaController extends Controller
{
    public function inicio(): View
    {
        // Las consultas de la portada se guardan 10 minutos en la caché
        $datos = Cache::remember('portada', now()->addMinutes(10), function () {
            return [
                'totalCursos' => Curso::publicados()->count(),
                // Los tres que empiezan antes
                'destacados' => Curso::publicados()
                    ->with('categoria')
                    ->withCount('alumnos')
                    ->orderBy('fecha_inicio')
                    ->take(3)
                    ->get(),
            ];
        });

        return view('paginas.inicio', $datos);
    }

    public function contacto(): View
    {
        return view('paginas.contacto', [
            'telefono' => config('academia.telefono'),
            'email' => config('academia.email'),
        ]);
    }

    // POST /contacto: validación directamente en el controlador
    // El Notificador lo inyecta el contenedor: el controlador no sabe qué clase es
    public function enviarContacto(Request $request, Notificador $notificador): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:60'],
            'email' => ['required', 'email'],
            'mensaje' => ['required', 'string', 'min:10', 'max:1000'],
            'acepto' => ['accepted'],
        ]);

        $notificador->notificar(
            config('academia.email'),
            "Nuevo mensaje de {$datos['nombre']} ({$datos['email']})",
            $datos['mensaje'],
        );

        return redirect()
            ->route('contacto')
            ->with('exito', "Gracias, {$datos['nombre']}. Os responderemos muy pronto.");
    }

    // GET /admin/sistema (la antigua página /info de la clase 28)
    public function sistema(): View
    {
        return view('info', [
            'nombreApp' => config('app.name'),
            'entorno' => app()->environment(),
            'depuracion' => config('app.debug'),
            'idioma' => config('app.locale'),
            'zonaHoraria' => config('app.timezone'),
            'versionLaravel' => app()->version(),
            'versionPhp' => PHP_VERSION,
            'ahora' => now()->format('d/m/Y H:i'),
        ]);
    }
}
