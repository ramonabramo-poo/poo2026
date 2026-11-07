<?php

namespace App\Http\Controllers;

use App\Models\Curso;
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
}
