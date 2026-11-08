<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumnoRequest;
use App\Models\Alumno;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

// Ejercicios 04 y 05
class AlumnoController extends Controller
{
    public function index(): View
    {
        return view('alumnos.index', [
            'alumnos' => Alumno::withCount('cursos')->orderBy('apellidos')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('alumnos.create', [
            'alumno' => new Alumno(),
        ]);
    }

    public function store(AlumnoRequest $request): RedirectResponse
    {
        // El mutator del modelo guarda el correo en minúsculas
        $alumno = Alumno::create($request->validated());

        return redirect()
            ->route('alumnos.index')
            ->with('exito', "Alumno {$alumno->nombre_completo} dado de alta.");
    }

    public function edit(Alumno $alumno): View
    {
        return view('alumnos.edit', [
            'alumno' => $alumno,
        ]);
    }

    public function update(AlumnoRequest $request, Alumno $alumno): RedirectResponse
    {
        $alumno->update($request->validated());

        return redirect()
            ->route('alumnos.index')
            ->with('exito', 'Datos del alumno guardados.');
    }
}
