{{-- Ejercicio 01. Sin @extends a propósito: durante el mantenimiento puede que la base de
     datos no esté disponible, y el layout consulta las categorías del menú --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volvemos enseguida · {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/academia.css') }}">
</head>
<body>
    <main style="text-align: center; padding-top: 4rem">
        <h1>🛠️ Estamos mejorando la academia</h1>
        <p>Volvemos en unos minutos. ¡Gracias por la paciencia!</p>
        <p>Si es urgente, llamadnos al {{ config('academia.telefono') }}.</p>
    </main>
</body>
</html>
