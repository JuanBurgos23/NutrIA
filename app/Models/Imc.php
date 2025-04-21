<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imc extends Model
{
    use HasFactory;
    protected $table = 'imc';
    
    protected $fillable = [
        
        'id',
        'peso',
        'altura',
        
        
    ];
}
