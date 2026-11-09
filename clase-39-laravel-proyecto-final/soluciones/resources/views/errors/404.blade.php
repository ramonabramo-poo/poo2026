{{-- Ejercicio 07: el 404 sí puede usar el layout (la aplicación funciona; solo falta la página) --}}
@extends('layouts.app')

@section('titulo', 'Página no encontrada')

@section('contenido')
    <h1>🧭 Esta página no existe</h1>

    <p>Puede que el enlace esté mal escrito o que el curso ya no se ofrezca.</p>

    <form action="{{ route('cursos.index') }}" method="get" class="campo">
        <label for="buscar">¿Buscabas un curso?</label>
        <input type="search" id="buscar" name="buscar" placeholder="Por ejemplo, PHP">
        <button type="submit">Buscar</button>
    </form>

    <p><a class="boton" href="{{ route('inicio') }}">Volver a la portada</a></p>
@endsection
