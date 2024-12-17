<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Define la tabla asociada al modelo
     *
     * @var string
     */
    protected $table = 'user'; // Tu tabla es 'user', no 'users'

    /**
     * Los atributos que se pueden asignar en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Los atributos que deben estar ocultos para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [ // Cambiado de método a propiedad
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel usa 'hashed' para manejar automáticamente el hashing
    ];
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'user_id', 'id');
    }
}