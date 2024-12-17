<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HorarioController;


// Ruta para iniciar sesión
Route::post('/login', [AuthController::class, 'login']);


Route::post('/crear_user', [UserController::class, 'store']);

//Rutas protegidas por sancturm y autenticacion
Route::middleware('auth:sanctum')->group(function () {
    // Ruta para cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout']);

    // Ruta para la visualizacion del usuario y contenido de la misma
    Route::get('/user-profile', [UserController::class, 'profile']);
    Route::get('/users', [UserController::class, 'index']);
    Route::put('/users/{id}', [UserController::class, 'update']); // Para editar usuarios
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Para eliminar usuarios
    //crear pacientes
    Route::post('pacientes', [UsuarioController::class, 'store']); // Solo recepcionistas pueden acceder
    Route::get('pacientes-ver', [UsuarioController::class, 'index']); // Cualquier usuario autenticado
    //Rutas para generar un turno y visualizar
    Route::get('/turnos-ver', [TurnoController::class, 'index']); //pueden ver los turnos todos
    Route::post('/turnos', [TurnoController::class, 'store']); //solo el recepcionista puede generar un turno
     //Verificacion de horarios y creacion de la misna
    Route::post('/crear_horario', [HorarioController::class, 'store']);
    Route::get('/horarios', [HorarioController::class, 'index']);
    //Obtener la lista de medicos
    Route::get('/medicos', [UserController::class, 'getMedicos']);
});
