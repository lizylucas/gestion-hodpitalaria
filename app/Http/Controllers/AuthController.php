<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Buscar el usuario por correo
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado.'], 404);
        }

        // Verificar la contraseña
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Contraseña incorrecta.'], 401);
        }

        // Generar un token de acceso
        $token = $user->createToken('auth_token')->plainTextToken;

        // Retornar respuesta
        return response()->json([
            'message' => 'Inicio de sesión exitoso.',
            'token' => $token,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        // Revocar el token actual
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Cierre de sesión exitoso.',
        ]);
    }
}
