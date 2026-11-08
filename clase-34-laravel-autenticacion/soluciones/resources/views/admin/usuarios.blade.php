@extends('layouts.app')

@section('titulo', 'Usuarios')

@section('contenido')
    <h1>👥 Usuarios</h1>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
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
            </tr>
        @endforeach
    </table>
@endsection
