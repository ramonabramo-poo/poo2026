@extends('layouts.app')

@section('titulo', 'Mi perfil')

@section('contenido')
    <h1>👤 Mi perfil</h1>

    <form action="{{ route('perfil.update') }}" method="post">
        @csrf
        @method('PUT')

        <div class="campo">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" value="{{ old('name', $usuario->name) }}">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="campo">
            <label for="ciudad">Ciudad</label>
            <input type="text" id="ciudad" name="ciudad" value="{{ old('ciudad', $perfil?->ciudad) }}">
            @error('ciudad')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="campo">
            <label for="biografia">Sobre mí</label>
            <textarea id="biografia" name="biografia" rows="4">{{ old('biografia', $perfil?->biografia) }}</textarea>
            @error('biografia')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Guardar el perfil</button>
    </form>

    <h2>🔑 Cambiar la contraseña</h2>

    <form action="{{ route('perfil.password') }}" method="post">
        @csrf
        @method('PUT')

        <div class="campo">
            <label for="password_actual">Contraseña actual</label>
            <input type="password" id="password_actual" name="password_actual">
            @error('password_actual')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="campo">
            <label for="password">Contraseña nueva</label>
            <input type="password" id="password" name="password">
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="campo">
            <label for="password_confirmation">Repite la contraseña nueva</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>

        <button type="submit">Cambiar la contraseña</button>
    </form>
@endsection
