<header>
    <a class="marca" href="{{ route('inicio') }}">🎓 {{ config('app.name') }}</a>
    <nav>
        <a href="{{ route('cursos.index') }}" @class(['activo' => request()->routeIs('cursos.*')])>Cursos</a>
        {{-- $categoriasMenu llega del view composer de AcademiaServiceProvider --}}
        @foreach ($categoriasMenu as $categoria)
            <a href="{{ route('categorias.show', $categoria) }}">{{ $categoria->nombre }}</a>
        @endforeach
        <a href="{{ route('contacto') }}" @class(['activo' => request()->routeIs('contacto')])>Contacto</a>

        @can('ver-panel')
            <a href="{{ route('admin.panel') }}" @class(['activo' => request()->routeIs('admin.*')])>Panel</a>
        @endcan

        {{-- @auth: solo si hay alguien identificado; @guest: solo si no --}}
        @auth
            <span>👤 {{ auth()->user()->name }}</span>
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
