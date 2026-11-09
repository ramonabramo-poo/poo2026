@extends('layouts.app')

@section('titulo', 'Panel')

@section('contenido')
    <h1>🛠️ Panel de gestión</h1>

    <p>Hola, {{ auth()->user()->name }}. Tu rol es <strong>{{ auth()->user()->rol->etiqueta() }}</strong>.</p>

    <ul>
        @can('create', App\Models\Curso::class)
            <li><a href="{{ route('cursos.create') }}">Crear un curso</a></li>
            <li><a href="{{ route('mis-cursos') }}">Mis cursos</a></li>  {{-- Ejercicio 05 --}}
        @endcan
        <li><a href="{{ route('cursos.index') }}">Ver los cursos</a></li>
    </ul>
@endsection
