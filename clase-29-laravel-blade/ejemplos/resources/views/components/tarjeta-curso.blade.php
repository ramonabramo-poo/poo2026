@props(['curso'])

<article class="tarjeta">
    <h3>{{ $curso['titulo'] }}</h3>
    <p>
        <span class="etiqueta">{{ config("academia.categorias.{$curso['categoria']}") }}</span>
        {{ $curso['horas'] }} horas
    </p>
    <p><strong>{{ number_format($curso['precio'], 2, ',', '.') }} €</strong></p>

    {{-- Si quien usa el componente le pasa contenido, se pinta aquí --}}
    {{ $slot }}

    <a class="boton" href="{{ route('cursos.show', $curso['id']) }}">Ver curso</a>
</article>
