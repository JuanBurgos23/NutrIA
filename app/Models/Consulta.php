<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;
    protected $table = 'consulta';
    
    protected $fillable = [
        'id',
        'motivo',
        'objetivo',
        'fecha_consulta',
        'id_imc',
        'id_condicion',
        'id_examen',
        'id_paciente',
        
    ];
    public function imc()
    {
        return $this->belongsTo(Imc::class, 'id_imc');
    }
    public function condicion()
    {
        return $this->belongsTo(Condicion::class, 'id_condicion');
    }
    public function examen()
    {
        return $this->belongsTo(Examen::class, 'id_examen');
    }
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }
}
