<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SoundWave - Artistas y generos</title>
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    </head>
    <body class="admin-body">
        <header class="admin-header">
            <div class="admin-header-izquierda">
                <div class="admin-logo">SoundWave</div>
                <nav class="admin-nav">
                    <a class="admin-nav-link" href="{{ route('admin.catalogo') }}">Catalogo</a>
                    <a class="admin-nav-link activo" href="{{ route('admin.artistas-generos') }}">Artistas y generos</a>
                    <a class="admin-nav-link" href="{{ route('admin.usuarios') }}">Usuarios</a>
                </nav>
            </div>
            <div class="admin-usuario">
                Admin: {{ $usuario->nombre_usuario }}
                <a class="admin-cerrar" href="{{ route('logout') }}">Cerrar sesion</a>
            </div>
        </header>

        <main class="admin-contenedor">
            <section class="admin-panel">
                <h1 class="admin-titulo">Artistas y generos</h1>
                <p class="admin-texto">Agrega o elimina artistas y generos musicales.</p>

                @if (session('mensaje_artista'))
                    <div class="admin-alerta">{{ session('mensaje_artista') }}</div>
                @endif

                @if (session('mensaje_genero'))
                    <div class="admin-alerta">{{ session('mensaje_genero') }}</div>
                @endif

                @if (session('error'))
                    <div class="admin-alerta admin-alerta-error">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="admin-alerta admin-alerta-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="admin-grid">
                    <div>
                        <h2 class="admin-subtitulo">Nuevo artista</h2>
                        <form class="admin-form" method="POST" action="{{ route('admin.artistas.guardar') }}">
                            @csrf
                            <div class="admin-form-grupo">
                                <label class="admin-label" for="nombre_artista">Nombre</label>
                                <input class="admin-input" type="text" id="nombre_artista" name="nombre_artista" value="{{ old('nombre_artista') }}" >
                            </div>
                            <button class="admin-boton" type="submit">Guardar artista</button>
                        </form>

                        <h2 class="admin-subtitulo">Artistas</h2>
                        @if ($artistas->isNotEmpty())
                            <div class="admin-lista">
                                @foreach ($artistas as $artista)
                                    <div class="admin-lista-item">
                                        <span class="admin-lista-texto">{{ $artista->nombre_artista }}</span>
                                        <form class="admin-form-inline" method="POST" action="{{ route('admin.artistas.eliminar', ['id' => $artista->id_artista]) }}">
                                            @csrf
                                            <button class="admin-link admin-link-rojo" type="submit">Eliminar</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="admin-texto">No hay artistas registrados.</p>
                        @endif
                    </div>

                    <div>
                        <h2 class="admin-subtitulo">Nuevo genero</h2>
                        <form class="admin-form" method="POST" action="{{ route('admin.generos.guardar') }}">
                            @csrf
                            <div class="admin-form-grupo">
                                <label class="admin-label" for="nombre_genero">Nombre</label>
                                <input class="admin-input" type="text" id="nombre_genero" name="nombre_genero" value="{{ old('nombre_genero') }}">
                            </div>
                            <button class="admin-boton" type="submit">Guardar genero</button>
                        </form>

                        <h2 class="admin-subtitulo">Generos</h2>
                        @if ($generos->isNotEmpty())
                            <div class="admin-lista">
                                @foreach ($generos as $genero)
                                    <div class="admin-lista-item">
                                        <span class="admin-lista-texto">{{ $genero->nombre_genero }}</span>
                                        <form class="admin-form-inline" method="POST" action="{{ route('admin.generos.eliminar', ['id' => $genero->id_genero]) }}">
                                            @csrf
                                            <button class="admin-link admin-link-rojo" type="submit">Eliminar</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="admin-texto">No hay generos registrados.</p>
                        @endif
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
