<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanNutricional extends Model
{
    use HasFactory;
    protected $table = 'plan_nutricional';

    protected $fillable = [
        'id',
        'descripcion',
        'estado',
        'id_periodo',
        'id_dieta',
        'id_diagnostico',

    ];
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'id_periodo');
    }
    public function dieta()
    {
        return $this->belongsTo(Dieta::class, 'id_dieta');
    }
    public function diagnostico()
    {
        return $this->belongsTo(Diagnostico::class, 'id_diagnostico');
    }
    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class, 'plan_ejercicio', 'id_planNutricional', 'id_ejercicio');
    }
}
