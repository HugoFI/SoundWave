<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        $usuarios = Usuario::orderBy('nombre_usuario')->get();

        return view('admin.usuarios', compact('usuario', 'usuarios'));
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
