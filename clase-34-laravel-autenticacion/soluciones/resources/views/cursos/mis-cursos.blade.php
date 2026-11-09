@extends('layouts.app')

@section('titulo', 'Mis cursos')

@section('contenido')
    <h1>📚 Mis cursos</h1>

    <p><a class="boton" href="{{ route('cursos.create') }}">➕ Nuevo curso</a></p>

    <table>
        <tr>
            <th>Curso</th>
            <th>Categoría</th>
            <th>Alumnos</th>
            <th>Estado</th>
            <th></th>
        </tr>
        @forelse ($cursos as $curso)
            <tr>
                <td><a href="{{ route('cursos.show', $curso) }}">{{ $curso->titulo }}</a></td>
                <td>{{ $curso->categoria->nombre }}</td>
                <td>{{ $curso->alumnos_count }} de {{ $curso->plazas }}</td>
                <td>{{ $curso->publicado ? 'Publicado' : 'Borrador' }}</td>
                <td><a href="{{ route('cursos.edit', $curso) }}">✏️ Editar</a></td>
            </tr>
        @empty
            <tr><td colspan="5">Todavía no has creado ningún curso.</td></tr>
        @endforelse
    </table>
@endsection
