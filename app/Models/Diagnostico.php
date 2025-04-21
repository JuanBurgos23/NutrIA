<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    use HasFactory;
    protected $table = 'diagnostico';
    // Ocultar la relación que causa la recursión
    protected $hidden = ['consulta']; // o las relaciones que causan recursión
    
    protected $fillable = [
        
        'id',
        'detalle',
        'recomendacion',
        'id_consulta',
        
        
    ];
    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'id_consulta');
    }
}
