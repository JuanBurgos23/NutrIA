<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAlimento extends Model
{
    use HasFactory;
    protected $table = 'tipo_alimento';
    protected $fillable = [
        'id',
        'nombre'
    ];

    public function alimentos()
    {
        return $this->hasMany(Alimento::class, 'id_tipoAlimento');
    }
}
