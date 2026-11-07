<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesores · {{ config('app.name') }}</title>
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
        <h1>👩‍🏫 Profesores</h1>

        <ul>
            @foreach ($profesores as $profesor)
                <li>
                    <a href="{{ route('profesores.show', $profesor['id']) }}">{{ $profesor['nombre'] }}</a>
                </li>
            @endforeach
        </ul>
    </main>
</body>
</html>
