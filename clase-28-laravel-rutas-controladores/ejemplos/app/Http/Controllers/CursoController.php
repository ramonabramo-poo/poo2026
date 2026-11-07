<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CursoController extends Controller
{
    // GET /cursos  y  GET /cursos?buscar=php
    public function index(Request $request): View
    {
        $buscar = $request->query('buscar', '');
        $cursos = config('academia.cursos');

        if ($buscar !== '') {
            $cursos = array_filter(
                $cursos,
                fn (array $curso) => str_contains(mb_strtolower($curso['titulo']), mb_strtolower($buscar))
            );
        }

        return view('cursos.index', [
            'cursos' => $cursos,
            'buscar' => $buscar,
        ]);
    }

    // GET /cursos/{curso}
    public function show(int $curso): View
    {
        $datos = config("academia.cursos.$curso");

        if ($datos === null) {
            abort(404);
        }

        return view('cursos.show', ['curso' => $datos]);
    }
}
