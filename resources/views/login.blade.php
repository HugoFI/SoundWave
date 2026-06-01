<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>SoundWave - Login</title>
		<link rel="stylesheet" href="{{ asset('css/login-registro.css') }}">
	</head>
	<body class="log-reg-body">
		<main class="log-reg-contenedor">
			<section class="log-reg-card">
				<div class="log-reg-logo">SoundWave</div>
				<h1 class="log-reg-titulo">Iniciar sesion</h1>
				<p class="log-reg-subtitulo">Acceso a la plataforma</p>

				@if (session('mensaje'))
					<div class="log-reg-alerta exito">{{ session('mensaje') }}</div>
				@endif

				@if ($errors->any())
					<div class="log-reg-alerta error">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<form class="log-reg-form" method="POST" action="{{ route('login.procesar') }}">
					@csrf
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
							autocomplete="current-password"
						>
					</div>

					<button class="log-reg-boton" type="submit">Entrar</button>
				</form>

				<div class="log-reg-pie">
					<span>No tienes cuenta?</span>
					<a href="{{ route('registro.form') }}">Crear cuenta</a>
				</div>
			</section>
		</main>
	</body>
</html>
