<?php


namespace App\Http\Controllers\cliente;

use App\Http\Controllers\Controller;
use App\Models\Cancion;
use App\Models\Genero;
use App\Models\ListaReproduccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// CONTIENE LA LOGICA DE inicio.blade.php y cancion.blade.php

class InicioController extends Controller
{
    public function index(Request $request)
    {
        $usuario = Auth::user();

        $busqueda = $request->input('buscar', '');
        $generosSeleccionados = $request->input('generos', []);
        if (!is_array($generosSeleccionados)) {
            $generosSeleccionados = [$generosSeleccionados];
        }

        $generos = Genero::orderBy('nombre_genero')->get();

        $consulta = Cancion::with('artista');

        if ($busqueda !== '') {
            $consulta->where(function ($subquery) use ($busqueda) {
                $subquery->where('titulo_cancion', 'like', "%{$busqueda}%")
                    ->orWhereHas('artista', function ($artistaQuery) use ($busqueda) {
                        $artistaQuery->where('nombre_artista', 'like', "%{$busqueda}%");
                    });
            });
        }

        if (!empty($generosSeleccionados)) {
            $consulta->whereIn('id_genero_fk', $generosSeleccionados);
        }

        $canciones = $consulta->orderBy('titulo_cancion')->get();

        return view('cliente.inicio', compact(
            'usuario',
            'canciones',
            'generos',
            'busqueda',
            'generosSeleccionados'
        ));
    }

    public function mostrarCancion(int $id)
    {
        $usuario = Auth::user();

        $cancion = Cancion::with(['artista', 'genero'])->findOrFail($id);

        $userListas = ListaReproduccion::where('id_usuario_fk', $usuario->id_usuario)
            ->orderBy('nombre_lista')
            ->get();

        $userListasIds = $userListas->pluck('id_lista')->toArray();
        $listasSeleccionadas = $cancion->listas()
            ->whereIn('id_lista', $userListasIds)
            ->pluck('id_lista')
            ->toArray();

        return view('cliente.cancion', compact('usuario', 'cancion', 'userListas', 'listasSeleccionadas'));
    }

    // Guarda la cancion actual en la/s listas que selecciona el user. en cancion.blade
    public function guardarEnListas(Request $request, int $id)
    {
        $usuario = Auth::user();

        $cancion = Cancion::findOrFail($id);

        $userListasIds = ListaReproduccion::where('id_usuario_fk', $usuario->id_usuario)
            ->pluck('id_lista')
            ->toArray();

        // Normalizar entrada a array (maneja seleccion unica y multiple)
        $seleccionadas = $request->input('listas', []);
        if (!is_array($seleccionadas)) {
            $seleccionadas = [$seleccionadas];
        }

        // Convertir a enteros y validar que pertenezcan al usuario (SEGURIDAD)
        $seleccionadas = array_map('intval', $seleccionadas);
        $seleccionadas = array_values(array_intersect($userListasIds, $seleccionadas));

        // Eliminar relaciones existentes para las listas del usuario y luego agregar las nuevas
        // Detach es un método de Eloquent que elimina registros de la tabla pivote, en este caso se eliminan 
        // todas las relaciones de la canción con las listas del usuario para luego agregar solo las seleccionadas, 
        // esto asegura que si el usuario deselecciona una lista, esa relación se elimine correctamente
        $cancion->listas()
            ->whereIn('id_lista', $userListasIds)
            ->detach();

        // Adjuntar solo las listas seleccionadas que pertenecen al usuario
        // Attach es un método de Eloquent que agrega registros a la tabla pivote sin eliminar los existentes, 
        // por eso se hace detach antes para limpiar las relaciones anteriores
        if (!empty($seleccionadas)) {
            $cancion->listas()->attach($seleccionadas);
        }

        return redirect()
            ->route('cliente.cancion', ['id' => $id])
            ->with('mensaje', 'Listas actualizadas correctamente.');
    }

    public function buscarAjax(Request $request)
    {
        $busqueda = trim($request->input('buscar', ''));
        $generosSeleccionados = $request->input('generos', []);
        if (!is_array($generosSeleccionados)) {
            $generosSeleccionados = [$generosSeleccionados];
        }

        $consulta = Cancion::with(['artista', 'genero']);

        if ($busqueda !== '') {
            $consulta->where(function ($subquery) use ($busqueda) {
                $subquery->where('titulo_cancion', 'like', "%{$busqueda}%")
                    ->orWhere('duracion_cancion', 'like', "%{$busqueda}%")
                    ->orWhereHas('artista', function ($artistaQuery) use ($busqueda) {
                        $artistaQuery->where('nombre_artista', 'like', "%{$busqueda}%");
                    })
                    ->orWhereHas('genero', function ($generoQuery) use ($busqueda) {
                        $generoQuery->where('nombre_genero', 'like', "%{$busqueda}%");
                    });
            });
        }

        if (!empty($generosSeleccionados)) {
            $consulta->whereIn('id_genero_fk', $generosSeleccionados);
        }

        $canciones = $consulta->orderBy('titulo_cancion')->get();

        $respuesta = $canciones->map(function ($cancion) {
            return [
                'id' => $cancion->id_cancion,
                'titulo' => $cancion->titulo_cancion,
                'artista' => $cancion->artista->nombre_artista ?? 'Sin artista',
                'portada' => asset($cancion->ruta_portada_cancion),
            ];
        });

        return response()->json([
            'canciones' => $respuesta,
        ]);
    }
}
