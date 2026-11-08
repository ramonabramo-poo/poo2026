@extends('layouts.app')

@section('titulo', 'Tarjetas')

@section('contenido')
    <h1>🗂️ Componentes y parciales</h1>

    {{-- Ejercicio 05: @include con datos --}}
    @include('partials.aviso', ['texto' => 'Matrícula abierta hasta el 30 de junio', 'tipo' => 'exito', 'icono' => '📢'])
    @include('partials.aviso', ['texto' => 'Sin icono ni tipo: se usan los valores por defecto'])

    <div class="tarjetas">
        {{-- Ejercicio 04: <x-slot:titulo> rellena el hueco $titulo --}}
        <x-tarjeta>
            <x-slot:titulo>📞 Contacto</x-slot>
            <p>Teléfono: {{ config('academia.telefono') }}</p>
        </x-tarjeta>

        <x-tarjeta id="horario">
            <x-slot:titulo>🕘 Horario</x-slot>
            <p>De lunes a viernes, de 9:00 a 21:00.</p>
            {{-- Ejercicio 09 --}}
            <x-etiqueta color="verde">Abierto</x-etiqueta>
            <x-etiqueta>Novedad</x-etiqueta>
        </x-tarjeta>
    </div>
@endsection
