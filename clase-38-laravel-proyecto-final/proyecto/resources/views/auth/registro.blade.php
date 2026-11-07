@extends('layouts.app')

@section('titulo', 'Registro')

@section('contenido')
    <h1>✍️ Crear una cuenta</h1>

    <form action="{{ route('registro') }}" method="post">
        @csrf

        <div class="campo">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="campo">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="campo">
            <label for="password">Contraseña (mínimo 8 caracteres, con letras y números)</label>
            <input type="password" id="password" name="password">
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="campo">
            <label for="password_confirmation">Repite la contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>

        <button type="submit">Crear la cuenta</button>
        <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Entra</a></p>
    </form>
@endsection
