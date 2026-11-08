@extends('layouts.app')

@section('titulo', 'Contacto')

@section('contenido')
    <h1>📞 Contacto</h1>
    <p>Teléfono: {{ $telefono }}</p>
    <p>Correo: <a href="mailto:{{ $email }}">{{ $email }}</a></p>
@endsection
