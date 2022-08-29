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

    // Una área le pertenece a un empleado
    public function empleado()
    {
        return $this->hasOne(Empleado::class);
    }
}
