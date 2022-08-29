<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActividadesExport;
use App\Exports\ActividadesporServicioExport;
use App\Exports\ActividadesporTodosServiciosExport;
use App\Models\Area;
use App\Models\Servicio;
use Illuminate\Support\Facades\Session;
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
        
        $empleados = DB::table('empleados')
                    ->where('estado','Si')
                    ->orderBy('nombre','asc')
                    ->get();

        $areas = DB::table('areas')
                    ->where('estado','Si')
                    ->orderBy('nombre','asc')
                    ->get();

        $servicios = DB::table('servicios')
                        ->orderBy('nombre','asc')
                        ->get();

        return view('actividades.create', compact('users','areas', 'servicios', 'empleados'));
    }

    // Función para crear un servicio
    public function store(Request $request)
    {
        $service = $request->all();

        $validated = $request->validate([
            'empleado_id'     => 'required',
            'area_nombre'       => 'required',
            'servicio_id'       => 'required',
            'descripcion'       => 'required',
            'fecha_inicio'      => 'required',
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

        $service['folio'] =  $service['contador'] .'-'. $letrasNombre .'-'. $mes_creacion;

        if($mes_creacion == $mes_actual){
            $order = 1;
            $records = Actividad::whereMonth('fecha_inicio', $mes_creacion)->get();
    
            foreach($records as $row) {
                $row->contador = $order;
                $row->update();
                $order++;
            }
    
            $service['contador'] = $order;
            $service['folio'] =  $service['contador'] .'-'. $letrasNombre .'-'. $mes_creacion;
        } elseif(!($mes_creacion == $mes_actual)) {
            $order = 1;
            $records = Actividad::whereMonth('fecha_inicio', $mes_creacion)->get();
    
            foreach($records as $row) {
                $row->contador = $order;
                $row->update();
                $order++;
            }

            $service['contador'] = $order;

            $service['folio'] =  $service['contador'] .'-'. $letrasNombre .'-'. $mes_creacion;

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
            'empleado_id' => 'required',
            'area_nombre'       => 'required',
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

        $dataActividad = Actividad::with('empleado','servicio','user')->orderBy('fecha_inicio','desc');
        $dataActividadPrestador = Actividad::with('empleado','servicio','user')->where('usuario_id', Auth::user()->id)->orderBy('fecha_inicio','desc');

        if(Auth::user()->rol=="Administrador"){
            return FacadesDataTables::eloquent($dataActividad)
                                    ->addColumn('empleado', function (Actividad $actividad) {
                                        return $actividad->empleado->nombre;
                                    })
                                    ->addColumn('user', function (Actividad $actividad) {
                                        return $actividad->user->name;
                                    })
                                    ->addColumn('servicio', function (Actividad $actividad) {
                                        return $actividad->servicio->nombre;
                                    })
                                    ->addColumn('btn', 'actividades.actions')
                                    ->rawColumns(['btn'])
                                    ->toJson();
        }
        elseif (Auth::user()->rol=="Prestador"){
            return FacadesDataTables::eloquent($dataActividadPrestador)
                                    ->addColumn('empleado', function (Actividad $actividad) {
                                        return $actividad->empleado->nombre;
                                    })
                                    ->addColumn('user', function (Actividad $actividad) {
                                        return $actividad->user->name;
                                    })
                                    ->addColumn('servicio', function (Actividad $actividad) {
                                        return $actividad->servicio->nombre;
                                    })
                                    ->addColumn('btn', 'actividades.actions')
                                    ->rawColumns(['btn'])
                                    ->toJson();
        }
    }

    // Vista para mostrar la consulta de registro general ✔ 👍
    public function vistaConsulta()
    {
        if(Auth::user()->rol=="Administrador"){
            $mensaje = '';
            $actividades = Actividad::all();
            $actividadesCount = Actividad::count();
            
            return view('actividades.consulta', compact('actividades','actividadesCount','mensaje'));
        }
        elseif (Auth::user()->rol=="Prestador"){
            $mensaje = '';
            $actividades = Actividad::where('usuario_id', Auth::user()->id)->get();
            $actividadesCount = Actividad::where('usuario_id', Auth::user()->id)->count();
            
            return view('actividades.consulta', compact('actividades','actividadesCount','mensaje'));
        }
    }

    // Función para generar las consultas de registro general por mes y año ✔ 👍
    public function consulta(Request $request)
    {
        if(Auth::user()->rol=="Administrador"){
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
        } elseif (Auth::user()->rol=="Prestador"){
            // Obteniendo mes y año del request
            $mes = $request->mes;
            $ano = $request->ano;

            $actividades = Actividad::whereMonth('fecha_inicio', $mes)
                                    ->whereYear('fecha_inicio', $ano)
                                    ->where('usuario_id', Auth::user()->id)
                                    ->get();

            $actividadesCount = Actividad::whereMonth('fecha_inicio', $mes)
                                        ->whereYear('fecha_inicio', $ano)
                                        ->where('usuario_id', Auth::user()->id)
                                        ->count();

            // Asignando variables de sesión para el mes y año
            Session::put('mes', $mes);
            Session::put('ano', $ano);

            $mensaje = 'Búsqueda encontrada por mes: '.$mes.' y año: '.$ano;
            return view('actividades.consulta', compact('actividades','actividadesCount','mensaje'));
        }
    }

    // Función para exportar datos de registro general de excel 👍
    public function exportExcel()
    {
        return Excel::download(new ActividadesExport, 'actividades-generales.xlsx');
    }

    // Función asincrona para enviar información a la vista de las areas (SELECT2)
    public function areaSearch(Request $request)
    {
        $data = Area::where('estado','Si')->get();

        if($request->filled('q')){
            $data = Area::select("nombre", "id")
                        ->where('estado','Si')
                        ->where('nombre', 'LIKE', '%'. $request->get('q'). '%')
                        ->get();
        }
    
        return response()->json($data);
    }

    // Función asincrona para enviar información a la vista de los servicios (SELECT2)
    public function servicioSearch(Request $request)
    {
        $data = Servicio::where('estado','Si')->get();

        if($request->filled('q')){
            $data = Servicio::select("nombre", "id")
                        ->where('estado','Si')
                        ->where('nombre', 'LIKE', '%'. $request->get('q'). '%')
                        ->get();
        }
    
        return response()->json($data);
    }

    // Función para la vista de consultar por todos los servicios👍👍
    public function vistaConsultaPorServiciosTodo()
    {
        $mensaje = '';
    
        $actividades = Actividad::with('servicio')
                                ->orderBy('servicio_id','asc')
                                ->get();
    
    
        $actividadesCount = Actividad::with('servicio')
                                    ->orderBy('servicio_id','asc')
                                    ->count();
        
        return view('actividades.consulta-por-servicios', compact('actividades','actividadesCount','mensaje'));
    }
    
    // Función para hacer la consulta por todos los servicios 👍👍
    public function consultaPorServiciosTodo(Request $request)
    {
        $mesSeleccionado = $request->mes;
        $anoSeleccionado = $request->ano;

        Session::put('mes_seleccionado', $mesSeleccionado);
        Session::put('ano_seleccionado', $anoSeleccionado);

        $actividades = Actividad::with('servicio')
                                ->whereMonth('fecha_inicio', $mesSeleccionado)
                                ->whereYear('fecha_inicio', $anoSeleccionado)
                                ->orderBy('servicio_id','asc')
                                ->get();
                                
        $actividadesCount = Actividad::with('servicio')
                                    ->whereMonth('fecha_inicio', $mesSeleccionado)
                                    ->whereYear('fecha_inicio', $anoSeleccionado)
                                    ->orderBy('servicio_id','asc')
                                    ->count();
                                
        $mensaje = 'Se encontraron los siguiente resgistros';
        return view('actividades.consulta-por-servicios', compact('actividades','actividadesCount','mensaje'));
    }
    
    // Función para poder exportar a excel por todos los servicios 👍👍
    public function exportExcelPorServiciosTodo()
    {
        return Excel::download(new ActividadesporTodosServiciosExport, 'actividades-por-todos-servicio.xlsx');
    }

    // Función para la vista de consultar por todos los servicios 👍👍👍
    public function vistaConsultaPorServiciosUnicoServicio()
    {
        $mensaje = '';
    
        $actividades = Actividad::with('servicio')
                                ->orderBy('servicio_id','asc')
                                ->get();
    
    
        $actividadesCount = Actividad::with('servicio')
                                    ->orderBy('servicio_id','asc')
                                    ->count();

        $servicios = DB::table('servicios')
                        ->orderBy('nombre','asc')
                        ->where('estado','Si')
                        ->get();
            
        
        return view('actividades.consulta-por-servicio-unico', compact('actividades','actividadesCount','mensaje', 'servicios'));
    }
    
    // Función para hacer la consulta por todos los servicios 👍👍👍
    public function consultaPorServiciosUnicoServicio(Request $request)
    {



        $servicioSelect = $request->servicio_id;
        $mesSelect = $request->mes;
        $anoSelect = $request->ano;

        Session::put('servicioSeleccionado', $servicioSelect);
        Session::put('mesServicioSeleccionado', $mesSelect);
        Session::put('anoServicioSeleccionado', $anoSelect);

        $actividades = Actividad::with('servicio')
                                ->where('servicio_id', $servicioSelect)
                                ->whereMonth('fecha_inicio', $mesSelect)
                                ->whereYear('fecha_inicio', $anoSelect)
                                ->orderBy('servicio_id','asc')
                                ->get();
                                
        $actividadesCount = Actividad::with('servicio')
                                    ->where('servicio_id', $servicioSelect)
                                    ->whereMonth('fecha_inicio', $mesSelect)
                                    ->whereYear('fecha_inicio', $anoSelect)
                                    ->orderBy('servicio_id','asc')
                                    ->count();

        $servicios = DB::table('servicios')
                        ->orderBy('nombre','asc')
                        ->where('estado','Si')
                        ->get();
        
        // Obteniendo el nombre del servicio
        $servicioNombre = DB::table('servicios')
                            ->where('id', $servicioSelect)
                            ->select('servicios.nombre')
                            ->get();
        
        // Obteniendo el nombre del servicio
        $servicioNom = '';
        foreach($servicioNombre as $servicio){
            $servicioNom = $servicio->nombre;
        }
                                
        $mensaje = 'Se encontraron los siguiente resgistros del servicio: '. $servicioNom .' con mes: '.$mesSelect.' y año '.$anoSelect;
        return view('actividades.consulta-por-servicio-unico', compact('actividades','actividadesCount','mensaje', 'servicios'));
    }
    
    // Función para poder exportar a excel por todos los servicios 👍👍👍
    public function exportExcelPorServiciosUnicoServicio()
    {
        return Excel::download(new ActividadesporServicioExport, 'actividades-por-servicio.xlsx');
    }

}
