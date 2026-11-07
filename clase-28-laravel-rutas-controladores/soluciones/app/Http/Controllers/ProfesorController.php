<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ProfesorController extends Controller
{
    public function index(): View
    {
        return view('profesores.index', [
            'profesores' => config('academia.profesores'),
        ]);
    }

    public function show(int $profesor): View
    {
        $datos = config("academia.profesores.$profesor") ?? abort(404);

        return view('profesores.show', ['profesor' => $datos]);
    }
}
