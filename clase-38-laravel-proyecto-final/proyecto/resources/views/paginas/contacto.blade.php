@extends('layouts.app')

@section('titulo', 'Contacto')

@section('contenido')
    <h1>📞 Contacto</h1>
    <p>Teléfono: {{ $telefono }} · Correo: <a href="mailto:{{ $email }}">{{ $email }}</a></p>

    <h2>Escríbenos</h2>
    <form action="{{ route('contacto.enviar') }}" method="post">
        {{-- Sin este campo oculto, Laravel rechaza el formulario con un error 419 --}}
        @csrf

        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}">
            @error('nombre')
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
            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" name="mensaje" rows="5">{{ old('mensaje') }}</textarea>
            @error('mensaje')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="campo">
            <label>
                <input type="checkbox" name="acepto" value="1" @checked(old('acepto'))>
                Acepto la política de privacidad
            </label>
            @error('acepto')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Enviar</button>
    </form>
@endsection
