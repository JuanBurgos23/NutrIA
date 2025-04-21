<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    use HasFactory;
    protected $table = 'resultado';
    protected $primaryKey = 'id_resultado';
    protected $fillable = [
        
        'id_planNutricional',
        'descripcion',
        
    ];
    public function planNutricional()
    {
        return $this->belongsTo(PlanNutricional::class, 'id_planNutricional'); // Asegúrate de que 'id_planNutricional' es la clave foránea
    }
}
