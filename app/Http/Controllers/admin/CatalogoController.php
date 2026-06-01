<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Artista;
use App\Models\Cancion;
use App\Models\Genero;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CatalogoController extends Controller
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

        $consulta = Cancion::with(['artista', 'genero']);

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

        return view('admin.catalogo', compact(
            'usuario',
            'canciones',
            'generos',
            'busqueda',
            'generosSeleccionados'
        ));
    }

    public function crear()
    {
        $usuario = Auth::user();
        $artistas = Artista::orderBy('nombre_artista')->get();
        $generos = Genero::orderBy('nombre_genero')->get();

        return view('admin.cancion-crear', compact('usuario', 'artistas', 'generos'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'titulo_cancion' => ['required', 'string', 'max:255'],
            'duracion_cancion' => ['required', 'integer', 'min:1'],
            'id_artista_fk' => ['required', 'exists:tbl_artistas,id_artista'],
            'id_genero_fk' => ['required', 'exists:tbl_generos,id_genero'],
            'portada_cancion' => ['required', 'file', 'mimes:jpg,jpeg,png,webp'],
            'audio_cancion' => ['required', 'file', 'mimes:mp3,wav,ogg'],
        ], [
            'titulo_cancion.required' => 'El titulo es obligatorio.',
            'duracion_cancion.required' => 'La duracion es obligatoria.',
            'id_artista_fk.required' => 'El artista es obligatorio.',
            'id_genero_fk.required' => 'El genero es obligatorio.',
            'portada_cancion.required' => 'La portada es obligatoria.',
            'audio_cancion.required' => 'El audio es obligatorio.',
        ]);

        // Manejo de archivos: almacena en el disco público y guarda las rutas relativas en la base de datos
        $portadaPath = $request->file('portada_cancion')->store('portadas', 'public');
        $audioPath = $request->file('audio_cancion')->store('audio', 'public');

        // Obtener las URLs públicas de los archivos almacenados
        $rutaPortada = ltrim(Storage::url($portadaPath), '/');
        $rutaAudio = ltrim(Storage::url($audioPath), '/');

        Cancion::create([
            'titulo_cancion' => $request->input('titulo_cancion'),
            'duracion_cancion' => $request->input('duracion_cancion'),
            'id_artista_fk' => $request->input('id_artista_fk'),
            'id_genero_fk' => $request->input('id_genero_fk'),
            'ruta_portada_cancion' => $rutaPortada,
            'ruta_audio_cancion' => $rutaAudio,
        ]);

        return redirect()
            ->route('admin.catalogo')
            ->with('mensaje', 'Cancion creada correctamente.');
    }

    public function editar(int $id)
    {
        $usuario = Auth::user();
        $cancion = Cancion::findOrFail($id);
        $artistas = Artista::orderBy('nombre_artista')->get();
        $generos = Genero::orderBy('nombre_genero')->get();

        return view('admin.cancion-editar', compact('usuario', 'cancion', 'artistas', 'generos'));
    }

    public function actualizar(Request $request, int $id)
    {
        $request->validate([
            'titulo_cancion' => ['required', 'string', 'max:255'],
            'duracion_cancion' => ['required', 'integer', 'min:1'],
            'id_artista_fk' => ['required', 'exists:tbl_artistas,id_artista'],
            'id_genero_fk' => ['required', 'exists:tbl_generos,id_genero'],
            'portada_cancion' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
            'audio_cancion' => ['nullable', 'file', 'mimes:mp3,wav,ogg'],
        ], [
            'titulo_cancion.required' => 'El titulo es obligatorio.',
            'duracion_cancion.required' => 'La duracion es obligatoria.',
            'id_artista_fk.required' => 'El artista es obligatorio.',
            'id_genero_fk.required' => 'El genero es obligatorio.',
        ]);

        $cancion = Cancion::findOrFail($id);

        $rutaPortada = $cancion->ruta_portada_cancion;
        $rutaAudio = $cancion->ruta_audio_cancion;

        if ($request->hasFile('portada_cancion')) {
            $portadaPath = $request->file('portada_cancion')->store('portadas', 'public');
            $rutaPortada = ltrim(Storage::url($portadaPath), '/');
        }

        if ($request->hasFile('audio_cancion')) {
            $audioPath = $request->file('audio_cancion')->store('audio', 'public');
            $rutaAudio = ltrim(Storage::url($audioPath), '/');
        }

        $cancion->update([
            'titulo_cancion' => $request->input('titulo_cancion'),
            'duracion_cancion' => $request->input('duracion_cancion'),
            'id_artista_fk' => $request->input('id_artista_fk'),
            'id_genero_fk' => $request->input('id_genero_fk'),
            'ruta_portada_cancion' => $rutaPortada,
            'ruta_audio_cancion' => $rutaAudio,
        ]);

        return redirect()
            ->route('admin.catalogo')
            ->with('mensaje', 'Cancion actualizada correctamente.');
    }

    public function eliminar(int $id)
    {
        $cancion = Cancion::findOrFail($id);

        DB::transaction(function () use ($cancion) {
            DB::table('tbl_cancion_lista')
                ->where('id_cancion_fk', $cancion->id_cancion)
                ->delete();

            $cancion->delete();
        });

        return redirect()
            ->route('admin.catalogo')
            ->with('mensaje', 'Cancion eliminada correctamente.');
    }


    // Funciones para gestionar artistas y generos
    public function artistasGeneros()
    {
        $usuario = Auth::user();
        $artistas = Artista::orderBy('nombre_artista')->get();
        $generos = Genero::orderBy('nombre_genero')->get();

        return view('admin.artistas-generos', compact('usuario', 'artistas', 'generos'));
    }

    public function guardarArtista(Request $request)
    {
        $request->validate([
            'nombre_artista' => ['required', 'string', 'max:255', 'unique:tbl_artistas,nombre_artista'],
        ], [
            'nombre_artista.required' => 'El nombre del artista es obligatorio.',
            'nombre_artista.unique' => 'El artista ya existe.',
        ]);

        Artista::create([
            'nombre_artista' => $request->input('nombre_artista'),
        ]);

        return redirect()
            ->route('admin.artistas-generos')
            ->with('mensaje_artista', 'Artista creado correctamente.');
    }

    public function guardarGenero(Request $request)
    {
        $request->validate([
            'nombre_genero' => ['required', 'string', 'max:255', 'unique:tbl_generos,nombre_genero'],
        ], [
            'nombre_genero.required' => 'El nombre del genero es obligatorio.',
            'nombre_genero.unique' => 'El genero ya existe.',
        ]);

        Genero::create([
            'nombre_genero' => $request->input('nombre_genero'),
        ]);

        return redirect()
            ->route('admin.artistas-generos')
            ->with('mensaje_genero', 'Genero creado correctamente.');
    }

    public function eliminarArtista(int $id)
    {
        $enUso = Cancion::where('id_artista_fk', $id)->exists();
        if ($enUso) {
            return redirect()
                ->route('admin.artistas-generos')
                ->with('error', 'No se puede eliminar el artista: tiene canciones asociadas.');
        }

        $artista = Artista::findOrFail($id);
        $artista->delete();

        return redirect()
            ->route('admin.artistas-generos')
            ->with('mensaje_artista', 'Artista eliminado correctamente.');
    }

    public function eliminarGenero(int $id)
    {
        $enUso = Cancion::where('id_genero_fk', $id)->exists();
        if ($enUso) {
            return redirect()
                ->route('admin.artistas-generos')
                ->with('error', 'No se puede eliminar el genero: tiene canciones asociadas.');
        }

        $genero = Genero::findOrFail($id);
        $genero->delete();

        return redirect()
            ->route('admin.artistas-generos')
            ->with('mensaje_genero', 'Genero eliminado correctamente.');
    }

    
}
