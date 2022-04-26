<?php

namespace App\Imports;

use App\Models\Ubigeo;
use Maatwebsite\Excel\Concerns\ToModel;

class UbigeoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[1] === 'Codigo'){
            return null;
        }

        return new Ubigeo([
            'provincia' => $row[0],
            'codigo' => $row[1],
            'nombre' => $row[2]
        ]);
    }
}
