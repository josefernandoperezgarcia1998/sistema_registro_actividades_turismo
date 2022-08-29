<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AutenticarController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\UsuarioController;
use App\Models\Empleado;
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

// Ruta recurso para crud empleados
Route::resource('empleados', EmpleadoController::class)->names('empleados')->middleware('admin');
// Ruta con ajax para obtener toda la data de usuarios con datatables
Route::get('empleados-data', [EmpleadoController::class, 'empleadosDatatables'])->name('empleados-data');

// Ruta para la interfaz de la consulta
Route::get('acividades/consultas', [ActividadController::class, 'vistaConsulta'])->name('actividades.vista-consulta');

// Ruta para generar las consultas
Route::post('consulta', [ActividadController::class, 'consulta'])->name('actividades.consulta');

// Ruta para exportar el excel con los datos
Route::get('exportar-excel', [ActividadController::class, 'exportExcel'])->name('actividades.excel');

Route::get('sesiones', function(){

    session()->forget('mes');
    session()->forget('ano');
    session()->forget('mes_seleccionado');
    session()->forget('ano_seleccionado');
    session()->forget('servicioSeleccionado');
    session()->forget('mesServicioSeleccionado');
    session()->forget('anoServicioSeleccionado');
});

// Ruta para ajax - buscar un área con select2 
Route::get('area-search', [ActividadController::class, 'areaSearch'])->name('actividades.areaSearch');

// Ruta para ajax - buscar un empleado con select2 
Route::get('empleado-search', [EmpleadoController::class, 'empleadoSearch'])->name('empleados.empleadoSearch');

// Ruta para ajax - buscar un servicio con select2
Route::get('servicio-search', [ActividadController::class, 'servicioSearch'])->name('actividades.servicioSearch');

// Ruta para la interfaz de la consulta por catalogo de servicios
Route::get('acividades/consultas-por-servicios-todos', [ActividadController::class, 'vistaConsultaPorServiciosTodo'])->name('actividades.vista-consulta-por-servicios-todos');

// Ruta para generar las consultas
Route::post('consulta-por-servicios-todos', [ActividadController::class, 'consultaPorServiciosTodo'])->name('actividades.consulta-por-servicios-todos');

// Ruta para exportar el excel con los datos
Route::get('exportar-excel-por-servicios-todos', [ActividadController::class, 'exportExcelPorServiciosTodo'])->name('actividades.consulta-excel-por-servicios-todos');


// Ruta para la interfaz de la consulta por catalogo de servicios
Route::get('acividades/consultas-por-servicios-unico-servicio', [ActividadController::class, 'vistaConsultaPorServiciosUnicoServicio'])->name('actividades.vista-consulta-por-unico-servicio');

// Ruta para generar las consultas
Route::post('consulta-por-servicios-unico-servicio', [ActividadController::class, 'consultaPorServiciosUnicoServicio'])->name('actividades.consulta-por-unico-servicio');

// Ruta para exportar el excel con los datos
Route::get('exportar-excel-por-servicios-unico-servicio', [ActividadController::class, 'exportExcelPorServiciosUnicoServicio'])->name('actividades.consulta-excel-por-unico-servicio');

Route::post('import-list-excel', [EmpleadoController::class, 'importExcel'])->name('empleados.import.excel');
Route::post('import-lista-excel', [EmpleadoController::class, 'importExcelA'])->name('areas.import.excel');

// Ruta para ajax - obtener el area de un empleado con select2 e imprima en un input 
Route::post('empleado-area-search', [EmpleadoController::class, 'empleadoAreaSearch'])->name('empleados.empleadoAreaSearch');

//Ruta para la vista de cambiar contraseña
Route::get('/change-password', [UsuarioController::class, 'changePassword'])->name('change-password');

// Ruta para restablecer la contraseña
Route::post('/change-password', [UsuarioController::class, 'updatePassword'])->name('update-password');

