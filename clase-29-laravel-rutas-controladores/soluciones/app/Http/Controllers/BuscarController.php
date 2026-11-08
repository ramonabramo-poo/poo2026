<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Ejercicio 05: un controlador INVOCABLE (php artisan make:controller BuscarController --invokable)
class BuscarController extends Controller
{
    public function __invoke(Request $request): array
    {
        $texto = mb_strtolower($request->query('q', ''));

        $cursos = array_filter(
            config('academia.cursos'),
            fn (array $curso) => $texto !== '' && str_contains(mb_strtolower($curso['titulo']), $texto)
        );

        return [
            'buscado' => $texto,
            'resultados' => array_column($cursos, 'titulo'),
        ];
    }
}
