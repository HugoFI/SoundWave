<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SoundWave - {{ $cancion->titulo_cancion }}</title>
        <link rel="stylesheet" href="{{ asset('css/cliente.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    </head>
    <body class="cliente-body">
        <header class="cliente-header">
            <div class="cliente-header-izquierda">
                <div class="cliente-logo">SoundWave</div>
                <nav class="cliente-nav">
                    <a class="cliente-nav-link" href="{{ route('cliente.inicio') }}">Catalogo</a>
                    <a class="cliente-nav-link" href="{{ route('cliente.listas') }}">Listas</a>
                </nav>
            </div>
            <div class="cliente-usuario">Usuario: {{ $usuario->nombre_usuario }}
                <a class="btn-cerrar-sesion" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i> Cerrar sesion</a>
            </div>
        </header>

        <main class="cliente-contenedor">
            <section class="cliente-panel">
                <a class="cancion-volver" href="{{ route('cliente.inicio') }}"> <i class="bi bi-arrow-left"></i> Volver al catalogo</a>

                @if (session('mensaje'))
                    <div class="cancion-alerta">{{ session('mensaje') }}</div>
                @endif

                <div class="cancion-detalle">
                    <div class="cancion-detalle-img">
                        <img src="{{ asset($cancion->ruta_portada_cancion) }}" alt="Portada de {{ $cancion->titulo_cancion }}">
                    </div>
                    <div class="cancion-detalle-info">
                        <h1 class="cancion-detalle-titulo">{{ $cancion->titulo_cancion }}</h1>
                        <p class="cancion-texto">Artista: {{ $cancion->artista->nombre_artista ?? 'Sin artista' }}</p>
                        <p class="cancion-texto">Genero: {{ $cancion->genero->nombre_genero ?? 'Sin genero' }}</p>
                        <p class="cancion-texto">Duracion: {{ $cancion->duracion_cancion }} s</p>

                        <audio class="cancion-audio" controls src="{{ asset($cancion->ruta_audio_cancion) }}">
                            Tu navegador no soporta audio.
                        </audio>
                        <h2 class="cancion-subtitulo">Agregar a lista de reproduccion</h2>
                        <form class="cancion-form" method="POST" action="{{ route('cliente.cancion.listas', ['id' => $cancion->id_cancion]) }}">
                            @csrf
                            <div class="cancion-listas">
                                @if ($userListas->isNotEmpty())
                                    @foreach($userListas as $lista)
                                        <label class="cancion-check">
                                            <input type="checkbox" name="listas[]" value="{{ $lista->id_lista }}" {{ in_array($lista->id_lista, $listasSeleccionadas) ? 'checked' : '' }}>
                                            <span>{{ $lista->nombre_lista }}</span>
                                        </label>
                                    @endforeach
                                @else
                                    <p class="cancion-texto">No tienes listas creadas.</p>
                                @endif
                            </div>
                            <button class="cancion-boton" type="submit">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
