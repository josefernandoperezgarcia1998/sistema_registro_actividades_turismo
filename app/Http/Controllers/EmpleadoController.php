<?php

namespace App\Http\Controllers;

use App\Imports\AreasImport;
use App\Imports\EmpleadosImport;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;
use Input;

class EmpleadoController extends Controller
{

    public function index()
    {
        return view('empleado.index');
    }

    public function create()
    {
        return view('empleado.create');
    }

    public function store(Request $request)
    {
        $dataEmpleado = $request->all();
        $validated = $request->validate([
            'nombre'    => 'required',
            'area_id'   => 'required',
            'estado'    => 'required',
        ]);

        Empleado::create($dataEmpleado);

        return redirect()->route(('empleados.index'))->with('success','Empleado registrado correctamente');
    }

    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);

        return view('empleado.edit', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        $dataEmpleado = $request->all();
        $validated = $request->validate([
            'nombre'    => 'required',
            'area_id'   => 'required',
            'estado'    => 'required',
        ]);
    
        $registro = Empleado::find($id);
        $registro->fill($dataEmpleado);
        $registro->save();

        return redirect()->route(('empleados.index'))->with('success','Empleado registrado correctamente');
    }

    public function destroy($id)
    {
        try{
            $empleado = Empleado::findOrFail($id);
            $empleado->delete();
            return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente');
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('empleados.index')->with('error',$e->getMessage());
        }
    }

    // Función asincrona para enviar información a la vista de los empleados (SELECT2)
    public function empleadoSearch(Request $request)
    {
        $data = Empleado::where('estado','Si')->get();

        if($request->filled('q')){
            $data = Empleado::select("nombre", "id")
                        ->where('estado','Si')
                        ->where('nombre', 'LIKE', '%'. $request->get('q'). '%')
                        ->get();
        }
    
        return response()->json($data);
    }

    public function empleadoAreaSearch(Request $request)
    {
        if($request->get('id'))
        {
            $id = $request->get('id');

            $empleado = Empleado::find($id);
            $areaEmpleado = $empleado->area->nombre;

            return response()->json($areaEmpleado);
        }
    }

    public function empleadosDatatables()
    {
        $dataEmpleado = Empleado::with('area')->orderBy('created_at','asc');
        return FacadesDataTables::eloquent($dataEmpleado)
                                ->addColumn('area', function (Empleado $empleado) {
                                    return $empleado->area->nombre;
                                })
                                ->addColumn('btn', 'empleado.actions')
                                ->rawColumns(['btn'])
                                ->toJson();
    }

    public function importExcel(Request $request)
    {
        $file = $request->file('file');
        Excel::import(new EmpleadosImport, $file);

        return back()->with('message', 'Empleados Importado correctamente');
    }

    public function importExcelA(Request $request)
    {
        $file = $request->file('file');
        Excel::import(new AreasImport, $file);

        return back()->with('message', 'Area Importado correctamente ');
    }
}
