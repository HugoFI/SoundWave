<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>SoundWave - Cliente</title>
		<link rel="stylesheet" href="{{ asset('css/cliente.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
	</head>
	<body class="cliente-body">
		<header class="cliente-header">
			<div class="cliente-header-izquierda">
				<div class="cliente-logo">SoundWave</div>
				<nav class="cliente-nav">
					<a class="cliente-nav-link activo" href="{{ route('cliente.inicio') }}">Catalogo</a>
					<a class="cliente-nav-link" href="{{ route('cliente.listas') }}">Listas</a>
				</nav>
			</div>
			<div class="cliente-usuario">Usuario: {{ $usuario->nombre_usuario }}
				<a class="btn-cerrar-sesion" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i> Cerrar sesion</a>
			</div>
		</header>

		<main class="cliente-contenedor">
			<section class="cliente-panel">
				<h1 class="catalogo-titulo">Catalogo de canciones</h1>
				<p class="catalogo-texto">Aqui se muestran todas las canciones disponibles.</p>

				<form class="catalogo-filtros" method="GET" action="{{ route('cliente.inicio') }}">
                    @csrf
					<div class="catalogo-filtros-grupo">
						<label class="catalogo-label" for="buscar">Buscar por nombre o artista</label>
						<input class="catalogo-input" type="text" id="buscar" name="buscar" value="{{ $busqueda }}" placeholder="Ej: Jamiroquai">
					</div>

					<div class="catalogo-filtros-grupo">
						<span class="catalogo-label">Filtrar por genero</span>
						<div class="catalogo-generos">
							@foreach ($generos as $genero)
								<label class="catalogo-genero-item">
									<input type="checkbox" name="generos[]" value="{{ $genero->id_genero }}" {{ in_array($genero->id_genero, $generosSeleccionados) ? 'checked' : '' }}>
									<span>{{ $genero->nombre_genero }}</span>
								</label>
							@endforeach
						</div>
					</div>

					<div class="catalogo-acciones">
						<button class="catalogo-boton" type="submit">Aplicar filtros</button>
						<a class="catalogo-link" href="{{ route('cliente.inicio') }}">Limpiar</a>
					</div>
				</form>

				<div class="catalogo-filtro-ajax">
					<label class="catalogo-label" for="buscar_ajax">Filtro dinamico (AJAX)</label>
					<input class="catalogo-input" type="text" id="buscar_ajax" placeholder="Escribe para filtrar sin recargar">
					<p class="catalogo-estado" id="catalogo-estado"></p>
				</div>

				<div class="catalogo-grid" id="catalogo-grid">
					@forelse ($canciones as $cancion)
						<a href="{{ route('cliente.cancion', ['id' => $cancion->id_cancion]) }}" class="catalogo-card-link">
							<article class="catalogo-card">
								<div class="catalogo-card-img">
									<img src="{{ asset($cancion->ruta_portada_cancion) }}" alt="Portada de {{ $cancion->titulo_cancion }}">
								</div>
								<div class="catalogo-card-body">
									<h2 class="catalogo-subtitulo">{{ $cancion->titulo_cancion }}</h2>
									<p class="catalogo-texto">Artista: {{ $cancion->artista->nombre_artista ?? 'Sin artista' }}</p>
								</div>
							</article>
						</a>
					@empty
						<p class="catalogo-vacio">No hay canciones registradas.</p>
					@endforelse
				</div>
			</section>
		</main>
		<script src="{{ asset('js/cliente.js') }}"></script>
	</body>
</html>
