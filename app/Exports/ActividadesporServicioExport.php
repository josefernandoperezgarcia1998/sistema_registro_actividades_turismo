<?php

namespace App\Exports;

use App\Models\Actividad;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithTitle;

class ActividadesporServicioExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $servicioSeleccionado = Session::get('servicioSeleccionado');
        $mesServicioSeleccionado = Session::get('mesServicioSeleccionado');
        $anoServicioSeleccionado = Session::get('anoServicioSeleccionado');

        // Si el mes y el año está definido y no es null
        // Entra al if para vacíar los datos de la sesión
        // Y para retornar la colección
        if(isset($servicioSeleccionado) && isset($mesServicioSeleccionado) && isset($anoServicioSeleccionado))
        {
            // Eliminando las variables de sesion mes y ano
            // session()->forget('servicioSeleccionado');
            // session()->forget('mesServicioSeleccionado');
            // session()->forget('anoServicioSeleccionado');

            return Actividad::where('servicio_id', $servicioSeleccionado)
                            ->whereMonth('fecha_inicio', $mesServicioSeleccionado)
                            ->whereYear('fecha_inicio', $anoServicioSeleccionado)
                            ->with('servicio')
                            ->get();

        }
        // Si no entra a la condición retorna esta colección para descargar en el excel
        return Actividad::all();

    }

    // Encabezados del excel
    public function headings(): array
    {

        return [
            'SERVICIO',
            'DESCRIPCIÓN',
            'FECHA',
        ];
    }

    // Recorrido del arreglo del modelo Buzon
    public function map($actividad) : array {
        return [
            $actividad->servicio->nombre,
            $actividad->descripcion,
            $actividad->fecha_inicio,
        ] ;
    }

    // Estilo para agregarle un color al encabezado
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:C1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('9DD5FA');
            },
        ];
    }

    public function title(): string
    {
        if(Session::get('mesServicioSeleccionado') == 1){
            return 'Actividades del mes: Enero '.Session::get('anoServicioSeleccionado');
        } elseif (Session::get('mesServicioSeleccionado') == 2) {
            return 'Actividades del mes: Febrero '.Session::get('anoServicioSeleccionado');
        } elseif (Session::get('mesServicioSeleccionado') == 3) {
            return 'Actividades del mes: Marzo '.Session::get('anoServicioSeleccionado');
        } elseif (Session::get('mesServicioSeleccionado') == 4) {
            return 'Actividades del mes: Abril '.Session::get('anoServicioSeleccionado');
        } elseif (Session::get('mesServicioSeleccionado') == 5) {
            return 'Actividades del mes: Mayo '.Session::get('anoServicioSeleccionado');
        } elseif (Session::get('mesServicioSeleccionado') == 6) {
            return 'Actividades del mes: Junio '.Session::get('anoServicioSeleccionado');
        } elseif (Session::get('mesServicioSeleccionado') == 7) {
            return 'Actividades del mes: Julio '.Session::get('anoServicioSeleccionado');
        } elseif (Session::get('mesServicioSeleccionado') == 8) {
            return 'Actividades del mes: Agosto '.Session::get('anoServicioSeleccionado');
        } elseif (Session::get('mesServicioSeleccionado') == 9) {
            return 'Actividades del mes: Septiembre '.Session::get('anoServicioSeleccionado');
        } elseif (Session::get('mesServicioSeleccionado') == 10) {
            return 'Actividades del mes: Octubre '.Session::get('anoServicioSeleccionado');
        } elseif (Session::get('mesServicioSeleccionado') == 11) {
            return 'Actividades del mes: Noviembre '.Session::get('anoServicioSeleccionado');
        } elseif (Session::get('mesServicioSeleccionado') == 12) {
            return 'Actividades del mes: Diciembre '.Session::get('anoServicioSeleccionado');
        } else{
            return 'no valido';
        }
    }
}
