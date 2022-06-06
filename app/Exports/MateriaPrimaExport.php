<?php

namespace App\Exports;

use App\Models\Embarcacion;
use App\Models\Materiaprima;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
// use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

// class MateriaPrimaExport implements FromCollection
// {
//     public function collection()
//     {
//         return Materiaprima::all();
//     }
// }

class MateriaPrimaExport implements FromView, WithColumnWidths, WithColumnFormatting
{
    public function __construct(string $desde, $hasta)
    {
        $this->desde = $desde;
        $this->hasta = $hasta;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 26,
            'B' => 28,
            'C' => 30,
            'D' => 20,
            'E' => 8,
            'F' => 8,
            'G' => 35,
            'H' => 15,
            'I' => 26,
            'J' => 12,
            'K' => 12,
            'L' => 11,
            'M' => 9,
            'N' => 10,
            'O' => 10,
            'P' => 10,
            'Q' => 9,
            'R' => 32,
            'S' => 6,
            'T' => 6,
            'U' => 30,
            'V' => 11,
            'W' => 25,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'M' => '#,##0.00',
            'S' => '#,##0.00',
            'V' => '#,##0.00',
            // 'I' => NumberFormat::FORMAT_NUMBER,
            // 'O' => NumberFormat::FORMAT_NUMBER,
            // 'R' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    
    public function view(): View
    {
        $enombre = Embarcacion::pluck('nombre','id');
        $ematricula = Embarcacion::pluck('matricula','id');
        $eprotocolo = Embarcacion::pluck('protocolo','id');
        $ecapacidad = Embarcacion::pluck('capacidad','id');
        $materiasPrimas = Materiaprima::whereBetween('ingplanta',[$this->desde, $this->hasta])->orderBy('ticket_balanza')->get();
        return view('excel.materiaprima', [
            'materiaprimas' =>  $materiasPrimas,
            'enombre' => $enombre,
            'ematricula' => $ematricula,
            'eprotocolo' => $eprotocolo,
            'ecapacidad' => $ecapacidad,
            // 'materiaprimas' => Materiaprima::all()
        ]);
    }
}