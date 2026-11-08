@extends('layouts.app')

@section('titulo', 'Contador')

@section('contenido')
    {{-- Ejercicio 08: el JavaScript de esta página va a la pila "scripts" del layout --}}
    <h1>👆 Contador</h1>
    <p>Has pulsado <strong id="veces">0</strong> veces.</p>
    <button type="button" id="boton">¡Púlsame!</button>
@endsection

@push('scripts')
    <script>
        let veces = 0;
        document.getElementById('boton').addEventListener('click', () => {
            veces++;
            document.getElementById('veces').textContent = veces;
        });
    </script>
@endpush
