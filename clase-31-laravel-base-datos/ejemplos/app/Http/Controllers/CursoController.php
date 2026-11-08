<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CursoController extends Controller
{
    // GET /cursos  y  GET /cursos?buscar=php
    public function index(Request $request): View
    {
        $buscar = $request->query('buscar', '');

        $cursos = DB::table('cursos')
            ->join('categorias', 'categorias.id', '=', 'cursos.categoria_id')
            ->select('cursos.*', 'categorias.nombre as categoria')
            ->where('cursos.publicado', true)
            ->when($buscar !== '', function ($consulta) use ($buscar) {
                $consulta->where('cursos.titulo', 'like', "%{$buscar}%");
            })
            ->orderBy('cursos.titulo')
            ->get();

        return view('cursos.index', [
            'cursos' => $cursos,
            'buscar' => $buscar,
        ]);
    }

    // GET /cursos/{curso}
    public function show(int $curso): View
    {
        $datos = DB::table('cursos')
            ->join('categorias', 'categorias.id', '=', 'cursos.categoria_id')
            ->select('cursos.*', 'categorias.nombre as categoria')
            ->where('cursos.id', $curso)
            ->first();

        if ($datos === null) {
            abort(404);
        }

        $totalAlumnos = DB::table('alumno_curso')->where('curso_id', $curso)->count();

        return view('cursos.show', [
            'curso' => $datos,
            'totalAlumnos' => $totalAlumnos,
        ]);
    }
}
