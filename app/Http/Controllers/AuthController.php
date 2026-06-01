<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function mostrarLogin()
    {
        return view('login');
    }

    public function mostrarRegistro()
    {
        return view('registro');
    }

    public function procesarLogin(Request $request)
    {
        $request->validate([
            'email_usuario' => ['required', 'email'],
            'contrasena_usuario' => ['required', 'string'],
        ], [
            'email_usuario.required' => 'El correo es obligatorio.',
            'email_usuario.email' => 'El correo no es valido.',
            'contrasena_usuario.required' => 'La contrasena es obligatoria.',
        ]);

        $credenciales = [
            'email_usuario' => $request->input('email_usuario'),
            'password' => $request->input('contrasena_usuario'),
        ];

        if (Auth::attempt($credenciales)) {

            // Verificar si el usuario está activo
            if (Auth::user()->activo_usuario != 1) {
                Auth::logout();

                return back()
                    ->withErrors(['email_usuario' => 'El usuario esta desactivado.'])
                    ->withInput();
            }

            $request->session()->regenerate();

            return redirect()->route('inicio');
        }

        return back()
            ->withErrors(['email_usuario' => 'Credenciales incorrectas.'])
            ->withInput();
    }

    public function procesarRegistro(Request $request)
    {
        $request->validate([
            'nombre_usuario' => ['required', 'string', 'max:255'],
            'email_usuario' => ['required', 'email', 'max:255', 'unique:tbl_usuarios,email_usuario'],
            'contrasena_usuario' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'nombre_usuario.required' => 'El nombre es obligatorio.',
            'email_usuario.required' => 'El correo es obligatorio.',
            'email_usuario.email' => 'El correo no es valido.',
            'email_usuario.unique' => 'El correo ya esta registrado.',
            'contrasena_usuario.required' => 'La contrasena es obligatoria.',
            'contrasena_usuario.confirmed' => 'Las contrasenas no coinciden.',
        ]);

        Usuario::create([
            'nombre_usuario' => $request->input('nombre_usuario'),
            'email_usuario' => $request->input('email_usuario'),
            'contrasena_usuario' => Hash::make($request->input('contrasena_usuario')),
            'rol_usuario' => 'cliente',
            'activo_usuario' => true,
        ]);

        return redirect()
            ->route('login')
            ->with('mensaje', 'Cuenta creada correctamente.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
