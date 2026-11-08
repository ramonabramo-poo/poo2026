<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto · {{ $nombreApp }}</title>
    <link rel="stylesheet" href="{{ asset('css/academia.css') }}">
</head>
<body>
    <main>
        <h1>📞 {{ $nombreApp }}</h1>
        <p>Teléfono: {{ $telefono }}</p>
        <p>Correo: {{ $email }}</p>
        <p>Web: {{ $web }}</p>
    </main>
</body>
</html>
