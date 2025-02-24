<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->validate([
            'user' => 'required',
            'password' => 'required',
        ]);

        // Buscar usuario con Query Builder
        $user = DB::table('usuarios')
            ->where('usuario', $credentials['user'])
            ->where('contrasena', $credentials['password']) // Comparación directa sin cifrado
            ->first();

        if ($user) {
            session(['user' => $user]); // Guardar usuario en sesión
            return redirect()->route('inicio');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    public function logout(Request $request){
        session()->forget('user');
        return redirect('/');
    }
}
