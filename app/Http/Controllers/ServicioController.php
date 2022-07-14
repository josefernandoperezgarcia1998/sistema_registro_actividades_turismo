<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        return view('catalogo-servicios.index');
    }

    public function create()
    {
        return view('catalogo-servicios.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();


        $validated = $request->validate([
            'nombre'  => 'required',
            'estado'  => 'required',
        ]);

        Servicio::create($data);

        return redirect()->route('catalogo-servicios.index')->with('success', 'Servicio creado correctamente');
    }

    public function show($id)
    {
        $servicio = Servicio::findOrFail($id);

        return view('catalogo-servicios.show', compact('servicio'));
    }

    public function update(Request $request,$id)
    {
        $valores = $request->all();

        $validated = $request->validate([
            'nombre'  => 'required',
            'estado'  => 'required',
        ]);

        $servicio = Servicio::find($id);
        $servicio->fill($valores);
        $servicio->save();

        return redirect()->route('catalogo-servicios.show', $id)->with('success','Servicio actualizado correctamente');
    }

    public function destroy($id)
    {
        try{
            $servicio_seleccionado = Servicio::findOrFail($id);
            $servicio_seleccionado->delete();
            return redirect()->route('catalogo-servicios.index')->with('success', 'Servicio eliminada correctamente');
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('catalogo-servicios.index')->with('error',$e->getMessage());
        }
    }

    public function catServiciosDatatables()
    {
        return datatables()
                ->eloquent(\App\Models\Servicio::orderBy('id', 'asc'))
                ->addColumn('btn', 'catalogo-servicios.actions')
                ->rawColumns(['btn'])
                ->toJson();
    }
}
