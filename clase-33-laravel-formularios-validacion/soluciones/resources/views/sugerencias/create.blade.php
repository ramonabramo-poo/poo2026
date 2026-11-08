@extends('layouts.app')

@section('titulo', 'Buzón de sugerencias')

@section('contenido')
    <h1>💡 Buzón de sugerencias</h1>

    @if ($errors->any())
        <x-alerta tipo="error">Revisa los campos marcados en rojo.</x-alerta>
    @endif

    <form action="{{ route('sugerencias.store') }}" method="post">
        @csrf

        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}">
            @error('nombre')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="campo">
            <label for="email">Correo</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="campo">
            <label for="telefono">Teléfono (opcional)</label>
            <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}">
            @error('telefono')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="campo">
            <label for="asunto">Asunto</label>
            <select id="asunto" name="asunto">
                <option value="">— Elige un asunto —</option>
                @foreach ($asuntos as $clave => $texto)
                    <option value="{{ $clave }}" @selected(old('asunto') === $clave)>{{ $texto }}</option>
                @endforeach
            </select>
            @error('asunto')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="campo">
            <label for="texto">Tu sugerencia</label>
            <textarea id="texto" name="texto" rows="5">{{ old('texto') }}</textarea>
            @error('texto')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="campo">
            <label>
                <input type="checkbox" name="privacidad" value="1" @checked(old('privacidad'))>
                Acepto la política de privacidad
            </label>
            @error('privacidad')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Enviar</button>
    </form>

    <h2>Últimas sugerencias</h2>
    @forelse ($sugerencias as $sugerencia)
        <p>
            <strong>{{ $asuntos[$sugerencia['asunto']] }}</strong>
            — {{ $sugerencia['nombre'] }}, {{ $sugerencia['fecha'] }}<br>
            {{ $sugerencia['texto'] }}
        </p>
    @empty
        <p>Todavía no hay sugerencias.</p>
    @endforelse
@endsection
