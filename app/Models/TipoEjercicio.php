<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEjercicio extends Model
{
    use HasFactory;

    protected $table = 'tipo_ejercicio';

    protected $fillable = [
        'nombre'
    ];
}
