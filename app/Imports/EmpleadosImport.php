<?php

namespace App\Imports;

use App\Models\Empleado;
use Maatwebsite\Excel\Concerns\ToModel;

class EmpleadosImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Empleado([
            'nombre'    => $row[0],
            'activo'    => $row[1],
            'sexo'      => $row[2], 
            'area_id'   => $row[3],
        ]);
    }
}
