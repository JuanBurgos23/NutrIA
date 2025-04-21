<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EjercicioDia extends Model
{
    use HasFactory;
    protected $table = 'ejercicio_dia';
    protected $fillable = [
        'id_ejercicio',
        'id_dia'
    ];
    public function ejercicio(){
        return $this->belongsTo(Ejercicio::class,'id_ejercicio');
    }
    public function dia(){
        return $this->belongsTo(Dia::class,'id_dia');
    }
}
