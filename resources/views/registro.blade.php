<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SoundWave - Registro</title>
        <link rel="stylesheet" href="{{ asset('css/login-registro.css') }}">
    </head>
    <body class="log-reg-body">
        <main class="log-reg-contenedor">
            <section class="log-reg-card">
                <div class="log-reg-logo">SoundWave</div>
                <h1 class="log-reg-titulo">Crear cuenta</h1>
                <p class="log-reg-subtitulo">Registro de usuario</p>

                @if ($errors->any())
                    <div class="log-reg-alerta error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="log-reg-form" method="POST" action="{{ route('registro.procesar') }}">
                    @csrf
                    <div class="log-reg-campo">
                        <label for="nombre_usuario">Nombre</label>
                        <input
                            type="text"
                            id="nombre_usuario"
                            name="nombre_usuario"
                            value="{{ old('nombre_usuario') }}"
                            required
                            autocomplete="name"
                        >
                    </div>

                    <div class="log-reg-campo">
                        <label for="email_usuario">Correo</label>
                        <input
                            type="email"
                            id="email_usuario"
                            name="email_usuario"
                            value="{{ old('email_usuario') }}"
                            required
                            autocomplete="email"
                        >
                    </div>

                    <div class="log-reg-campo">
                        <label for="contrasena_usuario">Contrasena</label>
                        <input
                            type="password"
                            id="contrasena_usuario"
                            name="contrasena_usuario"
                            required
                            autocomplete="new-password"
                        >
                    </div>

                    <div class="log-reg-campo">
                        <label for="contrasena_usuario_confirmation">Repite contrasena</label>
                        <input
                            type="password"
                            id="contrasena_usuario_confirmation"
                            name="contrasena_usuario_confirmation"
                            required
                            autocomplete="new-password"
                        >
                    </div>

                    <button class="log-reg-boton" type="submit">Registrarme</button>
                </form>

                <div class="log-reg-pie">
                    <span>Ya tienes cuenta?</span>
                    <a href="{{ route('login') }}">Iniciar sesion</a>
                </div>
            </section>
        </main>
    </body>
</html>
