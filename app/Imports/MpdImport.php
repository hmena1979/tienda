<?php

namespace App\Imports;

use App\Models\Mpd;
use Maatwebsite\Excel\Concerns\ToModel;

class MpdImport implements ToModel
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

        return new Mpd([
            'nombre' => $row[1],
        ]);
    }
}
