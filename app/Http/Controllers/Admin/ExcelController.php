<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\MateriaPrimaExport;

class ExcelController extends Controller
{
    public function materiaprima($desde, $hasta)
    {
        return Excel::download(new MateriaPrimaExport, 'materiaprima.xlsx');
    }
}
