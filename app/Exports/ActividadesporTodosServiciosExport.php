<?php

namespace App\Exports;

use App\Models\Actividad;
use App\Models\Servicio;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\DB;

class ActividadesporTodosServiciosExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize, WithTitle 
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {

            // Si el mes y el año está definido y no es null
            // Entra al if para vacíar los datos de la sesión
            // Y para retornar la colección

            $mesSelec = Session::get('mes_seleccionado');
            $anoSelec = Session::get('ano_seleccionado');

            if(isset($mesSelec) && isset($anoSelec))
            {

                // Eliminando las variables de sesion mes y ano
                // session()->forget('mes_seleccionado');
                // session()->forget('ano_seleccionado');

                return Actividad::with('servicio')
                                ->whereMonth('fecha_inicio', $mesSelec)
                                ->whereYear('fecha_inicio', $anoSelec)
                                ->orderBy('servicio_id','asc')
                                ->get();
            }
            return Actividad::with('servicio')
                            ->orderBy('servicio_id','asc')
                            ->get();
    }

    // Encabezados del excel
    public function headings(): array
    {

        return [
            'DESCRIPCION',
            'SERVICIO',
            '',
            '',
            'MANTENIMIENTO',
            'PÁGINA WEB',
            'ASESORÍA',
            'SISTEMAS',
            'SERVICIO',
        ];
    }
    // Recorrido del arreglo del modelo Actividades
    public function map($actividad) : array {
        $nombre = [];
        $descripcion = [];
        foreach($actividad as $activity){
            // dump($actividad);
            $nombre[]=$actividad->descripcion;
            foreach($actividad->servicio as $key => $servicio){
                $descripcion = $actividad->servicio->nombre;
            }
        }
        return [
            [
                $nombre[0],
                $descripcion,
                '',
                '',
            ],
        ];
    }

    // Estilo para agregarle un color al encabezado y setear valores a ciertas celdas
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                
                $event->sheet->setCellValue('E2', '=COUNTIF(B2:B300, "Mantenimiento")');
                
                $event->sheet->setCellValue('F2', '=COUNTIF(B2:B300, "Página web")');
                
                $event->sheet->setCellValue('G2', '=COUNTIF(B2:B300, "Asesoría")');
                
                $event->sheet->setCellValue('H2', '=COUNTIF(B2:B300, "Sistemas")');
                
                $event->sheet->setCellValue('I2', '=COUNTIF(B2:B300, "Servicio")');
                
                $event->sheet->setCellValue('K1', 'SERVICIOS');
                
                // Obtener el conteo de los hombres y mujeres por actividades
                $servicios = Servicio::where('estado', 'Si')
                                    ->select('id','nombre')
                                    ->get();

                foreach ($servicios as $key => $servicio) {
                    $contador = $key+2;
                    $event->sheet->setCellValue('K'.$contador, $servicio->nombre);
                }

                $event->sheet->setCellValue('L1', 'MUJER');
                $event->sheet->setCellValue('M1', 'HOMBRE');

                $mesSelec = Session::get('mes_seleccionado');

                if(Session::get('mes_seleccionado') == 1){
                    $event->sheet->setCellValue('E8', 'ENERO');
                } elseif (Session::get('mes_seleccionado') == 2) {
                    $event->sheet->setCellValue('E8', 'FEBRERO');
                } elseif (Session::get('mes_seleccionado') == 3) {
                    $event->sheet->setCellValue('E8', 'MARZO');
                } elseif (Session::get('mes_seleccionado') == 4) {
                    $event->sheet->setCellValue('E8', 'ABRIL');
                } elseif (Session::get('mes_seleccionado') == 5) {
                    $event->sheet->setCellValue('E8', 'MAYO');
                } elseif (Session::get('mes_seleccionado') == 6) {
                    $event->sheet->setCellValue('E8', 'JUNIO');
                } elseif (Session::get('mes_seleccionado') == 7) {
                    $event->sheet->setCellValue('E8', 'JULIO');
                } elseif (Session::get('mes_seleccionado') == 8) {
                    $event->sheet->setCellValue('E8', 'AGOSTO');
                } elseif (Session::get('mes_seleccionado') == 9) {
                    $event->sheet->setCellValue('E8', 'SEPTIEMBRE');
                } elseif (Session::get('mes_seleccionado') == 10) {
                    $event->sheet->setCellValue('E8', 'OCTUBRE');
                } elseif (Session::get('mes_seleccionado') == 11) {
                    $event->sheet->setCellValue('E8', 'NOVIEMBRE');
                } elseif (Session::get('mes_seleccionado') == 12) {
                    $event->sheet->setCellValue('E8', 'DICIEMBRE');
                } else{
                    $event->sheet->setCellValue('E8', 'REGISTRO GENERAL SIN MES');
                }

                $arregloServiciosMujer = [];
                $arregloServiciosHombre = [];
                foreach ($servicios as $key => $servicio) {
                    $mujer = DB::table('empleados')
                                    ->join('actividades', 'empleados.id', '=', 'actividades.empleado_id')
                                    ->where('actividades.servicio_id', $servicio->id)
                                    ->whereMonth('actividades.fecha_inicio', Session::get('mes_seleccionado'))
                                    ->where('empleados.sexo','Mujer')
                                    ->select('empleados.id as empleadoId','empleados.nombre as empleadoNombre','empleados.sexo as empleadoSexo','actividades.*')
                                    ->get();
                    
                    $hombre = DB::table('empleados')
                                    ->join('actividades', 'empleados.id', '=', 'actividades.empleado_id')
                                    ->where('actividades.servicio_id', $servicio->id)
                                    ->whereMonth('actividades.fecha_inicio', Session::get('mes_seleccionado'))
                                    ->where('empleados.sexo','hombre')
                                    ->select('empleados.id as empleadoId','empleados.nombre as empleadoNombre','empleados.sexo as empleadoSexo','actividades.*')
                                    ->get();

                    $arregloServiciosMujer[] = $mujer->count();
                    $arregloServiciosHombre[] = $hombre->count();
                }

                foreach ($arregloServiciosMujer as $key => $servicioMujer) {
                    $contador = $key+2;
                    $event->sheet->setCellValue('L'.$contador, $servicioMujer);
                }

                foreach ($arregloServiciosHombre as $key => $servicioHombre) {
                    $contador = $key+2;
                    $event->sheet->setCellValue('M'.$contador, $servicioHombre);
                }

                $event->sheet->getDelegate()->getStyle('E8')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('FCF403');

                $event->sheet->getDelegate()->getStyle('A1:B1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('9DD5FA');

                $event->sheet->getDelegate()->getStyle('E1:I1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('9DD5FA');

                $event->sheet->getDelegate()->getStyle('K1:M1')
                        ->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB('9DD5FA');
                
                // Eliminando las variables de sesion mes y ano
                // session()->forget('mes_seleccionado');
                // session()->forget('ano_seleccionado');
            }
        ];
    }

    public function title(): string
    {
        if(Session::get('mes_seleccionado') == 1){
            return 'Actividades del mes: Enero '.Session::get('ano_seleccionado');
        } elseif (Session::get('mes_seleccionado') == 2) {
            return 'Actividades del mes: Febrero '.Session::get('ano_seleccionado');
        } elseif (Session::get('mes_seleccionado') == 3) {
            return 'Actividades del mes: Marzo '.Session::get('ano_seleccionado');
        } elseif (Session::get('mes_seleccionado') == 4) {
            return 'Actividades del mes: Abril '.Session::get('ano_seleccionado');
        } elseif (Session::get('mes_seleccionado') == 5) {
            return 'Actividades del mes: Mayo '.Session::get('ano_seleccionado');
        } elseif (Session::get('mes_seleccionado') == 6) {
            return 'Actividades del mes: Junio '.Session::get('ano_seleccionado');
        } elseif (Session::get('mes_seleccionado') == 7) {
            return 'Actividades del mes: Julio '.Session::get('ano_seleccionado');
        } elseif (Session::get('mes_seleccionado') == 8) {
            return 'Actividades del mes: Agosto '.Session::get('ano_seleccionado');
        } elseif (Session::get('mes_seleccionado') == 9) {
            return 'Actividades del mes: Septiembre '.Session::get('ano_seleccionado');
        } elseif (Session::get('mes_seleccionado') == 10) {
            return 'Actividades del mes: Octubre '.Session::get('ano_seleccionado');
        } elseif (Session::get('mes_seleccionado') == 11) {
            return 'Actividades del mes: Noviembre '.Session::get('ano_seleccionado');
        } elseif (Session::get('mes_seleccionado') == 12) {
            return 'Actividades del mes: Diciembre '.Session::get('ano_seleccionado');
        } else{
            return 'no valido';
        }
    }

}
