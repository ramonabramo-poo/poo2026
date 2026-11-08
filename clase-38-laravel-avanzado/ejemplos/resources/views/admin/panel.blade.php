@extends('layouts.app')

@section('titulo', 'Panel')

@section('contenido')
    <h1>🛠️ Panel de gestión</h1>

    <p>Hola, {{ auth()->user()->name }}. Tu rol es <strong>{{ auth()->user()->rol->etiqueta() }}</strong>.</p>

    @php
        $notificaciones = auth()->user()->unreadNotifications;
    @endphp

    <h2>🔔 Notificaciones ({{ $notificaciones->count() }})</h2>
    @forelse ($notificaciones as $notificacion)
        <x-alerta>
            {{ $notificacion->data['mensaje'] }}
            <small>({{ $notificacion->created_at->diffForHumans() }})</small>
        </x-alerta>
    @empty
        <p>No tienes notificaciones pendientes.</p>
    @endforelse

    @if ($notificaciones->isNotEmpty())
        <form action="{{ route('notificaciones.leidas') }}" method="post">
            @csrf
            <button type="submit" class="boton-secundario">Marcar todas como leídas</button>
        </form>
    @endif

    <h2>Acciones</h2>
    <ul>
        @can('create', App\Models\Curso::class)
            <li><a href="{{ route('cursos.create') }}">Crear un curso</a></li>
        @endcan
        <li><a href="{{ route('cursos.index') }}">Ver los cursos</a></li>
        @if (auth()->user()->esAdmin())
            <li><a href="{{ route('admin.sistema') }}">Información del sistema</a></li>
        @endif
    </ul>
@endsection
