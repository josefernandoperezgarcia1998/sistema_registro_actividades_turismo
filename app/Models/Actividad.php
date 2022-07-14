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
        'fecha_inicio',
        'quien_reporta',
        'descripcion',
        'fecha_fin',
        'usuario_id',
        'area_id',
        'servicio_id',
        'date_1',
        'date_2',
        'contador',
    ];

    // Una activiad le pertenece a un usuario
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'usuario_id');
    }

    // Una activiad le pertenece a un area
    public function area()
    {
        return $this->belongsTo('App\Models\Area', 'area_id');
    }

    // Una activiad le pertenece a un area
    public function servicio()
    {
        return $this->belongsTo('App\Models\Servicio', 'servicio_id');
    }

}
