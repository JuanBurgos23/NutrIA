<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;
    protected $table = 'examen';
    
    protected $fillable = [
        
        'id',
        'descripcion',
        'id_tipoExamen'
    ];


    public function tipoExamen()
    {
        return $this->belongsTo(TipoExamen::class, 'id_tipoExamen');
    }
}
