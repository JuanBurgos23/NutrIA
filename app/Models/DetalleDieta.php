<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleDieta extends Model
{
    use HasFactory;
    protected $table = 'detalle_dieta';
    protected $fillable = [
        'nombre',
        'cantidad',
        'id_dieta',
        'id_alimento',
        'id_periodo',
        'id_dia',
        'id_horario'
    ];

    public function dieta()
    {
        return $this->belongsTo(Dieta::class, 'id_dieta');
    }

    public function alimento()
    {
        return $this->belongsTo(Alimento::class, 'id_alimento');
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class, 'id_horario');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'id_periodo');
    }

    public function dia()
    {
        return $this->belongsTo(Dia::class, 'id_dia');
    }
}
