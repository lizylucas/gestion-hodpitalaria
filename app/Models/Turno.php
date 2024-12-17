<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $table = 'turno'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_turno'; // Clave primaria

    protected $fillable = [
        'cedula',
        'fecha_hora',
        'motivo',
    ];
}