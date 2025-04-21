<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajeNotificacion extends Model
{
    use HasFactory;
    protected $table = 'mensaje_notificacions';

    protected $fillable = ['id_user', 'type', 'data','asunto','mensaje', 'read'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}