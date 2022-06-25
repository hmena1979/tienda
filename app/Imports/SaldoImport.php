<?php

namespace App\Imports;

use App\Models\Producto;
use App\Models\Saldo;
use Maatwebsite\Excel\Concerns\ToModel;

class SaldoImport implements ToModel
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
        $producto_id = Producto::where('codigo',$row[0])->value('id');
        if($row[6] == 0){
            return null;
        }
        return new Saldo([
            'periodo' => '000000',
            'producto_id' => $producto_id,
            'entradas' => $row[6],
            'saldo' => $row[6],
            'precio' => 0,
        ]);
    }
}
