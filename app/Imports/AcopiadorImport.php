<?php

namespace App\Imports;

use App\Models\Acopiador;
use App\Models\Empacopiadora;
use Maatwebsite\Excel\Concerns\ToModel;

class AcopiadorImport implements ToModel
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
        $id = Empacopiadora::where('nombre', $row[0])->value('id');
        if (strlen($id) == 0){
            return null;
        }
        return new Acopiador([
            'empacopiadora_id' => $id,
            'nombre' => $row[1],
        ]);
    }
}
