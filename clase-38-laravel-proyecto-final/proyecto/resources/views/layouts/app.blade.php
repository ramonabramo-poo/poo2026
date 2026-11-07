<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Inicio') · {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/academia.css') }}">
    @stack('estilos')
</head>
<body>
    @include('partials.menu')

    <main>
        {{-- Los mensajes flash que dejan los controladores con ->with() --}}
        @session('exito')
            <x-alerta tipo="exito">{{ $value }}</x-alerta>
        @endsession

        @session('error')
            <x-alerta tipo="error">{{ $value }}</x-alerta>
        @endsession

        @yield('contenido')
    </main>

    <footer>
        © {{ date('Y') }} {{ config('app.name') }} · Santander
        · <a href="{{ route('aviso-legal') }}">Aviso legal</a>
    </footer>

    @stack('scripts')
</body>
</html>
