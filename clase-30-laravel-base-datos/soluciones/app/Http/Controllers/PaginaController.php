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

    // Ejercicio 02: GET /estadisticas
    public function estadisticas(): View
    {
        $porCategoria = DB::table('categorias')
            ->leftJoin('cursos', 'cursos.categoria_id', '=', 'categorias.id')
            ->select(
                'categorias.nombre',
                DB::raw('COUNT(cursos.id) AS total_cursos'),
                DB::raw('COALESCE(SUM(cursos.horas), 0) AS total_horas'),
                DB::raw('COALESCE(AVG(cursos.precio), 0) AS precio_medio')
            )
            ->groupBy('categorias.id', 'categorias.nombre')
            ->orderByDesc('total_cursos')
            ->get();

        $masAlumnos = DB::table('cursos')
            ->join('alumno_curso', 'alumno_curso.curso_id', '=', 'cursos.id')
            ->select('cursos.titulo', DB::raw('COUNT(*) AS total_alumnos'))
            ->groupBy('cursos.id', 'cursos.titulo')
            ->orderByDesc('total_alumnos')
            ->limit(5)
            ->get();

        return view('paginas.estadisticas', [
            'porCategoria' => $porCategoria,
            'masAlumnos' => $masAlumnos,
        ]);
    }
}
