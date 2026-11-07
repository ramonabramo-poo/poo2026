@props(['tipo' => 'info'])

<div {{ $attributes->merge(['class' => "alerta alerta-$tipo"]) }}>
    {{ $slot }}
</div>
