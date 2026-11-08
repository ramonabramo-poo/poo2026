{{-- Ejercicio 09: un componente con un valor por defecto y atributos extra --}}
@props(['color' => 'naranja'])

@php
    $colores = [
        'naranja' => 'background: #fff4e6; color: #e8590c;',
        'verde' => 'background: #ebfbee; color: #2b8a3e;',
        'gris' => 'background: #f1f3f5; color: #495057;',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'etiqueta', 'style' => $colores[$color] ?? $colores['naranja']]) }}>
    {{ $slot }}
</span>
