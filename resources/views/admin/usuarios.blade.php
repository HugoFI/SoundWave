<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SoundWave - Usuarios</title>
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    </head>
    <body class="admin-body">
        <header class="admin-header">
            <div class="admin-header-izquierda">
                <div class="admin-logo">SoundWave</div>
                <nav class="admin-nav">
                    <a class="admin-nav-link" href="{{ route('admin.catalogo') }}">Catalogo</a>
                    <a class="admin-nav-link" href="{{ route('admin.artistas-generos') }}">Artistas y generos</a>
                    <a class="admin-nav-link activo" href="{{ route('admin.usuarios') }}">Usuarios</a>
                </nav>
            </div>
            <div class="admin-usuario">
                Admin: {{ $usuario->nombre_usuario }}
                <a class="admin-cerrar" href="{{ route('logout') }}">Cerrar sesion</a>
            </div>
        </header>

        <main class="admin-contenedor">
            <section class="admin-panel">
                <h1 class="admin-titulo">Usuarios registrados</h1>
                <p class="admin-texto">Aqui puedes deshabilitar usuarios.</p>

                @if (session('mensaje'))
                    <div class="admin-alerta">{{ session('mensaje') }}</div>
                @endif

                @if (session('error'))
                    <div class="admin-alerta admin-alerta-error">{{ session('error') }}</div>
                @endif

                <form class="admin-filtros" method="GET" action="{{ route('admin.usuarios') }}">
                    @csrf
                    <div class="admin-filtros-grupo">
                        <label class="admin-label" for="buscar">Buscar por nombre o correo</label>
                        <input
                            class="admin-input"
                            type="text"
                            id="buscar"
                            name="buscar"
                            value="{{ $busqueda }}"
                            placeholder="Ej: usuario o correo@ejemplo.com"
                        >
                    </div>

                    <div class="admin-acciones">
                        <button class="admin-boton" type="submit">Aplicar filtro</button>
                        <a class="admin-link" href="{{ route('admin.usuarios') }}">Limpiar</a>
                    </div>
                </form>

                <div class="admin-tabla">
                    <div class="admin-fila admin-cabecera">
                        <span>Nombre</span>
                        <span>Correo</span>
                        <span>Rol</span>
                        <span>Estado</span>
                        <span>Acciones</span>
                    </div>
                    @foreach ($usuarios as $item)
                        <div class="admin-fila">
                            <span>{{ $item->nombre_usuario }}</span>
                            <span>{{ $item->email_usuario }}</span>
                            <span>{{ $item->rol_usuario }}</span>
                            <span>{{ $item->activo_usuario ? 'Activo' : 'Deshabilitado' }}</span>
                            <span class="admin-acciones-fila">
                                <form class="admin-form-inline" method="POST" action="{{ route('admin.usuarios.estado', ['id' => $item->id_usuario]) }}">
                                    @csrf
                                    <button class="admin-link admin-link-rojo" type="submit">
                                        {{ $item->activo_usuario ? 'Deshabilitar' : 'Habilitar' }}
                                    </button>
                                </form>
                            </span>
                        </div>
                    @endforeach
                </div>
            </section>
        </main>
    </body>
</html>
