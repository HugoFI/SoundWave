<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SoundWave - Editar tema</title>
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    </head>
    <body class="admin-body">
        <header class="admin-header">
            <div class="admin-header-izquierda">
                <div class="admin-logo">SoundWave</div>
                <nav class="admin-nav">
                    <a class="admin-nav-link" href="{{ route('admin.catalogo') }}">Catalogo</a>
                    <a class="admin-nav-link" href="{{ route('admin.artistas-generos') }}">Artistas y generos</a>
                    <a class="admin-nav-link activo" href="{{ route('admin.canciones.editar', ['id' => $cancion->id_cancion]) }}">Editar tema</a>
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

                <h1 class="admin-titulo">Editar tema</h1>
                <p class="admin-texto">Actualiza la informacion de la cancion.</p>

                @if ($errors->any())
                    <div class="admin-alerta admin-alerta-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="admin-form" method="POST" action="{{ route('admin.canciones.actualizar', ['id' => $cancion->id_cancion]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="admin-form-grupo">
                        <label class="admin-label" for="titulo_cancion">Titulo</label>
                        <input class="admin-input" type="text" id="titulo_cancion" name="titulo_cancion" value="{{ old('titulo_cancion', $cancion->titulo_cancion) }}">
                    </div>

                    <div class="admin-form-grupo">
                        <label class="admin-label" for="duracion_cancion">Duracion (segundos)</label>
                        <input class="admin-input" type="number" id="duracion_cancion" name="duracion_cancion" min="1" value="{{ old('duracion_cancion', $cancion->duracion_cancion) }}">
                    </div>

                    <div class="admin-form-grupo">
                        <label class="admin-label" for="id_artista_fk">Artista</label>
                        <select class="admin-input" id="id_artista_fk" name="id_artista_fk">
                            @foreach ($artistas as $artista)
                                <option value="{{ $artista->id_artista }}" {{ (string) old('id_artista_fk', $cancion->id_artista_fk) === (string) $artista->id_artista ? 'selected' : '' }}>
                                    {{ $artista->nombre_artista }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-form-grupo">
                        <label class="admin-label" for="id_genero_fk">Genero</label>
                        <select class="admin-input" id="id_genero_fk" name="id_genero_fk">
                            @foreach ($generos as $genero)
                                <option value="{{ $genero->id_genero }}" {{ (string) old('id_genero_fk', $cancion->id_genero_fk) === (string) $genero->id_genero ? 'selected' : '' }}>
                                    {{ $genero->nombre_genero }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-form-grupo">
                        <label class="admin-label" for="portada_cancion">Portada (opcional)</label>
                        <input class="admin-input" type="file" id="portada_cancion" name="portada_cancion" accept=".jpg,.jpeg,.png,.webp">
                    </div>

                    <div class="admin-form-grupo">
                        <label class="admin-label" for="audio_cancion">Audio (opcional)</label>
                        <input class="admin-input" type="file" id="audio_cancion" name="audio_cancion" accept=".mp3,.wav,.ogg">
                    </div>

                    <button class="admin-boton" type="submit">Guardar cambios</button>
                </form>
            </section>
        </main>
    </body>
</html>
