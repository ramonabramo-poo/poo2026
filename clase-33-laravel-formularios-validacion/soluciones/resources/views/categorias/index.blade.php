@extends('layouts.app')

@section('titulo', 'Categorías')

@section('contenido')
    <h1>🏷️ Categorías</h1>

    <p><a class="boton" href="{{ route('categorias.create') }}">➕ Nueva categoría</a></p>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Cursos</th>
            <th></th>
        </tr>
        @foreach ($categorias as $categoria)
            <tr>
                <td><a href="{{ route('categorias.show', $categoria) }}">{{ $categoria->nombre }}</a></td>
                <td>{{ $categoria->cursos_count }}</td>
                <td>
                    <form action="{{ route('categorias.destroy', $categoria->id) }}" method="post"
                        onsubmit="return confirm('¿Borrar la categoría?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="boton-peligro">Borrar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
