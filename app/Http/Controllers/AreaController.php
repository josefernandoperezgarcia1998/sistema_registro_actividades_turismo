<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        return view('areas.index');
    }

    public function create()
    {
        return view('areas.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validated = $request->validate([
            'nombre'  => 'required',
            'estado'  => 'required',
        ]);

        Area::create($data);

        return redirect()->route('areas.index')->with('success', 'Area creada correctamente');
    }

    public function show($id)
    {
        $area = Area::findOrFail($id);

        return view('areas.show', compact('area'));
    }

    public function update(Request $request,$id)
    {
        $valores = $request->all();

        $validated = $request->validate([
            'nombre'  => 'required',
            'estado'  => 'required',
        ]);

        $area = Area::find($id);
        $area->fill($valores);
        $area->save();

        return redirect()->route('areas.show', $id)->with('success','Area actualizada correctamente');
    }

    public function destroy($id)
    {
        try{
            $area_seleccionado = Area::findOrFail($id);
            $area_seleccionado->delete();
            return redirect()->route('areas.index')->with('success', 'Area eliminada correctamente');
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('areas.index')->with('error',$e->getMessage());
        }
    }

    public function areasDatatables()
    {
        return datatables()
                ->eloquent(\App\Models\Area::orderBy('nombre', 'asc'))
                ->addColumn('btn', 'areas.actions')
                ->rawColumns(['btn'])
                ->toJson();
    }

}
