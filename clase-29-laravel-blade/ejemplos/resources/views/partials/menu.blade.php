<header>
    <a class="marca" href="{{ route('inicio') }}">🎓 {{ config('app.name') }}</a>
    <nav>
        <a href="{{ route('cursos.index') }}" @class(['activo' => request()->routeIs('cursos.*')])>Cursos</a>
        <a href="{{ route('contacto') }}" @class(['activo' => request()->routeIs('contacto')])>Contacto</a>
    </nav>
</header>
