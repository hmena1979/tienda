<?php

namespace App\Exports;

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
            'G' => 12,
            'H' => 11,
            'I' => 9,
            'J' => 10,
            'K' => 10,
            'L' => 10,
            'M' => 9,
            'N' => 32,
            'O' => 6,
            'P' => 6,
            'Q' => 30,
            'R' => 11,
            'S' => 25,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'I' => '#,##0.00',
            'O' => '#,##0.00',
            'R' => '#,##0.00',
            // 'I' => NumberFormat::FORMAT_NUMBER,
            // 'O' => NumberFormat::FORMAT_NUMBER,
            // 'R' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    
    public function view(): View
    {
        $materiasPrimas = Materiaprima::whereBetween('ingplanta',[$this->desde, $this->hasta])->get();
        return view('excel.materiaprima', [
            'materiaprimas' =>  $materiasPrimas
            // 'materiaprimas' => Materiaprima::all()
        ]);
    }
}