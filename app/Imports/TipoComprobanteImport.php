<?php

namespace App\Imports;

use App\Models\TipoComprobante;
use Maatwebsite\Excel\Concerns\ToModel;

class TipoComprobanteImport implements ToModel
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

        return new TipoComprobante([
            'codigo' => $row[0],
            'nombre' => $row[1],
            'operacion' => $row[2],
            'dreferencia' => $row[3],
            'tipo' => $row[4],
            'rc' => $row[5]
        ]);
    }
}
