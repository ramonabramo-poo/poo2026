@extends('layouts.app')

@section('titulo', $curso->titulo)

@section('contenido')
    <h1>{{ $curso->titulo }}</h1>

    @if ($curso->imagen)
        <p><img src="{{ asset('storage/' . $curso->imagen) }}" alt="{{ $curso->titulo }}" width="400"></p>
    @endif

    <p><a class="etiqueta" href="{{ route('categorias.show', $curso->categoria) }}">{{ $curso->categoria->nombre }}</a></p>
    <p>{{ $curso->descripcion }}</p>
    <p>Duración: {{ $curso->horas }} horas</p>
    {{-- fecha_inicio es un objeto Carbon gracias al cast 'date' --}}
    <p>Empieza el {{ $curso->fecha_inicio?->format('d/m/Y') ?? 'fecha por determinar' }}</p>
    <p>
        Precio: {{ number_format($curso->precio, 2, ',', '.') }} €
        ({{ number_format($curso->precio_con_iva, 2, ',', '.') }} € con IVA)
    </p>

    @if ($curso->horas >= 60)
        <x-alerta>Es un curso largo: os recomendamos dedicarle al menos una hora al día.</x-alerta>
    @elseif ($curso->horas >= 30)
        <x-alerta>Un curso de duración media, ideal para compaginar con el trabajo.</x-alerta>
    @else
        <x-alerta>Un curso corto: en pocas semanas lo tendréis terminado.</x-alerta>
    @endif

    <h2>👥 Alumnos ({{ $curso->alumnos->count() }} de {{ $curso->plazas }})</h2>
    <table>
        <tr>
            <th>Alumno</th>
            <th>Matriculado el</th>
            <th>Nota</th>
        </tr>
        @forelse ($curso->alumnos as $alumno)
            <tr>
                <td>{{ $alumno->nombre_completo }}</td>
                <td>{{ $alumno->pivot->created_at->format('d/m/Y') }}</td>
                <td>{{ $alumno->pivot->nota !== null ? number_format($alumno->pivot->nota, 2, ',', '.') : '—' }}</td>
            </tr>
        @empty
            <tr><td colspan="3">Todavía no hay nadie matriculado.</td></tr>
        @endforelse
    </table>

    {{-- Ejercicio 02 --}}
    <h2>Matricular a un alumno</h2>
    <form action="{{ route('matriculas.store', $curso) }}" method="post">
        @csrf
        <div class="campo">
            <select name="alumno_id">
                <option value="">— Elige un alumno —</option>
                @foreach ($alumnosLibres as $id => $nombre)
                    <option value="{{ $id }}" @selected(old('alumno_id') == $id)>{{ $nombre }}</option>
                @endforeach
            </select>
            @error('alumno_id')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit">Matricular</button>
    </form>

    {{-- Ejercicio 09 --}}
    @if ($alumnosLibres->isNotEmpty())
        <h2>Matricular a varios alumnos</h2>
        <form action="{{ route('matriculas.varios', $curso) }}" method="post">
            @csrf
            @foreach ($alumnosLibres as $id => $nombre)
                <label>
                    {{-- name="alumnos[]": PHP recibe un array con los valores marcados --}}
                    <input type="checkbox" name="alumnos[]" value="{{ $id }}"
                        @checked(in_array($id, old('alumnos', [])))>
                    {{ $nombre }}
                </label><br>
            @endforeach
            @error('alumnos')
                <p class="error">{{ $message }}</p>
            @enderror
            @error('alumnos.*')
                <p class="error">{{ $message }}</p>
            @enderror
            <button type="submit">Matricular a los marcados</button>
        </form>
    @endif

    {{-- Ejercicio 07 --}}
    <h2>📄 Temario</h2>
    @if ($hayTemario)
        <p><a href="{{ route('temario.show', $curso) }}">Descargar el temario en PDF</a></p>
    @else
        <p>Este curso todavía no tiene temario.</p>
    @endif
    {{-- Sin enctype="multipart/form-data" el fichero no llega al servidor --}}
    <form action="{{ route('temario.store', $curso) }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="temario" accept="application/pdf">
        @error('temario')
            <p class="error">{{ $message }}</p>
        @enderror
        <button type="submit">Subir el temario</button>
    </form>

    <p>
        <a class="boton boton-secundario" href="{{ route('cursos.index') }}">← Volver a los cursos</a>
        <a class="boton" href="{{ route('cursos.edit', $curso) }}">✏️ Editar</a>
    </p>

    {{-- Ejercicio 10 --}}
    <form action="{{ route('cursos.destroy', $curso) }}" method="post">
        @csrf
        @method('DELETE')
        <div class="campo">
            <label for="confirmacion">Para borrar el curso, escribe BORRAR</label>
            <input type="text" id="confirmacion" name="confirmacion" autocomplete="off">
            @error('confirmacion')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="boton-peligro">🗑️ Borrar el curso</button>
    </form>
@endsection
