<?php

namespace App\Imports;

use App\Models\Catembarque;
use Maatwebsite\Excel\Concerns\ToModel;

class CatembarqueImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] === 'Modulo'){
            return null;
        }

        return new Catembarque([
            'modulo' => $row[0],
            'nombre' => $row[1],
        ]);
    }
}
