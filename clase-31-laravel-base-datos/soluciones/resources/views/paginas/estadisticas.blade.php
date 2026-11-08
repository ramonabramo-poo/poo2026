@extends('layouts.app')

@section('titulo', 'Estadísticas')

@section('contenido')
    <h1>📊 Estadísticas</h1>

    <h2>Por categoría</h2>
    <table>
        <tr>
            <th>Categoría</th>
            <th>Cursos</th>
            <th>Horas</th>
            <th>Precio medio</th>
        </tr>
        @foreach ($porCategoria as $fila)
            <tr>
                <td>{{ $fila->nombre }}</td>
                <td>{{ $fila->total_cursos }}</td>
                <td>{{ $fila->total_horas }}</td>
                <td>{{ number_format($fila->precio_medio, 2, ',', '.') }} €</td>
            </tr>
        @endforeach
    </table>

    <h2>Los cursos con más alumnos</h2>
    <ol>
        @foreach ($masAlumnos as $curso)
            <li>{{ $curso->titulo }}: {{ $curso->total_alumnos }} alumnos</li>
        @endforeach
    </ol>
@endsection
