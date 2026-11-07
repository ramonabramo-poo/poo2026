@extends('layouts.app')

@section('titulo', 'Panel')

@section('contenido')
    <h1>🛠️ Panel de gestión</h1>

    <p>Hola, {{ auth()->user()->name }}. Tu rol es <strong>{{ auth()->user()->rol->etiqueta() }}</strong>.</p>

    <ul>
        @can('create', App\Models\Curso::class)
            <li><a href="{{ route('cursos.create') }}">Crear un curso</a></li>
        @endcan
        <li><a href="{{ route('cursos.index') }}">Ver los cursos</a></li>
        @if (auth()->user()->esAdmin())
            <li><a href="{{ route('admin.sistema') }}">Información del sistema</a></li>
        @endif
    </ul>
@endsection
