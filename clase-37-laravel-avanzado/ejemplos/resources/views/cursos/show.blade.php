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
        · <a href="{{ route('cursos.presupuesto', $curso) }}">Calcular un presupuesto</a>
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

    @can('update', $curso)
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
    @endcan

    <p>
        <a class="boton boton-secundario" href="{{ route('cursos.index') }}">← Volver a los cursos</a>
        {{-- Los botones solo aparecen si la policy lo permite --}}
        @can('update', $curso)
            <a class="boton" href="{{ route('cursos.edit', $curso) }}">✏️ Editar</a>
        @endcan
    </p>

    @can('delete', $curso)
        <form action="{{ route('cursos.destroy', $curso) }}" method="post"
            onsubmit="return confirm('¿Seguro que quieres borrar este curso?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="boton-peligro">🗑️ Borrar el curso</button>
        </form>
    @endcan
@endsection
