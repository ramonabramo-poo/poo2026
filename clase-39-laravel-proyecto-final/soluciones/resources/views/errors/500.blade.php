{{-- Ejercicio 07: el 500 NO usa el layout. Si algo ha fallado (la base de datos, una vista...),
     el layout podría volver a fallar al pintar el menú. Así que: HTML sencillo y sin consultas --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Algo ha ido mal</title>
    <style>
        body {
            font-family: system-ui, sans-serif;
            max-width: 600px;
            margin: 80px auto;
            padding: 0 20px;
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <h1>😵 Algo ha ido mal</h1>
    <p>Ha ocurrido un error inesperado. Ya nos hemos enterado y lo estamos mirando.</p>
    <p>Si necesitas algo urgente, llámanos al {{ config('academia.telefono') }}.</p>
    <p><a href="/">Volver a la portada</a></p>
</body>
</html>
