@extends('layouts.app')

@section('titulo', 'Nuevo curso')

@section('contenido')
    <h1>➕ Nuevo curso</h1>

    {{-- enctype es obligatorio para poder enviar archivos --}}
    <form action="{{ route('cursos.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        @include('cursos.formulario')

        <button type="submit">Crear el curso</button>
        <a class="boton boton-secundario" href="{{ route('cursos.index') }}">Cancelar</a>
    </form>
@endsection
