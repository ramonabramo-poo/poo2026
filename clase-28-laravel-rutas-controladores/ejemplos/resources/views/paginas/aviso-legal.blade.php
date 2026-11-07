<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aviso legal · {{ config('app.name') }}</title>
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
        <h1>Aviso legal</h1>
        <p>Esta página la sirve Route::view(): no necesita controlador.</p>
    </main>
</body>
</html>
