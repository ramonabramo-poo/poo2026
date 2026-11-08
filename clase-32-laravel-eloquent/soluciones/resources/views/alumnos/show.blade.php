@extends('layouts.app')

@section('titulo', $alumno->nombre_completo)

@section('contenido')
    <h1>{{ $alumno->nombre_completo }}</h1>

    <p>Correo: {{ $alumno->email }}</p>
    <p>Teléfono: {{ $alumno->telefono ?? 'no indicado' }}</p>
    <p>Edad: {{ $alumno->fecha_nacimiento?->age ?? '—' }} años</p>

    <h2>Sus cursos</h2>
    <table>
        <tr>
            <th>Curso</th>
            <th>Categoría</th>
            <th>Nota</th>
        </tr>
        @foreach ($alumno->cursos as $curso)
            <tr>
                <td><a href="{{ route('cursos.show', $curso) }}">{{ $curso->titulo }}</a></td>
                <td>{{ $curso->categoria->nombre }}</td>
                <td>{{ $curso->pivot->nota !== null ? number_format($curso->pivot->nota, 2, ',', '.') : 'sin nota' }}</td>
            </tr>
        @endforeach
    </table>

    @php
        $notas = $alumno->cursos->pluck('pivot.nota')->filter(fn ($nota) => $nota !== null);
    @endphp

    @if ($notas->isNotEmpty())
        <p>Nota media: <strong>{{ number_format($notas->avg(), 2, ',', '.') }}</strong></p>
    @endif

    <p><a href="{{ route('alumnos.index') }}">← Volver a los alumnos</a></p>
@endsection
