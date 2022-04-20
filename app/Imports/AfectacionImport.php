<?php

namespace App\Imports;

use App\Models\Afectacion;
use Maatwebsite\Excel\Concerns\ToModel;

class AfectacionImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] === 'codigo'){
            return null;
        }

        return new Afectacion([
            'codigo' => $row[0],
            'nombre' => $row[1],
        ]);
    }
}
