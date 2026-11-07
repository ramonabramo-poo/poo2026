<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\View\View;

class AlumnoController extends Controller
{
    public function index(): View
    {
        $alumnos = Alumno::withCount('cursos')
            ->orderBy('apellidos')
            ->orderBy('nombre')
            ->paginate(10);

        return view('alumnos.index', ['alumnos' => $alumnos]);
    }

    public function show(Alumno $alumno): View
    {
        $alumno->load('cursos.categoria');

        return view('alumnos.show', ['alumno' => $alumno]);
    }
}
