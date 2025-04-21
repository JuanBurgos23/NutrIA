<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;

    protected $table = 'periodo';
    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin'
    ];

    public function horarios()
    {
        return $this->belongsToMany(Horario::class, 'horario', 'id_periodo', 'id_dia');
    }
    
}
