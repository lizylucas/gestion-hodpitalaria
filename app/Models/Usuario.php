<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario'; // Nombre de la tabla en la base de datos

    protected $primaryKey = 'cedula'; // La clave primaria es 'cedula'
    public $incrementing = false; // Si no es autoincremental
    protected $keyType = 'string'; // El tipo de clave primaria es string

    protected $fillable = [
        'cedula',
        'nombre',
        'apellido',
        'telefono',
        'correo_elec',
        'sexo',
        'estado_civil',
        'titulo',
    ];
}
