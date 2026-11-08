@extends('layouts.app')

@section('titulo', 'Horario')

@section('contenido')
    {{-- Ejercicio 07: @switch para un texto distinto según el día --}}
    <h1>🗓️ Horario de la semana</h1>

    <table>
        @foreach ($dias as $dia)
            <tr @class(['par' => $loop->even])>
                <th>{{ ucfirst($dia) }}</th>
                <td>
                    @switch($dia)
                        @case('viernes')
                            9:00 - 14:00
                            @break
                        @case('sábado')
                        @case('domingo')
                            Cerrado
                            @break
                        @default
                            9:00 - 21:00
                    @endswitch
                </td>
            </tr>
        @endforeach
    </table>
@endsection
