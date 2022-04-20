<?php

namespace App\Imports;

use App\Models\Catproducto;
use Maatwebsite\Excel\Concerns\ToModel;

class CatproductoImport implements ToModel
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

        return new Catproducto([
            'modulo' => $row[0],
            'nombre' => $row[1],
        ]);
    }
}
