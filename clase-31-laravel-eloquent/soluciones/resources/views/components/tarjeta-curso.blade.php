@props(['curso'])

<article class="tarjeta">
    <h3>{{ $curso->titulo }}</h3>
    <p>
        <a class="etiqueta" href="{{ route('categorias.show', $curso->categoria) }}">{{ $curso->categoria->nombre }}</a>
        {{ $curso->horas }} horas
    </p>
    <p><strong>{{ number_format($curso->precio, 2, ',', '.') }} €</strong></p>

    @isset($curso->alumnos_count)
        <p>👥 {{ $curso->alumnos_count }} alumnos</p>

        {{-- Ejercicio 03 --}}
        @if ($curso->plazas_libres === 0)
            <p class="error">Completo</p>
        @elseif ($curso->plazas_libres <= 3)
            <p class="error">¡Últimas {{ $curso->plazas_libres }} plazas!</p>
        @endif
    @endisset

    {{-- Si quien usa el componente le pasa contenido, se pinta aquí --}}
    {{ $slot }}

    <a class="boton" href="{{ route('cursos.show', $curso) }}">Ver curso</a>
</article>
