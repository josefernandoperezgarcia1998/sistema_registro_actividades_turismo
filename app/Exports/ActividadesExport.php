<?php

namespace App\Exports;

use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithTitle;

class ActividadesExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize, WithTitle 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        if(Auth::user()->rol=="Administrador"){
            // Obteniendo los datos de la sesión
            $mes = Session::get('mes');
            $ano = Session::get('ano');

            // Si el mes y el año está definido y no es null
            // Entra al if para vacíar los datos de la sesión
            // Y para retornar la colección
            if(isset($mes) && isset($ano))
            {

                // Eliminando las variables de sesion mes y ano
                session()->forget('mes');
                session()->forget('ano');

                return Actividad::whereMonth('fecha_inicio', $mes)
                                ->whereYear('fecha_inicio', $ano)
                                ->with('empleado','user')
                                ->get();

            }
            // Si no entra a la condición retorna esta colección para descargar en el excel
            return Actividad::all();
        } elseif (Auth::user()->rol=="Prestador"){
            // Obteniendo los datos de la sesión
            $mes = Session::get('mes');
            $ano = Session::get('ano');

            // Si el mes y el año está definido y no es null
            // Entra al if para vacíar los datos de la sesión
            // Y para retornar la colección
            if(isset($mes) && isset($ano))
            {

                // Eliminando las variables de sesion mes y ano
                session()->forget('mes');
                session()->forget('ano');

                return Actividad::whereMonth('fecha_inicio', $mes)
                                ->whereYear('fecha_inicio', $ano)
                                ->with('empleado','user')
                                ->where('usuario_id',Auth::user()->id)
                                ->get();

            }
            // Si no entra a la condición retorna esta colección para descargar en el excel
            return Actividad::where('usuario_id',Auth::user()->id)->get();
        }
    }

    // Encabezados del excel
    public function headings(): array
    {

        return [
            'FOLIO',
            'FECHA DE INICIO',
            'QUIÉN REPORTA',
            'ÁREA / ÓRGANO ADMINISTRATIVO',
            'TIPO DE SERVICIO',
            'DESCRIPCIÓN DEL SERVICIO / OBSERVACIONES',
            'FECHA FINALIZACIÓN',
            'REALIZADO POR',
            'SEXO',
        ];
    }

    // Recorrido del arreglo del modelo Buzon
    public function map($actividad) : array {
        return [
            $actividad->folio,
            $actividad->fecha_inicio,
            $actividad->empleado->nombre,
            $actividad->area_nombre,
            $actividad->servicio->nombre,
            $actividad->descripcion,
            $actividad->fecha_fin,
            $actividad->user->name,
            $actividad->empleado->sexo,
        ] ;
    }

    // Estilo para agregarle un color al encabezado
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:I1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('9DD5FA');
            },
        ];
    }

    public function title(): string
    {
        if(Session::get('mes') == 1){
            return 'Actividades del mes: Enero '.Session::get('ano');
        } elseif (Session::get('mes') == 2) {
            return 'Actividades del mes: Febrero '.Session::get('ano');
        } elseif (Session::get('mes') == 3) {
            return 'Actividades del mes: Marzo '.Session::get('ano');
        } elseif (Session::get('mes') == 4) {
            return 'Actividades del mes: Abril '.Session::get('ano');
        } elseif (Session::get('mes') == 5) {
            return 'Actividades del mes: Mayo '.Session::get('ano');
        } elseif (Session::get('mes') == 6) {
            return 'Actividades del mes: Junio '.Session::get('ano');
        } elseif (Session::get('mes') == 7) {
            return 'Actividades del mes: Julio '.Session::get('ano');
        } elseif (Session::get('mes') == 8) {
            return 'Actividades del mes: Agosto '.Session::get('ano');
        } elseif (Session::get('mes') == 9) {
            return 'Actividades del mes: Septiembre '.Session::get('ano');
        } elseif (Session::get('mes') == 10) {
            return 'Actividades del mes: Octubre '.Session::get('ano');
        } elseif (Session::get('mes') == 11) {
            return 'Actividades del mes: Noviembre '.Session::get('ano');
        } elseif (Session::get('mes') == 12) {
            return 'Actividades del mes: Diciembre '.Session::get('ano');
        } else{
            return 'Mes';
        }
    }
}
