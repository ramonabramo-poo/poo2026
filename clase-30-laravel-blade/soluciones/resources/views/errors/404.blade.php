@extends('layouts.app')

@section('titulo', 'Página no encontrada')

@section('contenido')
    <h1>🤷 Esta página no existe</h1>

    <x-alerta tipo="error">
        No hemos encontrado lo que buscabas. Puede que el enlace esté mal escrito o que el curso ya no exista.
    </x-alerta>

    <p><a class="boton" href="{{ route('inicio') }}">Volver al inicio</a></p>
@endsection
