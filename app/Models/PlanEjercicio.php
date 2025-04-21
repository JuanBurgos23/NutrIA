<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanEjercicio extends Model
{
    use HasFactory;
    protected $table = "plan_ejercicio";
    protected $fillable = [
        "id_ejercicio",
        "id_planNutricional",
    ];

    //relacion
    public function ejercicio(){
        return $this->belongsTo(Ejercicio::class,'id_ejercicio');
    }

    public function plan(){
        return $this->belongsTo(PlanNutricional::class,'id_planNutricional');
    }
}
