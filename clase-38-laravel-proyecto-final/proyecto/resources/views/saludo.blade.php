<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saludo</title>
    <link rel="stylesheet" href="{{ asset('css/academia.css') }}">
</head>
<body>
    <main>
        <h1>¡Hola, {{ $nombre }}! 👋</h1>
        <p>Bienvenido al curso de <strong>{{ $curso }}</strong>.</p>
        <p><a href="/info">Ver la información de la aplicación</a></p>
    </main>
</body>
</html>
