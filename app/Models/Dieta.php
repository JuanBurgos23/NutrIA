<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dieta extends Model
{
    use HasFactory;
    protected $table = 'dieta';
    protected $fillable = [
        'nombre',
        'descripcion'
    ];
    public function detalleDietas2()
    {
        return $this->hasMany(DetalleDieta::class, 'id_dieta');  // Cambiado de belongsToMany a hasMany
    }
    public function detalleDietas1()
    {
        return $this->belongsToMany(Alimento::class, 'detalle_dieta', 'id_dieta', 'id_alimento')
            ->withPivot('id_periodo', 'id_dia', 'id_horario') // Campos adicionales de la tabla pivot
            ->withTimestamps(); // Para gestionar las fechas de creación/actualización
    }
}
