@extends('layouts.app')

@section('titulo', $categoria->nombre)

@section('contenido')
    <h1>🏷️ {{ $categoria->nombre }}</h1>

    <div class="tarjetas">
        @forelse ($cursos as $curso)
            <x-tarjeta-curso :curso="$curso" />
        @empty
            <x-alerta>Esta categoría todavía no tiene cursos publicados.</x-alerta>
        @endforelse
    </div>

    {{ $cursos->links() }}
@endsection
