@extends('layouts.app')

@section('titulo', 'Editar alumno')

@section('contenido')
    <h1>✏️ Editar a {{ $alumno->nombre_completo }}</h1>

    <form action="{{ route('alumnos.update', $alumno) }}" method="post">
        @csrf
        @method('PUT')

        @include('alumnos.formulario')

        <button type="submit">Guardar los cambios</button>
        <a class="boton boton-secundario" href="{{ route('alumnos.index') }}">Cancelar</a>
    </form>
@endsection
