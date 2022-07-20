<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AutenticarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/inicio', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');


/* Rutas para iniciar sesión y cerrar sesión */
Route::get('iniciar-sesion', [AutenticarController::class, 'credenciales'])->name('login');
Route::post('validar', [AutenticarController::class, 'autenticar'])->name('validar');
Route::get('salir', [AutenticarController::class, 'salida'])->name('salir');

// Ruta recurso para crud users
Route::resource('areas', AreaController::class)->names('areas')->middleware('admin');
// Ruta con ajax para obtener la data de area
Route::get('areas-data', [AreaController::class, 'areasDatatables'])->name('areas-data');

// Ruta recurso para crud users
Route::resource('users', UsuarioController::class)->names('users')->middleware('admin');
// Ruta con ajax para obtener toda la data de usuarios con datatables
Route::get('users-data', [UsuarioController::class, 'usersDatatables'])->name('users-data');

// Ruta recurso para crud users
Route::resource('actividades', ActividadController::class)->names('actividades');
// Ruta con ajax para obtener toda la data de usuarios con datatables
Route::get('actividades-data', [ActividadController::class, 'actividadesDatatables'])->name('actividades-data');

// Ruta recurso para crud users
Route::resource('catalogo-servicios', ServicioController::class)->names('catalogo-servicios')->middleware('admin');
// Ruta con ajax para obtener toda la data de usuarios con datatables
Route::get('catalogo-servicios-data', [ServicioController::class, 'catServiciosDatatables'])->name('catalogo-servicios-data');

// Ruta para la interfaz de la consulta
Route::get('acividades/consultas', [ActividadController::class, 'vistaConsulta'])->name('actividades.vista-consulta');

// Ruta para generar las consultas
Route::post('consulta', [ActividadController::class, 'consulta'])->name('actividades.consulta');

// Ruta para exportar el excel con los datos
Route::get('exportar-excel', [ActividadController::class, 'exportExcel'])->name('actividades.excel');

Route::get('sesiones', function(){

    session()->forget('mes');
    session()->forget('ano');


});
