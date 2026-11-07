@extends('layouts.app')

@section('titulo', 'Nueva categoría')

@section('contenido')
    <h1>➕ Nueva categoría</h1>

    <form action="{{ route('categorias.store') }}" method="post">
        @csrf

        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}">
            @error('nombre')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Crear la categoría</button>
        <a class="boton boton-secundario" href="{{ route('categorias.index') }}">Cancelar</a>
    </form>
@endsection
