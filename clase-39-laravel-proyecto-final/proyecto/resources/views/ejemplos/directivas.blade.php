@extends('layouts.app')

@section('titulo', 'Directivas de Blade')

@push('estilos')
    <style>
        .par { background: #fff4e6; }
    </style>
@endpush

@section('contenido')
    <h1>🧪 Directivas de Blade</h1>

    {{-- Esto es un comentario de Blade: no llega al HTML --}}

    <h2>Imprimir</h2>
    <p>Escapado: {{ $html }}</p>
    <p>Sin escapar: {!! $html !!}</p>
    <p>Con valor por defecto: {{ $apodo ?? 'sin apodo' }}</p>

    <h2>Condiciones</h2>
    @if ($nota >= 9)
        <p>Sobresaliente</p>
    @elseif ($nota >= 5)
        <p>Aprobado</p>
    @else
        <p>Suspenso</p>
    @endif

    @unless ($esAdmin)
        <p>No eres administrador.</p>
    @endunless

    @isset($apodo)
        <p>Tienes apodo.</p>
    @endisset

    @empty($alumnos)
        <p>No hay alumnos.</p>
    @endempty

    @switch($dia)
        @case('sábado')
        @case('domingo')
            <p>¡Fin de semana!</p>
            @break
        @default
            <p>Día de clase.</p>
    @endswitch

    <h2>Bucles y la variable $loop</h2>
    <table>
        <tr><th>#</th><th>Alumno</th><th>Posición</th></tr>
        @foreach ($alumnos as $alumno)
            <tr @class(['par' => $loop->even])>
                <td>{{ $loop->iteration }} de {{ $loop->count }}</td>
                <td>{{ $alumno }}</td>
                <td>{{ $loop->first ? 'Primero' : '' }} {{ $loop->last ? 'Último' : '' }}</td>
            </tr>
        @endforeach
    </table>

    <p>
        @for ($i = 1; $i <= 5; $i++)
            {{ $i }}
        @endfor
    </p>

    <h2>PHP y JSON</h2>
    @php
        $media = array_sum($notas) / count($notas);
    @endphp
    <p>Nota media: {{ number_format($media, 2, ',', '.') }}</p>

    <script>
        const alumnos = @json($alumnos);
        console.log(alumnos);
    </script>
@endsection
