@extends('layouts.app')

@section('titulo', 'Alumnos')

@section('contenido')
    <h1>🎒 Alumnos</h1>

    <table>
        <tr>
            <th>Alumno</th>
            <th>Correo</th>
            <th>Cursos</th>
        </tr>
        @foreach ($alumnos as $alumno)
            <tr>
                <td><a href="{{ route('alumnos.show', $alumno) }}">{{ $alumno->nombre_completo }}</a></td>
                <td>{{ $alumno->email }}</td>
                <td>{{ $alumno->cursos_count }}</td>
            </tr>
        @endforeach
    </table>

    {{ $alumnos->links() }}
@endsection
