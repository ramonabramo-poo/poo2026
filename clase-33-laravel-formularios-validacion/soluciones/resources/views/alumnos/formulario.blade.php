{{-- Campos comunes de "crear" y "editar" --}}
@if ($errors->any())
    <x-alerta tipo="error">Revisa los campos marcados en rojo.</x-alerta>
@endif

<div class="campo">
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $alumno->nombre) }}">
    @error('nombre')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="campo">
    <label for="apellidos">Apellidos</label>
    <input type="text" id="apellidos" name="apellidos" value="{{ old('apellidos', $alumno->apellidos) }}">
    @error('apellidos')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="campo">
    <label for="email">Correo</label>
    <input type="email" id="email" name="email" value="{{ old('email', $alumno->email) }}">
    @error('email')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="campo">
    <label for="telefono">Teléfono (opcional)</label>
    <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $alumno->telefono) }}">
    @error('telefono')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="campo">
    <label for="fecha_nacimiento">Fecha de nacimiento (opcional)</label>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
        value="{{ old('fecha_nacimiento', $alumno->fecha_nacimiento?->format('Y-m-d')) }}">
    @error('fecha_nacimiento')
        <p class="error">{{ $message }}</p>
    @enderror
</div>
