@extends('layouts.app')

@section('titulo', 'Acceso denegado')

@section('contenido')
    <h1>⛔ No tienes permiso</h1>

    <x-alerta tipo="error">
        Tu usuario no puede hacer esto. Si crees que es un error, habla con el administrador de la academia.
    </x-alerta>

    <p><a class="boton" href="{{ route('inicio') }}">Volver al inicio</a></p>
@endsection
