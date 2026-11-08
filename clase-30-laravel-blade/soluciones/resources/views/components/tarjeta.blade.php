{{-- Ejercicio 04: un componente con un slot CON NOMBRE (titulo) y el slot normal --}}
<article {{ $attributes->merge(['class' => 'tarjeta']) }}>
    <h3>{{ $titulo }}</h3>
    {{ $slot }}
</article>
