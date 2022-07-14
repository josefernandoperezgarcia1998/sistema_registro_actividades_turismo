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

class ActividadesExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

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
                            ->with('area','user')
                            ->get();

        }
        // Si no entra a la condición retorna esta colección para descargar en el excel
        return Actividad::all();
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
        ];
    }

        // Recorrido del arreglo del modelo Buzon
        public function map($actividad) : array {
            return [
                $actividad->folio,
                $actividad->fecha_inicio,
                $actividad->quien_reporta,
                $actividad->area->nombre,
                $actividad->servicio->nombre,
                $actividad->descripcion,
                $actividad->fecha_fin,
                $actividad->user->name,
            ] ;
        }
    
        // Estilo para agregarle un color al encabezado
        public function registerEvents(): array
        {
            return [
                AfterSheet::class    => function(AfterSheet $event) {
                    $event->sheet->getDelegate()->getStyle('A1:H1')
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('9DD5FA');
                },
            ];
        }
}
