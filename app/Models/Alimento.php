<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    use HasFactory;
    protected $table = 'alimento';
    protected $fillable = [
        'id',
        'nombre',
        'caloria',
        'carbohidrato',
        'proteina',
        'grasa',
        'fibra',
        'vitamina',
        'potacio',
        'id_tipoAlimento'
    ];

    public function tipoAlimento()
    {
        return $this->belongsTo(TipoAlimento::class, 'id_tipoAlimento');
    }
    
}
