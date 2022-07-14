<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'areas';

    protected $fillable = [
        'nombre',
        'estado',
    ];

    // Un usuario tiene varios servicios
    public function actividades()
    {
        return $this->hasMany('App\Models\Actividad','actividad_id', 'id');
    }
}
