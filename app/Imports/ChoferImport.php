<?php

namespace App\Imports;

use App\Models\Chofer;
use App\Models\Transportista;
use Maatwebsite\Excel\Concerns\ToModel;

class ChoferImport implements ToModel
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
        return new Chofer([
            'transportista_id' => $id,
            'nombre' => $row[1],
            'licencia' => $row[2]
        ]);
    }
}
