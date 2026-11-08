<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $curso['titulo'] }} · {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/academia.css') }}">
</head>
<body>
    <header>
        <a class="marca" href="{{ route('inicio') }}">🎓 {{ config('app.name') }}</a>
        <nav>
            <a href="{{ route('cursos.index') }}">Cursos</a>
            <a href="{{ route('contacto') }}">Contacto</a>
        </nav>
    </header>
    <main>
        <h1>{{ $curso['titulo'] }}</h1>
        <p><span class="etiqueta">{{ $curso['categoria'] }}</span></p>
        <p>Duración: {{ $curso['horas'] }} horas</p>
        <p>Precio: {{ number_format($curso['precio'], 2, ',', '.') }} €</p>
        <p><a href="{{ route('cursos.index') }}">← Volver a los cursos</a></p>
    </main>
</body>
</html>
