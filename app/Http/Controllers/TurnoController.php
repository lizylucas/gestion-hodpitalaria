<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turno;
use App\Models\Horario;
use App\Models\User;

class TurnoController extends Controller
{
    public function store(Request $request)
    {
        // Verificar que el usuario autenticado tenga el rol de recepcionista
        if (auth()->user()->role !== 'recepcionista') {
            return response()->json([
                'message' => 'No tienes permiso para realizar esta acción',
            ], 403);
        }

        // Validar los datos del turno
        $request->validate([
            'cedula' => 'required|string|max:255',
            'fecha_hora' => 'required|date',
            'motivo' => 'required|string|max:255',
            'medico_nombre' => 'required|string', // Nombre del médico que selecciona el recepcionista
        ]);

        // Buscar al médico por nombre (o correo si prefieres)
        $medico = User::where('name', $request->medico_nombre)
                      ->where('role', 'medico') // Validar que sea un médico
                      ->first();

        if (!$medico) {
            return response()->json([
                'message' => 'Médico no encontrado o no es un médico',
            ], 404);
        }

        // Obtener los datos del turno (fecha_hora es un string en formato "YYYY-MM-DD HH:MM:SS")
        $fecha_hora = $request->fecha_hora;
        $hora = substr($fecha_hora, 11, 5); // Extraemos solo la hora (formato H:i)

        // Verificar si el horario está disponible para el médico
        $horario = Horario::where('user_id', $medico->id)
                          ->where('fecha', substr($fecha_hora, 0, 10)) // Fecha en formato YYYY-MM-DD
                          ->whereTime('hora_inicio', '<=', $hora)
                          ->whereTime('hora_fin', '>=', $hora)
                          ->exists();

        if (!$horario) {
            return response()->json(['message' => 'La hora seleccionada no está disponible.'], 400);
        }

        // Si el horario está disponible, procedemos a crear el turno
        $turno = Turno::create([
            'cedula' => $request->cedula,
            'fecha_hora' => $fecha_hora,
            'motivo' => $request->motivo,
            'medico_id' => $medico->id, // Guardamos el ID del médico que fue seleccionado
        ]);

        return response()->json([
            'message' => 'Turno creado exitosamente',
            'turno' => $turno,
        ], 201);
    }

    public function index()
    {
        // Obtener todos los turnos
        $turnos = Turno::all();

        return response()->json([
            'message' => 'Lista de turnos obtenida exitosamente',
            'data' => $turnos,
        ]);
    }
}