@extends('layouts.app')

@section('titulo', 'Ranking')

@section('contenido')
    {{-- Ejercicio 06: $loop para las medallas y para saber cuántos quedan --}}
    <h1>🏆 Los cursos más largos</h1>

    <ol>
        @forelse ($cursos as $curso)
            <li>
                @if ($loop->iteration <= 3)
                    {{ ['🥇', '🥈', '🥉'][$loop->index] }}
                @endif
                {{ $curso['titulo'] }} ({{ $curso['horas'] }} horas)
                @if ($loop->last)
                    <small>— el más corto</small>
                @endif
            </li>
        @empty
            <li>Todavía no hay cursos.</li>
        @endforelse
    </ol>
@endsection
