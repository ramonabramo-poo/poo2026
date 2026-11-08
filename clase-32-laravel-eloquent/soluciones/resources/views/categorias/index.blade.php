@extends('layouts.app')

@section('titulo', 'Categorías')

@section('contenido')
    <h1>🏷️ Categorías</h1>
    <table>
        <tr><th>Categoría</th><th>Cursos</th><th>Publicados</th><th></th></tr>
        @foreach ($categorias as $categoria)
            <tr>
                <td><a href="{{ route('categorias.show', $categoria) }}">{{ $categoria->nombre }}</a></td>
                <td>{{ $categoria->cursos_count }}</td>
                <td>{{ $categoria->publicados_count }}</td>
                <td><a href="{{ route('categorias.alumnos', $categoria) }}">Ver alumnos</a></td>
            </tr>
        @endforeach
    </table>
@endsection
