@extends('layouts.app')

@section('titulo', 'Editar ' . $curso->titulo)

@section('contenido')
    <h1>✏️ Editar «{{ $curso->titulo }}»</h1>

    <form action="{{ route('cursos.update', $curso) }}" method="post" enctype="multipart/form-data">
        @csrf
        {{-- Los formularios solo saben GET y POST: así "disfrazamos" el POST de PUT --}}
        @method('PUT')

        @include('cursos.formulario')

        <button type="submit">Guardar los cambios</button>
        <a class="boton boton-secundario" href="{{ route('cursos.show', $curso) }}">Cancelar</a>
    </form>
@endsection
