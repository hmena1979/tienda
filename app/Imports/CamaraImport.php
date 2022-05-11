<?php

namespace App\Imports;

use App\Models\Camara;
use App\Models\Transportista;
use Maatwebsite\Excel\Concerns\ToModel;

class CamaraImport implements ToModel
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
        $id = Transportista::where('ruc', $row[0])->value('id');
        if (strlen($id) == 0){
            return null;
        }
        return new Camara([
            'transportista_id' => $id,
            'marca' => $row[1],
            'placa' => $row[2]
        ]);
    }
}
