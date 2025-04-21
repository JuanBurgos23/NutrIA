<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Horario extends Model
{
    use HasFactory;
    protected $table = 'horario';
    protected $fillable = [
        'id',
        'hora',
        'id_periodo',
        'id_dia'
    ];

    public function periodo(){
        return $this->belongsTo(Periodo::class,'id_periodo');
    }
    public function dia(){
        return $this->belongsTo(Dia::class,'id_dia');
    }
}
