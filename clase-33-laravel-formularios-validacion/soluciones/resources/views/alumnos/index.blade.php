@extends('layouts.app')

@section('titulo', 'Alumnos')

@section('contenido')
    <h1>👥 Alumnos</h1>

    <p><a class="boton" href="{{ route('alumnos.create') }}">➕ Nuevo alumno</a></p>

    <table>
        <tr>
            <th>Alumno</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Cursos</th>
            <th></th>
        </tr>
        @forelse ($alumnos as $alumno)
            <tr>
                <td>{{ $alumno->apellidos }}, {{ $alumno->nombre }}</td>
                <td>{{ $alumno->email }}</td>
                <td>{{ $alumno->telefono ?? '—' }}</td>
                <td>{{ $alumno->cursos_count }}</td>
                <td><a href="{{ route('alumnos.edit', $alumno) }}">✏️ Editar</a></td>
            </tr>
        @empty
            <tr><td colspan="5">Todavía no hay alumnos.</td></tr>
        @endforelse
    </table>

    {{ $alumnos->links() }}
@endsection
