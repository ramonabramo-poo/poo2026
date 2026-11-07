@extends('layouts.app')

@section('titulo', 'Sistema')

@section('contenido')
    <h1>ℹ️ {{ $nombreApp }}: el sistema</h1>
    <table>
        <tr><th>Entorno</th><td>{{ $entorno }}</td></tr>
        <tr><th>Depuración</th><td>{{ $depuracion ? 'activada' : 'desactivada' }}</td></tr>
        <tr><th>Idioma</th><td>{{ $idioma }}</td></tr>
        <tr><th>Zona horaria</th><td>{{ $zonaHoraria }}</td></tr>
        <tr><th>Laravel</th><td>{{ $versionLaravel }}</td></tr>
        <tr><th>PHP</th><td>{{ $versionPhp }}</td></tr>
        <tr><th>Fecha y hora</th><td>{{ $ahora }}</td></tr>
    </table>
@endsection
