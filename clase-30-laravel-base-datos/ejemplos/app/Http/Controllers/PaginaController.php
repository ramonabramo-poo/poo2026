<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PaginaController extends Controller
{
    public function inicio(): View
    {
        return view('paginas.inicio', [
            'totalCursos' => DB::table('cursos')->where('publicado', true)->count(),
            // Los tres que empiezan antes
            'destacados' => DB::table('cursos')
                ->where('publicado', true)
                ->join('categorias', 'categorias.id', '=', 'cursos.categoria_id')
                ->select('cursos.*', 'categorias.nombre as categoria')
                ->orderBy('fecha_inicio')
                ->limit(3)
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
