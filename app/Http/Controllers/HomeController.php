<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Area;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $actividadCount = Actividad::count();

        $actividadCountPrestador = Actividad::where('usuario_id',Auth::user()->id)->count();

        $catServicioCount = Servicio::count();

        $userCount = User::count();
        
        $areasCount = Area::count();

        return view('dashboard', compact('actividadCount', 'userCount', 'catServicioCount', 'areasCount','actividadCountPrestador'));
    }
}
