<?php

namespace App\Imports;

use App\Models\Empacopiadora;
use Maatwebsite\Excel\Concerns\ToModel;

class EmpacopiadoraImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] == 'Empresa'){
            return null;
        }

        return new Empacopiadora([
            'empresa_id' => 1,
            'nombre' => $row[0]
        ]);
    }
}
