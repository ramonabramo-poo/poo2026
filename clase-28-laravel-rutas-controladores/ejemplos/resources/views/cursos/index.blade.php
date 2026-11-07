<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos · {{ config('app.name') }}</title>
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
        <h1>📚 Cursos</h1>

        <form action="{{ route('cursos.index') }}" method="get">
            <input type="search" name="buscar" value="{{ $buscar }}" placeholder="Buscar un curso…">
        </form>

        <ul>
            @foreach ($cursos as $curso)
                <li>
                    <a href="{{ route('cursos.show', $curso['id']) }}">{{ $curso['titulo'] }}</a>
                    ({{ $curso['horas'] }} horas)
                </li>
            @endforeach
        </ul>
    </main>
</body>
</html>
