@extends('layouts.app')

@section('titulo', 'Próximos cursos')

@section('contenido')
    <h1>📅 Empiezan en los próximos 30 días</h1>

    <table>
        <tr><th>Curso</th><th>Empieza</th><th>Valoración</th></tr>
        @forelse ($cursos as $curso)
            <tr>
                <td><a href="{{ route('cursos.show', $curso->id) }}">{{ $curso->titulo }}</a></td>
                <td>{{ date('d/m/Y', strtotime($curso->fecha_inicio)) }}</td>
                <td>{{ $curso->estrellas !== null ? $curso->estrellas . ' ⭐' : 'sin valoraciones' }}</td>
            </tr>
        @empty
            <tr><td colspan="3">No empieza ningún curso en los próximos 30 días.</td></tr>
        @endforelse
    </table>
@endsection
