{{-- Ejercicio 05: una vista parcial que recibe datos desde @include --}}
<div class="alerta alerta-{{ $tipo ?? 'info' }}">
    {{ $icono ?? 'ℹ️' }} {{ $texto }}
</div>
