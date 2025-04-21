<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    use HasFactory;
    protected $table = 'dia';
    protected $fillable = [
        'id',
        'nombre'
    ];

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'id_dia');
    }
    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class, 'ejercicio_dia', 'id_dia', 'id_ejercicio');
    }
}
