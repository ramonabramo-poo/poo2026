@extends('layouts.app')

@section('titulo', 'Cursos')

@section('contenido')
    <h1>📚 Cursos</h1>

    <p><a class="boton" href="{{ route('cursos.create') }}">➕ Nuevo curso</a></p>

    <form action="{{ route('cursos.index') }}" method="get" class="campo">
        <input type="search" name="buscar" value="{{ $buscar }}" placeholder="Buscar un curso…">
    </form>

    @if ($cursos->total() > 0)
        <p>Mostrando del {{ $cursos->firstItem() }} al {{ $cursos->lastItem() }} de {{ $cursos->total() }} cursos</p>
    @endif

    <div class="tarjetas">
        @forelse ($cursos as $curso)
            <x-tarjeta-curso :curso="$curso" />
        @empty
            <x-alerta tipo="error">No hay ningún curso que coincida con la búsqueda.</x-alerta>
        @endforelse
    </div>

    {{ $cursos->links() }}
@endsection
