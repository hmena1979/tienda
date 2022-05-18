<?php

namespace App\Imports;

use App\Models\Embarcacion;
use Maatwebsite\Excel\Concerns\ToModel;

class EmbarcacionImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] == 'Nombre'){
            return null;
        }
        return new Embarcacion([
            'empresa_id' => 1,
            'nombre' => $row[0],
            'matricula' => $row[2],
            'protocolo' => $row[3],
            'capacidad' => $row[1],
        ]);
    }
}
