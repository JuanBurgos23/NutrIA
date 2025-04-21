<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Paciente extends Model
{
    use HasFactory;
    protected $table = 'paciente';
    protected $primaryKey = 'id_paciente';
    protected $fillable = [
        
        'id_user',
        'nombre',
        'paterno',
        'materno',
        'genero',
        'edad',
        'fecha_nac',
        'celular',
        'direccion'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user'); // Asegúrate de que 'id_user' es la clave foránea
    }

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->paterno} {$this->materno}";
    }

    public function getEdadAttribute()
    {
        return Carbon::parse($this->fecha_nac)->age; // Calcula la edad
    }
}
