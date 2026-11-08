<header>
    <a class="marca" href="{{ route('inicio') }}">🎓 {{ config('app.name') }}</a>
    <nav>
        <a href="{{ route('cursos.index') }}" @class(['activo' => request()->routeIs('cursos.*')])>Cursos</a>
        <a href="{{ route('contacto') }}" @class(['activo' => request()->routeIs('contacto')])>Contacto</a>

        @can('ver-panel')
            <a href="{{ route('admin.panel') }}" @class(['activo' => request()->routeIs('admin.*')])>Panel</a>
        @endcan

        @can('administrar-usuarios')
            <a href="{{ route('admin.usuarios.index') }}">Usuarios</a>
        @endcan

        {{-- @auth: solo si hay alguien identificado; @guest: solo si no --}}
        @auth
            <a href="{{ route('perfil.edit') }}">👤 {{ auth()->user()->name }}</a>
            <form action="{{ route('logout') }}" method="post" style="display: inline">
                @csrf
                <button type="submit" class="boton-secundario">Salir</button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}">Entrar</a>
            <a href="{{ route('registro') }}">Registro</a>
        @endguest
    </nav>
</header>
