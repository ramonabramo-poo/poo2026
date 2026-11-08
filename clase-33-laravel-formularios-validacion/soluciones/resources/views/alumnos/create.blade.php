@extends('layouts.app')

@section('titulo', 'Nuevo alumno')

@section('contenido')
    <h1>➕ Nuevo alumno</h1>

    <form action="{{ route('alumnos.store') }}" method="post">
        @csrf

        @include('alumnos.formulario')

        <button type="submit">Dar de alta</button>
        <a class="boton boton-secundario" href="{{ route('alumnos.index') }}">Cancelar</a>
    </form>
@endsection
