<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;

class HorarioController extends Controller
{
    public function store(Request $request)
    {
        // Verifica que el usuario autenticado sea médico
        $user = auth()->user();
        if (!$user || $user->role !== 'medico') {
            return response()->json(['message' => 'No tienes permiso para realizar esta acción'], 403);
        }

        // Validar los datos
        $request->validate([
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        // Crear el horario
        $horario = Horario::create([
            'user_id' => $user->id,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return response()->json(['message' => 'Horario creado exitosamente', 'horario' => $horario], 201);
    }

    public function index()
    {
        // Verifica el rol del usuario autenticado
        $user = auth()->user();
        if (!$user || !in_array($user->role, ['medico', 'recepcionista'])) {
            return response()->json(['message' => 'No tienes permiso para realizar esta acción'], 403);
        }

        // Si es médico, muestra solo sus horarios
        if ($user->role === 'medico') {
            $horarios = Horario::where('user_id', $user->id)->get();
        } 
        // Si es recepcionista, muestra todos los horarios
        else if ($user->role === 'recepcionista') {
            $horarios = Horario::all();
        }

        return response()->json(['message' => 'Horarios obtenidos exitosamente', 'data' => $horarios]);
    }
}