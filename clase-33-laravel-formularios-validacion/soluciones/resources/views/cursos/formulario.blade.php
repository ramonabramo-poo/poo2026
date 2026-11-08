{{-- Campos comunes de "crear" y "editar". old() recupera lo escrito si la validación falla --}}
@if ($errors->any())
    <x-alerta tipo="error">Revisa los campos marcados en rojo.</x-alerta>
@endif

<div class="campo">
    <label for="titulo">Título</label>
    <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $curso->titulo) }}">
    @error('titulo')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="campo">
    <label for="categoria_id">Categoría</label>
    <select id="categoria_id" name="categoria_id">
        <option value="">— Elige una categoría —</option>
        @foreach ($categorias as $id => $nombre)
            <option value="{{ $id }}" @selected(old('categoria_id', $curso->categoria_id) == $id)>{{ $nombre }}</option>
        @endforeach
    </select>
    @error('categoria_id')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="campo">
    <label for="descripcion">Descripción</label>
    <textarea id="descripcion" name="descripcion" rows="4">{{ old('descripcion', $curso->descripcion) }}</textarea>
    @error('descripcion')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="campo">
    <label for="horas">Horas</label>
    <input type="number" id="horas" name="horas" value="{{ old('horas', $curso->horas) }}">
    @error('horas')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="campo">
    <label for="precio">Precio (€)</label>
    <input type="number" step="0.01" id="precio" name="precio" value="{{ old('precio', $curso->precio) }}">
    @error('precio')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="campo">
    <label for="plazas">Plazas</label>
    <input type="number" id="plazas" name="plazas" value="{{ old('plazas', $curso->plazas) }}">
    @error('plazas')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="campo">
    <label for="fecha_inicio">Fecha de inicio</label>
    <input type="date" id="fecha_inicio" name="fecha_inicio"
        value="{{ old('fecha_inicio', $curso->fecha_inicio?->format('Y-m-d')) }}">
    @error('fecha_inicio')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="campo">
    <label for="imagen">Imagen (JPG, PNG o WebP, máximo 2 MB)</label>
    @if ($curso->imagen)
        <p><img src="{{ asset('storage/' . $curso->imagen) }}" alt="" width="160"></p>
        {{-- Ejercicio 08 --}}
        <label>
            <input type="checkbox" name="quitar_imagen" value="1">
            Quitar la imagen actual
        </label>
    @endif
    <input type="file" id="imagen" name="imagen" accept="image/*">
    @error('imagen')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="campo">
    <label>
        <input type="checkbox" name="publicado" value="1" @checked(old('publicado', $curso->publicado))>
        Publicado
    </label>
</div>
