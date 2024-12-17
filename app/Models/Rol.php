<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relación con el modelo User
    public function users()
    {
        return $this->hasMany(User::class, 'role_id'); // Relación uno a muchos
    }
}
