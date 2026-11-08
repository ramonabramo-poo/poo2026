<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PaginaController extends Controller
{
    public function inicio(): View
    {
        $cursos = config('academia.cursos');

        return view('paginas.inicio', [
            'totalCursos' => count($cursos),
            'destacados' => array_slice($cursos, 0, 3),
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
