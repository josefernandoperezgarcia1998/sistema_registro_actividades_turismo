<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';

    protected $fillable = [
        'folio',
        // 'quien_reporta',
        'area_nombre',
        'servicio_id',
        'usuario_id',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'date_1',
        'date_2',
        'contador',
        'empleado_id',
    ];

    // Una activiad le pertenece a un usuario
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'usuario_id');
    }

    // Una activiad le pertenece a un servicio
    public function servicio()
    {
        return $this->belongsTo('App\Models\Servicio', 'servicio_id');
    }

    public function empleado()
    {
        return $this->belongsTo('App\Models\Empleado', 'empleado_id');
    }

}
