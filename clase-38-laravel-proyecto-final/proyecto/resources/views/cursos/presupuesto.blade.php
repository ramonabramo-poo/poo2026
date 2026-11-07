@extends('layouts.app')

@section('titulo', 'Presupuesto de ' . $curso->titulo)

@section('contenido')
    <h1>🧾 Presupuesto: {{ $curso->titulo }}</h1>

    <form action="{{ route('cursos.presupuesto', $curso) }}" method="get" class="campo">
        <label for="descuento">Descuento (%)</label>
        <input type="number" id="descuento" name="descuento" min="0" max="100" value="{{ $descuento }}">
        <button type="submit">Calcular</button>
    </form>

    <table>
        <tr><th>Precio del curso</th><td>{{ $calculadora->formatear((float) $curso->precio) }}</td></tr>
        <tr><th>Con descuento</th><td>{{ $calculadora->formatear($base) }}</td></tr>
        <tr><th>Total con IVA</th><td><strong>{{ $calculadora->formatear($total) }}</strong></td></tr>
    </table>

    <p>El descuento máximo es del {{ config('academia.descuento_maximo') }} %.</p>
    <p><a href="{{ route('cursos.show', $curso) }}">← Volver al curso</a></p>
@endsection
