<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, string $rol)
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

        if ($usuario->rol_usuario !== $rol) {
            return redirect()->route('inicio');
        }

        return $next($request);
    }
}
