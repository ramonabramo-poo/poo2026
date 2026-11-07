@extends('layouts.app')

@section('titulo', 'Precios')

@push('estilos')
    <style>
        .par { background: #fff4e6; }
        .total { font-weight: bold; }
    </style>
@endpush

@section('contenido')
    <h1>💶 Precios</h1>

    @php
        $totalHoras = 0;
        $totalPrecio = 0;
    @endphp

    <table>
        <tr>
            <th>#</th>
            <th>Curso</th>
            <th>Horas</th>
            <th>Precio</th>
            <th>Precio con IVA</th>
        </tr>
        @forelse ($cursos as $curso)
            @php
                $totalHoras += $curso['horas'];
                $totalPrecio += $curso['precio'];
            @endphp
            <tr @class(['par' => $loop->even])>
                <td>{{ $loop->iteration }}</td>
                <td><a href="{{ route('cursos.show', $curso['id']) }}">{{ $curso['titulo'] }}</a></td>
                <td>{{ $curso['horas'] }}</td>
                <td>{{ number_format($curso['precio'], 2, ',', '.') }} €</td>
                <td>{{ number_format($curso['precio'] * 1.21, 2, ',', '.') }} €</td>
            </tr>
        @empty
            <tr><td colspan="5">Todavía no hay cursos.</td></tr>
        @endforelse
        <tr class="total">
            <td colspan="2">Total ({{ count($cursos) }} cursos)</td>
            <td>{{ $totalHoras }}</td>
            <td>{{ number_format($totalPrecio, 2, ',', '.') }} €</td>
            <td>{{ number_format($totalPrecio * 1.21, 2, ',', '.') }} €</td>
        </tr>
    </table>
@endsection
