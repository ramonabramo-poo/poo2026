@extends('layouts.app')

@section('titulo', 'Inicio')

@section('contenido')
    <h1>Bienvenidos a la academia</h1>

    <x-alerta tipo="exito">
        ¡Matrícula abierta! Tenemos <strong>{{ $totalCursos }}</strong> cursos esperándoos.
    </x-alerta>

    <h2>Cursos destacados</h2>
    <div class="tarjetas">
        @foreach ($destacados as $curso)
            <x-tarjeta-curso :curso="$curso" />
        @endforeach
    </div>
@endsection
