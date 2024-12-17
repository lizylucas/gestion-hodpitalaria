<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Obtener todos los usuarios
        $users = User::all();

        // Retornar la respuesta en formato JSON
        return response()->json([
            'message' => 'Lista de usuarios obtenida exitosamente',
            'data' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email', // Cambia 'users' por 'user'
            'password' => 'required|string|min:6',
            'role' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'user' => $user,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:user,email,' . $id, // Cambia 'users' por 'user'
            'role' => 'string',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return response()->json(['message' => 'Usuario actualizado correctamente', 'user' => $user]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }

    // Nueva función para obtener médicos
    public function getMedicos()
    {
        // Filtrar usuarios con el rol 'medico'
        $medicos = User::where('role', 'medico')->get(['id', 'name', 'email']);

        return response()->json([
            'message' => 'Lista de médicos obtenida exitosamente',
            'data' => $medicos,
        ]);
    }
}