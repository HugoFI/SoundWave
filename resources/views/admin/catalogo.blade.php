<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>SoundWave - Admin</title>
		<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
	</head>
	<body class="admin-body">
		<header class="admin-header">
			<div class="admin-header-izquierda">
				<div class="admin-logo">SoundWave</div>
				<nav class="admin-nav">
					<a class="admin-nav-link activo" href="{{ route('admin.catalogo') }}">Catalogo</a>
					<a class="admin-nav-link" href="{{ route('admin.artistas-generos') }}">Artistas y generos</a>
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
				<h1 class="admin-titulo">Catalogo de canciones</h1>
				<p class="admin-texto">Gestion basica del catalogo.</p>

				@if (session('mensaje'))
					<div class="admin-alerta">{{ session('mensaje') }}</div>
				@endif

				<div class="admin-acciones-top">
					<a class="admin-boton-link" href="{{ route('admin.canciones.crear') }}">Nuevo tema</a>
				</div>

				<form class="admin-filtros" method="GET" action="{{ route('admin.catalogo') }}">
                    @csrf
					<div class="admin-filtros-grupo">
						<label class="admin-label" for="buscar">Buscar por nombre o artista</label>
						<input
							class="admin-input"
							type="text"
							id="buscar"
							name="buscar"
							value="{{ $busqueda }}"
							placeholder="Ej: Jamiroquai"
						>
					</div>

					<div class="admin-filtros-grupo">
						<span class="admin-label">Filtrar por genero</span>
						<div class="admin-generos">
							@foreach ($generos as $genero)
								<label class="admin-genero-item">
									<input
										type="checkbox"
										name="generos[]"
										value="{{ $genero->id_genero }}"
										{{ in_array($genero->id_genero, $generosSeleccionados) ? 'checked' : '' }}
									>
									<span>{{ $genero->nombre_genero }}</span>
								</label>
							@endforeach
						</div>
					</div>

					<div class="admin-acciones">
						<button class="admin-boton" type="submit">Aplicar filtros</button>
						<a class="admin-link" href="{{ route('admin.catalogo') }}">Limpiar</a>
					</div>
				</form>

				<div class="admin-tabla">
					<div class="admin-fila admin-cabecera">
						<span>Titulo</span>
						<span>Artista</span>
						<span>Genero</span>
						<span>Duracion</span>
						<span>Acciones</span>
					</div>
					@forelse ($canciones as $cancion)
						<div class="admin-fila">
							<span>{{ $cancion->titulo_cancion }}</span>
							<span>{{ $cancion->artista->nombre_artista ?? 'Sin artista' }}</span>
							<span>{{ $cancion->genero->nombre_genero ?? 'Sin genero' }}</span>
							<span>{{ $cancion->duracion_cancion }} s</span>
							<span class="admin-acciones-fila">
								<a class="admin-link" href="{{ route('admin.canciones.editar', ['id' => $cancion->id_cancion]) }}">Editar</a>
								<form class="admin-form-inline" method="POST" action="{{ route('admin.canciones.eliminar', ['id' => $cancion->id_cancion]) }}">
									@csrf
									<button class="admin-link admin-link-rojo" type="submit">Eliminar</button>
								</form>
							</span>
						</div>
					@empty
						<p class="admin-vacio">No hay canciones registradas.</p>
					@endforelse
				</div>
			</section>
		</main>
	</body>
</html>
