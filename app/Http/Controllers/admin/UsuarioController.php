<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $usuario = Auth::user();

        $busqueda = $request->input('buscar', '');

        $consulta = Usuario::orderBy('nombre_usuario');

        if ($busqueda !== '') {
            $consulta->where(function ($subquery) use ($busqueda) {
                $subquery->where('nombre_usuario', 'like', "%{$busqueda}%")
                    ->orWhere('email_usuario', 'like', "%{$busqueda}%");
            });
        }

        $usuarios = $consulta->get();

        return view('admin.usuarios', compact('usuario', 'usuarios', 'busqueda'));
    }

    public function cambiarEstado(int $id)
    {
        if (Auth::id() === $id) {
            return redirect()
                ->route('admin.usuarios')
                ->with('error', 'No puedes cambiar el estado de tu propia cuenta.');
        }

        $usuario = Usuario::findOrFail($id);

        $usuario->activo_usuario = !$usuario->activo_usuario;
        $usuario->save();

        return redirect()
            ->route('admin.usuarios')
            ->with('mensaje', 'Se ha cambiado el estado del usuario.');
    }
}
