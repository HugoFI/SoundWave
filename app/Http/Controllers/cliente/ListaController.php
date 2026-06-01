<?php

namespace App\Http\Controllers\cliente;

use App\Http\Controllers\Controller;
use App\Models\ListaReproduccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListaController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        $listas = ListaReproduccion::with('usuario')
            ->where('id_usuario_fk', $usuario->id_usuario)
            ->orWhere('es_publica_lista', true)
            ->orderBy('nombre_lista')
            ->get();

        return view('cliente.listas', compact('usuario', 'listas'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre_lista' => ['required', 'string', 'max:255'],
            'es_publica_lista' => ['nullable', 'boolean'],
        ], [
            'nombre_lista.required' => 'El nombre es obligatorio.',
        ]);

        $usuario = Auth::user();

        ListaReproduccion::create([
            'id_usuario_fk' => $usuario->id_usuario,
            'nombre_lista' => $request->input('nombre_lista'),
            'es_publica_lista' => $request->boolean('es_publica_lista'),
        ]);

        return redirect()
            ->route('cliente.listas')
            ->with('mensaje', 'Lista creada correctamente.');
    }

    public function ver(int $id)
    {
        $usuario = Auth::user();

        $lista = ListaReproduccion::with(['usuario', 'canciones.artista'])
            ->where('id_lista', $id)
            ->where(function ($query) use ($usuario) {
                $query->where('id_usuario_fk', $usuario->id_usuario)
                    ->orWhere('es_publica_lista', true);
            })
            ->firstOrFail();

        return view('cliente.lista-detalle', compact('usuario', 'lista'));
    }
}
