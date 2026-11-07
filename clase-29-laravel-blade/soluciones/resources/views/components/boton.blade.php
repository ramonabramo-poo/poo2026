@props(['href', 'tipo' => 'principal'])

@php
    $clases = match ($tipo) {
        'secundario' => 'boton boton-secundario',
        'peligro' => 'boton boton-peligro',
        default => 'boton',
    };
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $clases]) }}>
    {{ $slot }}
</a>
