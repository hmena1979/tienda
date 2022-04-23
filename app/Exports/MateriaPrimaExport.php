<?php

namespace App\Exports;

use App\Models\Materiaprima;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

// class MateriaPrimaExport implements FromCollection
// {
//     public function collection()
//     {
//         return Materiaprima::all();
//     }
// }

class MateriaPrimaExport implements FromView
{
    public function view(): View
    {
        return view('excel.materiaprima', [
            'materiaprimas' => Materiaprima::all()
        ]);
    }
}