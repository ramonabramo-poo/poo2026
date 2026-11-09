@extends('layouts.app')

@section('titulo', 'Usuarios')

@section('contenido')
    <h1>👥 Usuarios</h1>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Último acceso</th>
            <th>Cuenta</th>
        </tr>
        @foreach ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->email }}</td>
                <td>
                    <form action="{{ route('admin.usuarios.update', $usuario) }}" method="post">
                        @csrf
                        @method('PUT')
                        <select name="rol" onchange="this.form.submit()">
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->value }}" @selected($usuario->rol === $rol)>{{ $rol->etiqueta() }}</option>
                            @endforeach
                        </select>
                    </form>
                </td>
                {{-- Ejercicio 07: diffForHumans() → «hace 3 días» --}}
                <td>{{ $usuario->ultimo_acceso?->locale('es')->diffForHumans() ?? 'Nunca' }}</td>
                {{-- Ejercicio 06 --}}
                <td>
                    <form action="{{ route('admin.usuarios.activo', $usuario) }}" method="post">
                        @csrf
                        @method('PATCH')
                        {{ $usuario->activo ? '✅ Activa' : '⛔ Desactivada' }}
                        <button type="submit" class="boton-secundario">{{ $usuario->activo ? 'Desactivar' : 'Activar' }}</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
