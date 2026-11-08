<header>
    <a class="marca" href="{{ route('inicio') }}">🎓 {{ config('app.name') }}</a>
    <nav>
        <a href="{{ route('cursos.index') }}" @class(['activo' => request()->routeIs('cursos.*')])>Cursos</a>
        {{-- Ejercicios 04 y 06 --}}
        <a href="{{ route('alumnos.index') }}" @class(['activo' => request()->routeIs('alumnos.*')])>Alumnos</a>
        <a href="{{ route('sugerencias.create') }}" @class(['activo' => request()->routeIs('sugerencias.*')])>Sugerencias</a>
        <a href="{{ route('contacto') }}" @class(['activo' => request()->routeIs('contacto')])>Contacto</a>
    </nav>
</header>
