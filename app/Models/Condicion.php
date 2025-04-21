<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condicion extends Model
{
    use HasFactory;
    protected $table = 'condicion';
    
    protected $fillable = [
        
        'id',
        'operaciones',
        'alergia',
        'discapacidad',
        
        
        
    ];
}
