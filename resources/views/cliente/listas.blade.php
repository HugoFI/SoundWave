<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SoundWave - Listas</title>
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
                <h1 class="listas-titulo">Listas de reproduccion</h1>
                <p class="listas-texto">Aqui puedes crear listas publicas o privadas.</p>

                @if (session('mensaje'))
                    <div class="listas-alerta">{{ session('mensaje') }}</div>
                @endif

                @if ($errors->any())
                    <div class="listas-alerta listas-alerta-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="listas-form" method="POST" action="{{ route('cliente.listas.guardar') }}">
                    @csrf
                    <div class="listas-grupo">
                        <label class="listas-label" for="nombre_lista">Nombre de la lista</label>
                        <input class="listas-input" type="text" id="nombre_lista" name="nombre_lista" value="{{ old('nombre_lista') }}" placeholder="Ej: Mi lista de favs">
                    </div>

                    <label class="listas-check">
                        <input type="checkbox" name="es_publica_lista" value="1" {{ old('es_publica_lista') ? 'checked' : '' }}>
                        <span>Lista publica</span>
                    </label>

                    <button class="listas-boton" type="submit">Crear lista</button>
                </form>

                @if ($listas->isNotEmpty())
                    <div class="listas-grid">
                        @foreach ($listas as $lista)
                            <a class="listas-card" href="{{ route('cliente.listas.ver', ['id' => $lista->id_lista]) }}">
                                <h2 class="listas-subtitulo">{{ $lista->nombre_lista }}</h2>
                                <p class="listas-texto">Propietario: {{ $lista->usuario->nombre_usuario ?? 'Desconocido' }}</p>
                                <p class="listas-texto">Visibilidad: {{ $lista->es_publica_lista ? 'Publica' : 'Privada' }}</p>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="listas-vacio">No hay listas disponibles.</p>
                @endif
            </section>
        </main>
    </body>
</html>
