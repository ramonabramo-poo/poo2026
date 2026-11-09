@extends('layouts.app')

@section('titulo', 'Panel')

@section('contenido')
    <h1>🛠️ Panel de gestión</h1>

    <p>Hola, {{ auth()->user()->name }}. Tu rol es <strong>{{ auth()->user()->rol->etiqueta() }}</strong>.</p>

    {{-- Ejercicio 04: $estadisticas es el servicio, inyectado con @inject --}}
    @inject('estadisticas', 'App\Servicios\EstadisticasAcademia')
    <table>
        <tr><th>Cursos</th><td>{{ $estadisticas->totalCursos() }}</td></tr>
        <tr><th>Alumnos</th><td>{{ $estadisticas->totalAlumnos() }}</td></tr>
        <tr><th>Matrículas</th><td>{{ $estadisticas->totalMatriculas() }}</td></tr>
        <tr><th>Precio medio</th><td>{{ number_format($estadisticas->precioMedio(), 2, ',', '.') }} €</td></tr>
        <tr><th>Curso más popular</th><td>{{ $estadisticas->cursoMasPopular()?->titulo ?? '—' }}</td></tr>
    </table>

    <ul>
        @can('create', App\Models\Curso::class)
            <li><a href="{{ route('cursos.create') }}">Crear un curso</a></li>
        @endcan
        <li><a href="{{ route('cursos.index') }}">Ver los cursos</a></li>
        @if (auth()->user()->esAdmin())
            <li><a href="{{ route('admin.sistema') }}">Información del sistema</a></li>
        @endif
    </ul>
@endsection
