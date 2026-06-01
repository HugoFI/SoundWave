<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SoundWave - Nuevo tema</title>
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    </head>
    <body class="admin-body">
        <header class="admin-header">
            <div class="admin-header-izquierda">
                <div class="admin-logo">SoundWave</div>
                <nav class="admin-nav">
                    <a class="admin-nav-link" href="{{ route('admin.catalogo') }}">Catalogo</a>
                    <a class="admin-nav-link" href="{{ route('admin.artistas-generos') }}">Artistas y generos</a>
                    <a class="admin-nav-link activo" href="{{ route('admin.canciones.crear') }}">Nuevo tema</a>
                </nav>
            </div>
            <div class="admin-usuario">
                Admin: {{ $usuario->nombre_usuario }}
                <a class="admin-cerrar" href="{{ route('logout') }}">Cerrar sesion</a>
            </div>
        </header>

        <main class="admin-contenedor">
            <section class="admin-panel">
                <a class="admin-volver" href="{{ route('admin.catalogo') }}">Volver al catalogo</a>

                <h1 class="admin-titulo">Nuevo tema</h1>
                <p class="admin-texto">Completa los datos para crear una cancion.</p>

                @if ($errors->any())
                    <div class="admin-alerta admin-alerta-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="admin-form" method="POST" action="{{ route('admin.canciones.guardar') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="admin-form-grupo">
                        <label class="admin-label" for="titulo_cancion">Titulo</label>
                        <input class="admin-input" type="text" id="titulo_cancion" name="titulo_cancion" value="{{ old('titulo_cancion') }}" required>
                    </div>

                    <div class="admin-form-grupo">
                        <label class="admin-label" for="duracion_cancion">Duracion (segundos)</label>
                        <input class="admin-input" type="number" id="duracion_cancion" name="duracion_cancion" min="1" value="{{ old('duracion_cancion') }}" required>
                    </div>

                    <div class="admin-form-grupo">
                        <label class="admin-label" for="id_artista_fk">Artista</label>
                        <select class="admin-input" id="id_artista_fk" name="id_artista_fk" required>
                            <option value="">Selecciona un artista</option>
                            @foreach ($artistas as $artista)
                                <option value="{{ $artista->id_artista }}" {{ old('id_artista_fk') == $artista->id_artista ? 'selected' : '' }}>
                                    {{ $artista->nombre_artista }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-form-grupo">
                        <label class="admin-label" for="id_genero_fk">Genero</label>
                        <select class="admin-input" id="id_genero_fk" name="id_genero_fk" required>
                            <option value="">Selecciona un genero</option>
                            @foreach ($generos as $genero)
                                <option value="{{ $genero->id_genero }}" {{ old('id_genero_fk') == $genero->id_genero ? 'selected' : '' }}>
                                    {{ $genero->nombre_genero }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-form-grupo">
                        <label class="admin-label" for="portada_cancion">Portada (imagen)</label>
                        <input class="admin-input" type="file" id="portada_cancion" name="portada_cancion" accept=".jpg,.jpeg,.png,.webp" required>
                    </div>

                    <div class="admin-form-grupo">
                        <label class="admin-label" for="audio_cancion">Audio</label>
                        <input class="admin-input" type="file" id="audio_cancion" name="audio_cancion" accept=".mp3,.wav,.ogg" required>
                    </div>

                    <button class="admin-boton" type="submit">Guardar tema</button>
                </form>
            </section>
        </main>
    </body>
</html>
