@extends('layouts.app')

@section('titulo', 'Alumnos de ' . $categoria->nombre)

@section('contenido')
    <h1>👥 Alumnos de {{ $categoria->nombre }} ({{ $alumnos->count() }})</h1>
    <ul>
        @forelse ($alumnos as $alumno)
            <li>
                {{ $alumno->nombre_completo }}:
                {{ $alumno->cursos->pluck('titulo')->join(', ') }}
            </li>
        @empty
            <li>Nadie se ha matriculado todavía en esta categoría.</li>
        @endforelse
    </ul>
@endsection
