<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function store(Request $request)
    {
        // Verificar que el usuario autenticado tenga el rol de recepcionista
        if (auth()->user()->role !== 'recepcionista') {
            return response()->json([
                'message' => 'No tienes permiso para realizar esta acción',
            ], 403);
        }

        // Validar los datos del usuario
        $request->validate([
            'cedula' => 'required|string|max:255|unique:usuario,cedula',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'correo_elec' => 'required|email|max:255|unique:usuario,correo_elec',
            'sexo' => 'required|string|in:masculino,femenino',
            'estado_civil' => 'required|string|max:255',
            'titulo' => 'nullable|string|max:255',
        ]);

        // Crear el usuario
        $usuario = Usuario::create($request->all());

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'usuario' => $usuario,
        ], 201);
    }

    public function index()
    {
        // Obtener todos los usuarios
        $usuarios = Usuario::all();

        return response()->json([
            'message' => 'Lista de usuarios obtenida exitosamente',
            'data' => $usuarios,
        ]);
    }
}