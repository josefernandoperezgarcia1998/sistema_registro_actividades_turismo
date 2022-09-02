<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Area;
use App\Models\Servicio;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        $actividadCount = Actividad::count();

        $actividadCountPrestador = Actividad::where('usuario_id',Auth::user()->id)->count();

        $catServicioCount = Servicio::count();

        $userCount = User::count();
        
        $areasCount = Area::count();

        // Obtener el mes actual
        $fecha = Carbon::now();
        $mes = $fecha->locale();
        $mes_actual = $fecha->monthName;

        return view('dashboard', compact('actividadCount', 'userCount', 'catServicioCount', 'areasCount','actividadCountPrestador', 'mes_actual'));
    }

    // Esta función asincrona envía los datos que permite mostrar la cantidad de servicios de manera general (todos los existentes)
    // En el modelo de servicios para generar gráficas.
    public function graficaGeneraldeServicios(){

        $servicios = Servicio::orderBy('id', 'desc')->with('actividades')->get();

        return response(json_encode($servicios), 200)->header('Content-type','text/plain');
    }

    // Esta función asincrona permite enviar los datos de las actividades realizadas por el mes actual (el mes que tome el servidor)
    public function graficaPorMes()
    {
        // Se hace la consulta: Del modelo "Activida" con relación de "servicio" seleccioname únicamente la columna "servicio_id" donde la fecha de inicio sea igual al mes actual
        $actividades = Actividad::with('servicio')->select('servicio_id')->whereMonth('fecha_inicio', date("m"))->get();
    
        // Se crea un arreglo vacío
        $nombresServiciosDeActividades = array();

        // Se crea un ciclo que recorre toda la colección de la consulta "$actividades" y esto almacena el nombre del servicio de las actividades en el arreglo
        foreach ($actividades as $key => $actividad) {
            $nombresServiciosDeActividades[] = $actividad->servicio->nombre;
        }

        // En la varible $servicios se almacena un arreglo que va a contar los valores que se repiten con la función "array_count_values"
        //Esta función permite contar cuantas veces se repite un valor de un arreglo.
        /* 
        Por ejemplo:Mantenimiento
                    Mantenimiento
                    Servicio
                    Asesoría
                    Servicio
                    Mantenimiento
        La salida sería: Mantenimiento 3, Servicio: 2, Asesoría: 1.
        */
        $servicios = array_count_values($nombresServiciosDeActividades);

        // Se crea un nuevo arreglo vacío
        $arreglo = array();

        // En este ciclo se recorre la cantidad de servicios que existan en el arreglo de $servicios
        /*
        Por ejemplo: $servicios contiene esto: Mantenimiento 3, Servicio: 2, Asesoría: 1.
                    Y el ciclo va a almacenar en el arreglo la clave y valor de estos en un espacio del arreglo
        Salida: En el espacio [0] del arreglo estaría como clave "Mantenimiento" y su valor sería 3
                En el espacio [1] del arreglo estaría como clave "Servicio" y su valor sería 2
                En el espacio [1] del arreglo estaría como clave "Asesoría" y su valor sería 1

        */
        foreach ($servicios as $key => $serv) {
            $arreglo[] = $key;
            $arreglo[] = $serv;
        }

        return response(json_encode( $arreglo), 200)->header('Content-type','text/plain');
    }

    public function graficarServiciosUsuarios()
    {
        
        $usuarios = User::with('actividades')->get();
        // return response()->json(['usuarios' => $usuarioActividades]);
        return response(json_encode($usuarios,JSON_UNESCAPED_UNICODE), 200)->header('Content-type','text/plain');
    }

}
