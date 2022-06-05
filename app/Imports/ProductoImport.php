<?php

namespace App\Imports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[0] === 'CODIGO'){
            return null;
        }

        return new Producto([
            'tipoproducto_id' => $row[3],
            'nombre' => $row[2],
            'umedida_id' => $row[4],
            'codigo' => $row[0],
        ]);
    }
}
