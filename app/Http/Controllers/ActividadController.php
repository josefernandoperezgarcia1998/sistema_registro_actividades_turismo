<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActividadesExport;
use App\Models\Area;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use DataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class ActividadController extends Controller
{
    // Vista principal de servicios
    public function index()
    {
        return view('actividades.index');
    }

    // Función para mandar a llamar a la vista de crear un nuevo servicio
    public function create()
    {
        $users = DB::table('users')
                    ->where('estado','Si')
                    ->orderBy('name','asc')
                    ->get();

        $areas = DB::table('areas')
                    ->where('estado','Si')
                    ->orderBy('nombre','asc')
                    ->get();

        $servicios = DB::table('servicios')
                        ->orderBy('nombre','asc')
                        ->get();

        return view('actividades.create', compact('users','areas', 'servicios'));
    }

    // Función para crear un servicio
    public function store(Request $request)
    {
        $service = $request->all();

        $validated = $request->validate([
            'quien_reporta' => 'required',
            'area_id'       => 'required',
            'servicio_id'   => 'required',
            'descripcion'   => 'required',
            'fecha_inicio'  => 'required',
        ]);

        $date_start = Carbon::parse($service['fecha_inicio']);
        $date_start_with_format = $date_start->isoFormat('LLLL');
        $service['date_1'] = $date_start_with_format;

        $date_end = Carbon::parse($service['fecha_fin']);
        $date_end_with_format = $date_end->isoFormat('LLLL');
        $service['date_2'] = $date_end_with_format;

        $mes_actual = date("m");
        $ano_actual = date("Y");
        
        // Obteniendo el nombre del usuario autenticado
        $nombreUsuario = Auth::user()->name;

        // Obteniendo las letras del nombre autenticado
        $letrasNombre = '';
        $explode = explode(' ',$nombreUsuario);
        foreach($explode as $x){
            $letrasNombre .=  $x[0];
        }
        
        // Obteniendo el mes
        $fecha = $request->fecha_inicio;
        $date = Carbon::parse($fecha);
        $mes_creacion = $date->month;

        if($mes_creacion == 1){
            $mes_creacion = "01";
        } elseif ($mes_creacion == 2) {
            $mes_creacion = "02";
        } elseif ($mes_creacion == 3) {
            $mes_creacion = "03";
        } elseif ($mes_creacion == 4) {
            $mes_creacion = "04";
        } elseif ($mes_creacion == 5) {
            $mes_creacion = "05";
        } elseif ($mes_creacion == 6) {
            $mes_creacion = "06";
        } elseif ($mes_creacion == 7) {
            $mes_creacion = "07";
        } elseif ($mes_creacion == 8) {
            $mes_creacion = "08";
        } elseif ($mes_creacion == 9) {
            $mes_creacion = "09";
        } elseif ($mes_creacion == 10) {
            $mes_creacion = "10";
        } elseif ($mes_creacion == 11) {
            $mes_creacion = "11";
        } elseif ($mes_creacion == 12) {
            $mes_creacion = "12";
        } else{
            return 'no valido';
        }
        $order ='';
        $service['contador'] = $order;

        $service['folio'] =  $service['contador'] .'-'. $letrasNombre .'-'. $mes_actual;

        if($mes_creacion == $mes_actual){
            $order = 1;
            $records = Actividad::whereMonth('fecha_inicio', $mes_creacion)->get();
    
            foreach($records as $row) {
                $row->contador = $order;
                $row->update();
                $order++;
            }
    
            $service['contador'] = $order;
            $service['folio'] =  $service['contador'] .'-'. $letrasNombre .'-'. $mes_actual;
        } elseif(!($mes_creacion == $mes_actual)) {
            $order = 1;
            $records = Actividad::whereMonth('fecha_inicio', $mes_creacion)->get();
    
            foreach($records as $row) {
                $row->contador = $order;
                $row->update();
                $order++;
            }

            $service['contador'] = $order;

            $service['folio'] =  $service['contador'] .'-'. $letrasNombre .'-'. $mes_actual;

        } else {
            return redirect()->back()->with('error', 'No puedes crear un servicio con una fecha que no sea de este mes.')->withInput();
        }

        Actividad::create($service);
        

        return redirect()->route('actividades.index')->with('success', 'Registro creado correctamente');
    }

    // Función para mostrar un servicio en específico, al igual que se pasan variables para
    // poder hacer los selects de los combos.
    public function show($id)
    {
        $actividad = Actividad::findOrFail($id);
        
        $users = DB::table('users')
                    ->where('estado','Si')
                    ->orderBy('name','asc')
                    ->get();

        $areas = DB::table('areas')
                    ->where('estado','Si')
                    ->orderBy('nombre','asc')
                    ->get();
        $servicios = DB::table('servicios')->orderBy('nombre','asc')->get();

        return view('actividades.show', compact('actividad','users','areas', 'servicios'));
    }

    // Función para actualizar un servicio
    public function update(Request $request, $id)
    {
        $service_data = request()->except('_token','_method');

        $validated = $request->validate([
            'quien_reporta' => 'required',
            'area_id'       => 'required',
            'servicio_id'   => 'required',
            'descripcion'   => 'required',
            'fecha_inicio'  => 'required',
        ]);
        
        // Modified the dates for understanding lenguage
        $date_start = Carbon::parse($service_data['fecha_inicio']);
        $date_start_with_format = $date_start->isoFormat('LLLL');
        $service_data['date_1'] = $date_start_with_format;

        $date_end = Carbon::parse($service_data['fecha_fin']);
        $date_end_with_format = $date_end->isoFormat('LLLL');
        $service_data['date_2'] = $date_end_with_format;


        // $service->update($service_data);
        Actividad::where('id','=',$id)->update($service_data);

        return redirect()->route('actividades.index')->with('success', 'Registro editado correctamente');
    
    }

    // Función para eliminar un servicio
    public function destroy($id)
    {
        try{
            $actividad_select = Actividad::find($id);
            $actividad_select->delete();
            return redirect()->route('actividades.index')->with('success', 'Registro eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('actividades.index')->with('error',$e->getMessage());
        }
    }

    // Función asíncrona para obtener los datos de la base de datos de los servicios
    public function actividadesDatatables()
    {

        $dataActividad = Actividad::with('area','user')->orderBy('created_at','asc');
        $dataActividadPrestador = Actividad::with('area','user')->where('usuario_id', Auth::user()->id);

        if(Auth::user()->rol=="Administrador"){
            return FacadesDataTables::eloquent($dataActividad)
                                    ->addColumn('area', function (Actividad $actividad) {
                                        return $actividad->area->nombre;
                                    })
                                    ->addColumn('user', function (Actividad $actividad) {
                                        return $actividad->user->name;
                                    })
                                    ->addColumn('btn', 'actividades.actions')
                                    ->rawColumns(['btn'])
                                    ->toJson();
        }
        elseif (Auth::user()->rol=="Prestador"){
            return FacadesDataTables::eloquent($dataActividadPrestador)
                                    ->addColumn('area', function (Actividad $actividad) {
                                        return $actividad->area->nombre;
                                    })
                                    ->addColumn('user', function (Actividad $actividad) {
                                        return $actividad->user->name;
                                    })
                                    ->addColumn('btn', 'actividades.actions')
                                    ->rawColumns(['btn'])
                                    ->toJson();
        }
    }

    // Vista para mostrar la consulta
    public function vistaConsulta()
    {
        $mensaje = '';
        $actividades = Actividad::all();
        $actividadesCount = Actividad::count();
        return view('actividades.consulta', compact('actividades','actividadesCount','mensaje'));
    }

    // Función para generar las consultas por mes y año
    public function consulta(Request $request)
    {
        // Obteniendo mes y año del request
        $mes = $request->mes;
        $ano = $request->ano;

        $actividades = Actividad::whereMonth('fecha_inicio', $mes)
                                ->whereYear('fecha_inicio', $ano)
                                ->get();

        $actividadesCount = Actividad::whereMonth('fecha_inicio', $mes)
                                    ->whereYear('fecha_inicio', $ano)
                                    ->count();

        // Asignando variables de sesión para el mes y año
        Session::put('mes', $mes);
        Session::put('ano', $ano);

        $mensaje = 'Búsqueda encontrada por mes: '.$mes.' y año: '.$ano;
        return view('actividades.consulta', compact('actividades','actividadesCount','mensaje'));
    }

    // Función para exportar datos de excel
    public function exportExcel()
    {
        return Excel::download(new ActividadesExport, 'actividades.xlsx');
    }
}
