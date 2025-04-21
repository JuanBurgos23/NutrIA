<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    use HasFactory;
    protected $table = 'ejercicio';
    protected $fillable = [
        'nombre',
        'descripcion',
        'id_tipoEjercicio',
        'series',
        'repeticiones',
        'descanso',

    ];

    public function tipoEjercicio()
    {
        return $this->belongsTo(TipoEjercicio::class, 'id_tipoEjercicio');
    }
    public function dias()
    {
        return $this->belongsToMany(Dia::class, 'ejercicio_dia', 'id_ejercicio', 'id_dia');
    }
    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class, 'plan_ejercicio', 'id_planNutricional', 'id_ejercicio');
    }
}
