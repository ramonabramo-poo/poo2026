@extends('layouts.app')

@section('titulo', 'Catálogo con JavaScript')

@section('contenido')
    {{-- Ejercicio 10: @json pasa los datos de PHP a JavaScript de forma segura --}}
    <h1>⚡ Catálogo (pintado con JavaScript)</h1>
    <input type="search" id="filtro" placeholder="Filtra mientras escribes…">
    <ul id="lista"></ul>
@endsection

@push('scripts')
    <script>
        const cursos = @json($cursos);
        const lista = document.getElementById('lista');

        function pintar(texto) {
            lista.innerHTML = '';
            cursos
                .filter((curso) => curso.titulo.toLowerCase().includes(texto.toLowerCase()))
                .forEach((curso) => {
                    const elemento = document.createElement('li');
                    // textContent, nunca innerHTML con datos: así no hay XSS
                    elemento.textContent = `${curso.titulo} (${curso.horas} h)`;
                    lista.appendChild(elemento);
                });
        }

        document.getElementById('filtro').addEventListener('input', (evento) => pintar(evento.target.value));
        pintar('');
    </script>
@endpush
