@extends('layouts.app')

@section('titulo', 'Entrar')

@section('contenido')
    <h1>🔐 Entrar</h1>

    <form action="{{ route('login') }}" method="post">
        @csrf

        <div class="campo">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" autofocus>
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="campo">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password">
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="campo">
            <label>
                <input type="checkbox" name="recordarme" value="1">
                Recordarme en este ordenador
            </label>
        </div>

        <button type="submit">Entrar</button>
        <p>¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate</a></p>
    </form>
@endsection
