<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre mí</title>
    <link rel="stylesheet" href="{{ asset('css/academia.css') }}">
</head>
<body>
    <main>
        <h1>🙋 Sobre mí</h1>
        <div class="tarjeta">
            <p>Me llamo <strong>{{ $nombre }}</strong> y vivo en {{ $ciudad }}.</p>
            <p>Me gusta {{ $aficiones }}.</p>
        </div>
        <p><a href="/">Volver al inicio</a></p>
    </main>
</body>
</html>
