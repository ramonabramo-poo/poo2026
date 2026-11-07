@extends('layouts.app')

@section('titulo', $curso['titulo'])

@section('contenido')
    <h1>{{ $curso['titulo'] }}</h1>

    <p><span class="etiqueta">{{ config("academia.categorias.{$curso['categoria']}") }}</span></p>
    <p>Duración: {{ $curso['horas'] }} horas</p>
    <p>Precio: {{ number_format($curso['precio'], 2, ',', '.') }} €</p>

    @if ($curso['horas'] >= 60)
        <x-alerta>Es un curso largo: os recomendamos dedicarle al menos una hora al día.</x-alerta>
    @elseif ($curso['horas'] >= 30)
        <x-alerta>Un curso de duración media, ideal para compaginar con el trabajo.</x-alerta>
    @else
        <x-alerta>Un curso corto: en pocas semanas lo tendréis terminado.</x-alerta>
    @endif

    <p><a href="{{ route('cursos.index') }}">← Volver a los cursos</a></p>
@endsection
