<?php

namespace App\Imports;

use App\Models\Transportista;
use Maatwebsite\Excel\Concerns\ToModel;

class TransportistaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] == 'Ruc'){
            return null;
        }

        return new Transportista([
            'empresa_id' => 1,
            'ruc' => $row[0],
            'nombre' => $row[1]
        ]);
    }
}
