<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';

    protected $fillable = [
        'nombre',
        'estado',
        'sexo',
        'area_id',
    ];

    // Un empleado tiene una área
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class);
    }
}
