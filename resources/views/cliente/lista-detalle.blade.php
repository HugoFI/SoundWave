<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SoundWave - {{ $lista->nombre_lista }}</title>
        <link rel="stylesheet" href="{{ asset('css/cliente.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    </head>
    <body class="cliente-body">
        <header class="cliente-header">
            <div class="cliente-header-izquierda">
                <div class="cliente-logo">SoundWave</div>
                <nav class="cliente-nav">
                    <a class="cliente-nav-link" href="{{ route('cliente.inicio') }}">Catalogo</a>
                    <a class="cliente-nav-link activo" href="{{ route('cliente.listas') }}">Listas</a>
                </nav>
            </div>
            <div class="cliente-usuario">
                Usuario: {{ $usuario->nombre_usuario }}
                <a class="btn-cerrar-sesion" href="{{ route('logout') }}">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesion
                </a>
            </div>
        </header>

        <main class="cliente-contenedor">
            <section class="cliente-panel">
                <a class="listas-volver" href="{{ route('cliente.listas') }}">
                    <i class="bi bi-arrow-left"></i> Volver a listas
                </a>

                <h1 class="listas-titulo">{{ $lista->nombre_lista }}</h1>
                <p class="listas-texto">Propietario: {{ $lista->usuario->nombre_usuario ?? 'Desconocido' }}</p>
                <p class="listas-texto">Visibilidad: {{ $lista->es_publica_lista ? 'Publica' : 'Privada' }}</p>

                @if ($lista->canciones->isNotEmpty())
                    <div class="listas-canciones">
                        @foreach ($lista->canciones as $cancion)
                            <div class="listas-cancion">
                                <div class="listas-cancion-img">
                                    <img src="{{ asset($cancion->ruta_portada_cancion) }}" alt="Portada de {{ $cancion->titulo_cancion }}">
                                </div>
                                <div class="listas-cancion-info">
                                    <h2 class="listas-subtitulo">{{ $cancion->titulo_cancion }}</h2>
                                    <p class="listas-texto">Artista: {{ $cancion->artista->nombre_artista ?? 'Sin artista' }}</p>
                                    <audio class="listas-audio" controls src="{{ asset($cancion->ruta_audio_cancion) }}">
                                        Tu navegador no soporta audio.
                                    </audio>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="listas-vacio">Esta lista no tiene canciones.</p>
                @endif
            </section>
        </main>
    </body>
</html>
