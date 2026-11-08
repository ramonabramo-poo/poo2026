<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CursoController extends Controller
{
    // GET /cursos?buscar=php&max=250&ordenar=precio
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

        // Ejercicio 07: más datos de la URL con $request
        if ($request->filled('max')) {
            $maximo = (float) $request->query('max');
            $cursos = array_filter($cursos, fn (array $curso) => $curso['precio'] <= $maximo);
        }

        $ordenar = $request->query('ordenar', 'titulo');
        if (in_array($ordenar, ['titulo', 'precio', 'horas'], true)) {
            uasort($cursos, fn (array $a, array $b) => $a[$ordenar] <=> $b[$ordenar]);
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

    // Ejercicio 01: GET /cursos/categoria/{categoria}
    public function porCategoria(string $categoria): View
    {
        $cursos = array_filter(
            config('academia.cursos'),
            fn (array $curso) => $curso['categoria'] === $categoria
        );

        if ($cursos === []) {
            abort(404);
        }

        return view('cursos.index', [
            'cursos' => $cursos,
            'buscar' => '',
        ]);
    }
}
