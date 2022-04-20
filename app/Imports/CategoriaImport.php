<?php

namespace App\Imports;

use App\Models\Categoria;
use Maatwebsite\Excel\Concerns\ToModel;


class CategoriaImport implements ToModel
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

        return new Categoria([
            'modulo' => $row[0],
            'nombre' => $row[1],
            'codigo' => $row[2]
        ]);
    }
}
