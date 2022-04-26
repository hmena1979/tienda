<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Materiaprima;
use App\Exports\MateriaPrimaExport;

class ExcelController extends Controller
{
    public function materiaprima($desde, $hasta)
    {
        // return view('excel.materiaprima', ['materiaprimas' => Materiaprima::all()]);
        return Excel::download(new MateriaPrimaExport($desde, $hasta), 'materiaprima.xlsx');
    }
}
