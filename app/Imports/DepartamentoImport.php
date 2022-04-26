<?php

namespace App\Imports;

use App\Models\Departamento;
use Maatwebsite\Excel\Concerns\ToModel;

class DepartamentoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] === 'Codigo'){
            return null;
        }

        return new Departamento([
            'codigo' => $row[0],
            'nombre' => $row[1]
        ]);
    }
}
