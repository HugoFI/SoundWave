<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirigirSegunRol
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuario = Auth::user();

        if (!$usuario->activo_usuario) {
            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors(['email_usuario' => 'El usuario esta desactivado.']);
        }

        if ($usuario->rol_usuario === 'admin') {
            return redirect('/admin');
        }

        return redirect('/cliente');
    }
}
