<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaginaController extends Controller
{
    public function inicio(): View
    {
        return view('paginas.inicio', [
            'totalCursos' => Curso::publicados()->count(),
            // Los tres que empiezan antes
            'destacados' => Curso::publicados()
                ->with('categoria')
                ->withCount('alumnos')
                ->orderBy('fecha_inicio')
                ->take(3)
                ->get(),
        ]);
    }

    public function contacto(): View
    {
        return view('paginas.contacto', [
            'telefono' => config('academia.telefono'),
            'email' => config('academia.email'),
        ]);
    }

    // POST /contacto: validación directamente en el controlador
    public function enviarContacto(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:60'],
            'email' => ['required', 'email'],
            'mensaje' => ['required', 'string', 'min:10', 'max:1000'],
            'acepto' => ['accepted'],
        ]);

        // En la clase 37 enviaremos este mensaje por correo

        return redirect()
            ->route('contacto')
            ->with('exito', "Gracias, {$datos['nombre']}. Os responderemos muy pronto.");
    }
}
