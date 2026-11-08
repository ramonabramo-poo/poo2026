@extends('layouts.app')

@section('titulo', 'Cursos')

@section('contenido')
    <h1>📚 Cursos</h1>

    <form action="{{ route('cursos.index') }}" method="get" class="campo">
        <input type="search" name="buscar" value="{{ $buscar }}" placeholder="Buscar un curso…">
    </form>

    @if ($buscar !== '')
        <p>Resultados para «{{ $buscar }}»: {{ count($cursos) }}</p>
    @endif

    <div class="tarjetas">
        @forelse ($cursos as $curso)
            <x-tarjeta-curso :curso="$curso">
                @if ($loop->first)
                    <p>⭐ El primero de la lista</p>
                @endif
            </x-tarjeta-curso>
        @empty
            <x-alerta tipo="error">No hay ningún curso que coincida con la búsqueda.</x-alerta>
        @endforelse
    </div>
@endsection
