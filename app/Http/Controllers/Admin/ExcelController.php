<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Alignment;

use App\Models\Materiaprima;
use App\Exports\MateriaPrimaExport;
use App\Models\Embarcacion;
use App\Models\Empresa;
use PhpOffice\PhpSpreadsheet\Style\Alignment as StyleAlignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExcelController extends Controller
{
    public function materiaprima($desde, $hasta)
    {
        // return view('excel.materiaprima', ['materiaprimas' => Materiaprima::all()]);
        return Excel::download(new MateriaPrimaExport($desde, $hasta), 'materiaprima.xlsx');
    }

    public function materiaprimaii($desde, $hasta)
    {
        $materiasPrimas = Materiaprima::whereBetween('ingplanta',[$desde, $hasta])->orderBy('ticket_balanza','desc')->get();
        $empresa = Empresa::findOrFail(session('empresa'));
        $enombre = Embarcacion::pluck('nombre','id');
        $ematricula = Embarcacion::pluck('matricula','id');
        $eprotocolo = Embarcacion::pluck('protocolo','id');
        $ecapacidad = Embarcacion::pluck('capacidad','id');
        //Creación de Excel
        $excel = new Spreadsheet();

        //Información del Archivo
        $excel
            ->getProperties()
            ->setCreator("Pesquera HL")
            ->setLastModifiedBy('Proceso')
            ->setTitle('Materia Prima')
            ->setSubject('Materia Prima por Fechas')
            ->setDescription('Reporte de Ingreso Materia Prima')
            ->setKeywords('MPrima')
            ->setCategory('Categoría Excel');

        //Fuente y Tamaño por defecto
        $excel
            ->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(9);

        //Creación de Hoja y Llenado de Información
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle("Materia Prima");

        // Logo
        $logo = new Drawing();
        $logo->setName('Logo');
        $logo->setDescription('Logo');
        $logo->setPath('./static/images/logopesquera.jpeg');
        $logo->setCoordinates('A1');
        $logo->setHeight(60);
        // $logo->setOffsetX(110);
        // $logo->setRotation(25);
        // $logo->getShadow()->setVisible(true);
        // $logo->getShadow()->setDirection(45);
        $logo->setWorksheet($excel->getActiveSheet());

        $sheet->setCellValue('A2','REPORTE DE INGRESO DE MATERIA PRIMA');
        $sheet->mergeCells('A2:V2');
        $sheet->getStyle('A2')->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A2')
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $linea = 5;
        $salto = "\r\n";
        $sheet->setCellValue('A3','DESDE: '.$desde.' HASTA '.$hasta);
        $sheet->mergeCells('A3:V3');
        $sheet->getStyle('A3')->getFont()->setSize(10)->setBold(true);
        $sheet->getStyle('A3')
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        // Ancho de Columnas
        $sheet->getColumnDimension('A')->setWidth(45);
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(32);
        $sheet->getColumnDimension('E')->setWidth(13);
        $sheet->getColumnDimension('F')->setWidth(24);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(13);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(10);
        $sheet->getColumnDimension('K')->setWidth(10);
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(10);
        $sheet->getColumnDimension('N')->setWidth(10);
        $sheet->getColumnDimension('O')->setWidth(70);
        $sheet->getColumnDimension('P')->setWidth(11);
        $sheet->getColumnDimension('Q')->setWidth(15);
        $sheet->getColumnDimension('R')->setWidth(10);
        $sheet->getColumnDimension('S')->setWidth(10);
        $sheet->getColumnDimension('T')->setWidth(15);
        $sheet->getColumnDimension('U')->setWidth(12);
        $sheet->getColumnDimension('V')->setWidth(20);

        $sheet->getStyle('I')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        $sheet->getStyle('K')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $sheet->getStyle('R')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $sheet->getStyle('U')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        $sheet->getStyle('A'.$linea.':V'.$linea)->getFont()->setBold(true);
        $sheet->setCellValue('A'.$linea,'EMPRESA TRANSPORTISTA');
        $sheet->setCellValue('B'.$linea,'MARCA');
        $sheet->setCellValue('C'.$linea,'PLACA');
        $sheet->setCellValue('D'.$linea,'EMBARCACIÓN');
        $sheet->setCellValue('H'.$linea,'LOTE');
        $sheet->setCellValue('I'.$linea,'CAJAS'.$salto.'DECLARADAS');
        $sheet->setCellValue('J'.$linea,'INGRESO'.$salto.'PLANTA');
        $sheet->setCellValue('K'.$linea,'PESO'.$salto.'PLANTA KG');
        $sheet->setCellValue('L'.$linea,'FECHA'.$salto.'PARTIDA');
        $sheet->setCellValue('M'.$linea,'HORA'.$salto.'DESCARGA');
        $sheet->setCellValue('N'.$linea,'FECHA'.$salto.'LLEGADA');
        $sheet->setCellValue('O'.$linea,'PROVEEDOR');
        $sheet->setCellValue('P'.$linea,'GUÍA'.$salto.'REMITENTE');
        $sheet->setCellValue('Q'.$linea,'GUÍA'.$salto.'TRANSPORTISTA');
        $sheet->setCellValue('R'.$linea,'PRECIO');
        $sheet->setCellValue('S'.$linea,'LUGAR');
        $sheet->setCellValue('T'.$linea,'TIPO PRODUCTO');
        $sheet->setCellValue('U'.$linea,'DESTARE KG');
        $sheet->setCellValue('V'.$linea,'OBSERVACIONES');
        $sheet->mergeCells('D'.$linea.':G'.$linea);
        $sheet->getStyle('D'.$linea)->getFont()->setBold(true);
        $sheet->getStyle('D'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A'.$linea.':A'.($linea+1));
        $sheet->mergeCells('B'.$linea.':B'.($linea+1));
        $sheet->mergeCells('C'.$linea.':C'.($linea+1));
        $sheet->mergeCells('H'.$linea.':H'.($linea+1));
        $sheet->mergeCells('I'.$linea.':I'.($linea+1));
        $sheet->mergeCells('J'.$linea.':J'.($linea+1));
        $sheet->mergeCells('K'.$linea.':K'.($linea+1));
        $sheet->mergeCells('L'.$linea.':L'.($linea+1));
        $sheet->mergeCells('M'.$linea.':M'.($linea+1));
        $sheet->mergeCells('N'.$linea.':N'.($linea+1));
        $sheet->mergeCells('O'.$linea.':O'.($linea+1));
        $sheet->mergeCells('P'.$linea.':P'.($linea+1));
        $sheet->mergeCells('Q'.$linea.':Q'.($linea+1));
        $sheet->mergeCells('R'.$linea.':R'.($linea+1));
        $sheet->mergeCells('S'.$linea.':S'.($linea+1));
        $sheet->mergeCells('T'.$linea.':T'.($linea+1));
        $sheet->mergeCells('U'.$linea.':U'.($linea+1));
        $sheet->mergeCells('V'.$linea.':V'.($linea+1));
        $sheet->getStyle('A'.$linea.':V'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER);
        $sheet->getStyle('I'.$linea)->getAlignment()->setWrapText(true);
        $sheet->getStyle('J'.$linea)->getAlignment()->setWrapText(true);
        $sheet->getStyle('K'.$linea)->getAlignment()->setWrapText(true);
        $sheet->getStyle('L'.$linea)->getAlignment()->setWrapText(true);
        $sheet->getStyle('M'.$linea)->getAlignment()->setWrapText(true);
        $sheet->getStyle('N'.$linea)->getAlignment()->setWrapText(true);
        $sheet->getStyle('P'.$linea)->getAlignment()->setWrapText(true);
        $sheet->getStyle('Q'.$linea)->getAlignment()->setWrapText(true);
        $linea++;
        $sheet->getStyle('A'.$linea.':T'.$linea)->getFont()->setBold(true);
        // $sheet->setBreak('G'.$linea,Worksheet::BREAK_ROW);
        $sheet->setCellValue('D'.$linea,'NOMBRE');
        $sheet->setCellValue('E'.$linea,'MATRÍCULA');
        $sheet->setCellValue('F'.$linea,'PROTOCOLO');
        $sheet->setCellValue('G'.$linea,'CAPACIDAD');
        //Detalles
        $color = 1;
        foreach($materiasPrimas as $materiaPrima) {
            $linea++;
            $cantidad = 0;
            if (!empty($materiaPrima->embarcacion_id)) {
                $cantidad = count(json_decode($materiaPrima->embarcacion_id));
            }
            $sheet->getStyle('A'.$linea.':T'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(colorExcel($color));
            $transportista = empty($materiaPrima->transportista_id)?'PENDIENTE':$materiaPrima->transportista->nombre;
            $marca = empty($materiaPrima->camara_id)?'PENDIENTE':$materiaPrima->camara->marca;
            $placa = empty($materiaPrima->camara_id)?'PENDIENTE':$materiaPrima->camara->placa;
            $proveedor =  empty($materiaPrima->cliente_id)?'PENDIENTE':$materiaPrima->cliente->razsoc;
            $sheet->setCellValue('A'.$linea, $transportista);
            $sheet->setCellValue('B'.$linea, $marca);
            $sheet->setCellValue('C'.$linea, $placa);
            $sheet->setCellValue('H'.$linea, $materiaPrima->lote);
            $sheet->setCellValue('I'.$linea, $materiaPrima->cajas);
            $sheet->setCellValue('J'.$linea, $materiaPrima->ingplanta);
            $sheet->setCellValue('k'.$linea, $materiaPrima->pplanta);
            $sheet->setCellValue('L'.$linea, $materiaPrima->fpartida);
            $sheet->setCellValue('M'.$linea, $materiaPrima->hfin);
            $sheet->setCellValue('N'.$linea, $materiaPrima->fllegada);
            $sheet->setCellValue('O'.$linea, $proveedor);
            $sheet->setCellValue('P'.$linea, $materiaPrima->remitente_guia);
            $sheet->setCellValue('Q'.$linea, $materiaPrima->transportista_guia);
            $sheet->setCellValue('R'.$linea, $materiaPrima->precio);
            $sheet->setCellValue('S'.$linea, $materiaPrima->lugar);
            $sheet->setCellValue('T'.$linea, $materiaPrima->producto->nombre);
            $sheet->setCellValue('U'.$linea, $materiaPrima->destare);
            $sheet->setCellValue('V'.$linea, $materiaPrima->observaciones);
            if ($cantidad > 0) {
                $lineaInicio = $linea;
                foreach (json_decode($materiaPrima->embarcacion_id) as $embarcacion){
                    $sheet->getStyle('A'.$linea.':V'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(colorExcel($color));
                    $sheet->setCellValue('D'.$linea, $enombre[$embarcacion]);
                    $sheet->setCellValue('E'.$linea, $ematricula[$embarcacion]);
                    $sheet->setCellValue('F'.$linea, $eprotocolo[$embarcacion]);
                    $sheet->setCellValue('G'.$linea, $ecapacidad[$embarcacion]);
                    $linea++;
                }
                $linea--;
                $sheet->mergeCells('A'.$lineaInicio.':A'.$linea);
                $sheet->mergeCells('B'.$lineaInicio.':B'.$linea);
                $sheet->mergeCells('C'.$lineaInicio.':C'.$linea);
                $sheet->mergeCells('H'.$lineaInicio.':H'.$linea);
                $sheet->mergeCells('I'.$lineaInicio.':I'.$linea);
                $sheet->mergeCells('J'.$lineaInicio.':J'.$linea);
                $sheet->mergeCells('K'.$lineaInicio.':K'.$linea);
                $sheet->mergeCells('L'.$lineaInicio.':L'.$linea);
                $sheet->mergeCells('M'.$lineaInicio.':M'.$linea);
                $sheet->mergeCells('N'.$lineaInicio.':N'.$linea);
                $sheet->mergeCells('O'.$lineaInicio.':O'.$linea);
                $sheet->mergeCells('P'.$lineaInicio.':P'.$linea);
                $sheet->mergeCells('Q'.$lineaInicio.':Q'.$linea);
                $sheet->mergeCells('R'.$lineaInicio.':R'.$linea);
                $sheet->mergeCells('S'.$lineaInicio.':S'.$linea);
                $sheet->mergeCells('T'.$lineaInicio.':T'.$linea);
                $sheet->mergeCells('U'.$lineaInicio.':U'.$linea);
                $sheet->mergeCells('V'.$lineaInicio.':V'.$linea);
                $sheet->getStyle('A'.$lineaInicio.':V'.$linea)
                    ->getAlignment()
                    ->setVertical(StyleAlignment::VERTICAL_CENTER);
            }

            $color++;
            if ($color > 22) {
                $color = 1;
            }
        }

        $estiloBorde = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    // 'color' => ['argb' => 'FFFF0000'],
                ],
            ],
        ];
        
        $sheet->getStyle('A5'.':V'.$linea)->applyFromArray($estiloBorde);

        //Envio de Archivo para Descarga
        $fileName="MateriaPrima".$desde."_".$hasta.".xlsx";
        # Crear un "escritor"
        $writer = new Xlsx($excel);
        # Le pasamos la ruta de guardado
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }

    public function tolvasindex()
    {
        return view('admin.reportes.tolvasindex');
    }

    public function tolvasview(Request $request)
    {
        $periodo = $request->input('mes').$request->input('anio');
        $materiasPrimas = Materiaprima::where('periodo',$periodo)->orderBy('ticket_balanza')->get();
        $empresa = Empresa::findOrFail(session('empresa'));
        $enombre = Embarcacion::pluck('nombre','id');
        $ematricula = Embarcacion::pluck('matricula','id');
        $eprotocolo = Embarcacion::pluck('protocolo','id');
        $ecapacidad = Embarcacion::pluck('capacidad','id');
        //Creación de Excel
        $excel = new Spreadsheet();

        //Información del Archivo
        $excel
            ->getProperties()
            ->setCreator("MARINE PRODUCTS SERVICE S.A.")
            ->setLastModifiedBy('Proceso')
            ->setTitle('Materia Prima')
            ->setSubject('ECLARACION JURADA MENSUAL')
            ->setDescription('DECLARACION JURADA MENSUAL DE REPORTE DE PESAJE POR TOLVA O BALANZA')
            ->setKeywords('MPrima')
            ->setCategory('Categoría Excel');

        //Fuente y Tamaño por defecto
        $excel
            ->getDefaultStyle()
            ->getFont()
            ->setName('Times New Roman')
            ->setSize(9);

        //Creación de Hoja y Llenado de Información
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle("MATERIA PRIMA ".getMes($request->input('mes')).' - '.$request->input('anio'));

        // Logo
        $logo = new Drawing();
        $logo->setName('Logo');
        $logo->setDescription('Logo');
        $logo->setPath('./static/images/logoministerioproduccion.jpg');
        $logo->setCoordinates('A1');
        $logo->setHeight(90);
        $logo->setOffsetX(110);
        $logo->setOffsetY(30);
        // $logo->setRotation(25);
        // $logo->getShadow()->setVisible(true);
        // $logo->getShadow()->setDirection(45);
        $logo->setWorksheet($excel->getActiveSheet());
        $linea = 9;
        $salto = "\r\n";

        $sheet->setCellValue('A'.$linea,'DECLARACION JURADA MENSUAL DE REPORTE DE PESAJE POR TOLVA O BALANZA');
        $sheet->getStyle('A'.$linea)->getFont()->getColor()->setARGB('FF000080');
        $sheet->mergeCells('A'.$linea.':L'.$linea);
        $sheet->getStyle('A'.$linea)->getFont()->setSize(10)->setBold(true);
        $sheet->getStyle('A'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $linea++;
        $sheet->setCellValue('A'.$linea, "R.M.N°  153-2001-PE");
        $sheet->mergeCells('A'.$linea.':L'.$linea);
        $sheet->getStyle('A'.$linea)->getFont()->setSize(10)->setBold(false);
        $sheet->getStyle('A'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $linea++;
        $linea++;
        $sheet->setCellValue('B'.$linea, "Razón Social:");
        $sheet->getStyle('B'.$linea)->getFont()->setSize(10)->setBold(true);
        $sheet->setCellValue('C'.$linea, "MARINE PRODUCTS SERVICE S.A.");
        $sheet->mergeCells('C'.$linea.':F'.$linea);
        $sheet->getStyle('C'.$linea)->getFont()->setSize(10)->setBold(false);
        $linea++;
        $sheet->setCellValue('B'.$linea, "Ubicación      : ");
        $sheet->getStyle('B'.$linea)->getFont()->setSize(10)->setBold(true);
        $sheet->setCellValue('C'.$linea, "MZ B LOTE 3B ZONA INDUSTRIAL II PAITA-PAITA-PIURA");
        $sheet->mergeCells('C'.$linea.':F'.$linea);
        $sheet->getStyle('C'.$linea)->getFont()->setSize(10)->setBold(false);
        $linea++;
        $sheet->setCellValue('B'.$linea, "Mes               :");
        $sheet->getStyle('B'.$linea)->getFont()->setSize(10)->setBold(true);
        $sheet->setCellValue('C'.$linea, getMes($request->input('mes')).' '.$request->input('anio'));
        $sheet->mergeCells('C'.$linea.':F'.$linea);
        $sheet->getStyle('C'.$linea)->getFont()->setSize(10)->setBold(false);
        $linea++;$linea++;$linea++;

        // $sheet->getStyle('C')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->getStyle('I')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        $sheet->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.0000');

        $sheet->getStyle('A'.$linea.':T'.$linea)->getFont()->setBold(true);
        $sheet->setCellValue('A'.$linea,'N°');
        $sheet->setCellValue('B'.$linea,'Tolva N°');
        $sheet->setCellValue('C'.$linea,'Fecha');
        $sheet->setCellValue('D'.$linea,'Reporte');
        $sheet->setCellValue('E'.$linea,'Nombre de Embarcación');
        $sheet->setCellValue('F'.$linea,'Matrícula');
        $sheet->setCellValue('G'.$linea,'Especie');
        $sheet->setCellValue('H'.$linea,'Destino de');
        $sheet->setCellValue('I'.$linea,'N° de');
        $sheet->setCellValue('J'.$linea,'Peso (tm.)');
        $sheet->setCellValue('K'.$linea,'Hora');
        $sheet->setCellValue('L'.$linea,'Hora');
        $sheet->mergeCells('A'.$linea.':A'.($linea+1));
        $sheet->mergeCells('C'.$linea.':C'.($linea+1));
        $sheet->mergeCells('E'.$linea.':E'.($linea+1));
        $sheet->mergeCells('F'.$linea.':F'.($linea+1));
        $sheet->getStyle('A'.$linea.':T'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER)
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);

        $linea++;
        $sheet->getStyle('A'.$linea.':T'.$linea)->getFont()->setBold(true);
        $sheet->setCellValue('B'.$linea,'Balanza');
        $sheet->setCellValue('D'.$linea,'Nro');
        $sheet->setCellValue('G'.$linea,'(*)');
        $sheet->setCellValue('H'.$linea,'Recursos (**)');
        $sheet->setCellValue('I'.$linea,'Batch');
        $sheet->setCellValue('J'.$linea,'Acumulado');
        $sheet->setCellValue('K'.$linea,'Inicio');
        $sheet->setCellValue('L'.$linea,'Término');
        $sheet->getStyle('A'.$linea.':L'.$linea)
                ->getAlignment()
                ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        //Detalles
        $color = 1;
        $pesoAcumulado = 0;
        foreach($materiasPrimas as $materiaPrima) {
            $pesoAcumulado += $materiaPrima->pplanta/1000;
            $linea++;
            $cantidad = 0;
            if (!empty($materiaPrima->embarcacion_id)) {
                $cantidad = count(json_decode($materiaPrima->embarcacion_id));
            }
            $sheet->setCellValue('A'.$linea, $color);
            $sheet->setCellValue('B'.$linea, 'I');
            $sheet->setCellValue('C'.$linea, date('d/m/Y',strtotime($materiaPrima->ingplanta)));
            $sheet->setCellValue('D'.$linea, $materiaPrima->ticket_balanza);
            $sheet->setCellValue('I'.$linea, $materiaPrima->batch);
            $sheet->setCellValue('J'.$linea, $materiaPrima->pplanta/1000);
            $sheet->setCellValue('K'.$linea, $materiaPrima->hinicio);
            $sheet->setCellValue('L'.$linea, $materiaPrima->hfin);
            if ($cantidad > 0) {
                $lineaInicio = $linea;
                foreach (json_decode($materiaPrima->embarcacion_id) as $embarcacion){
                    $sheet->setCellValue('E'.$linea, $enombre[$embarcacion]);
                    $sheet->setCellValue('F'.$linea, $ematricula[$embarcacion]);
                    $sheet->setCellValue('G'.$linea, '8');
                    $sheet->setCellValue('H'.$linea, '3');
                    $sheet->getStyle('A'.$linea.':L'.$linea)
                    ->getAlignment()
                    ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                    $linea++;
                }
                $linea--;
                $sheet->mergeCells('A'.$lineaInicio.':A'.$linea);
                $sheet->mergeCells('B'.$lineaInicio.':B'.$linea);
                $sheet->mergeCells('C'.$lineaInicio.':C'.$linea);
                $sheet->mergeCells('D'.$lineaInicio.':D'.$linea);
                $sheet->mergeCells('I'.$lineaInicio.':I'.$linea);
                $sheet->mergeCells('J'.$lineaInicio.':J'.$linea);
                $sheet->mergeCells('K'.$lineaInicio.':K'.$linea);
                $sheet->mergeCells('L'.$lineaInicio.':L'.$linea);
                $sheet->getStyle('A'.$lineaInicio.':L'.$linea)
                    ->getAlignment()
                    ->setVertical(StyleAlignment::VERTICAL_CENTER);
            }

            $color++;
            $sheet->getStyle('A'.$linea.':L'.$linea)
                ->getAlignment()
                ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        }
        $linea++;
        $sheet->setCellValue('A'.$linea, 'TOTAL');
        $sheet->mergeCells('A'.$linea.':I'.$linea);
        $sheet->setCellValue('J'.$linea, $pesoAcumulado);
        $sheet->getStyle('J'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92D050');
        $sheet->getStyle('A'.$linea.':L'.$linea)
                ->getAlignment()
                ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':T'.$linea)->getFont()->setBold(true);
        
        $estiloBorde = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        
        $sheet->getStyle('A17'.':L'.$linea)->applyFromArray($estiloBorde);
        $linea++;
        $linea++;
        $sheet->setCellValue('B'.$linea, 'OBSERVACIONES:');
        $sheet->getStyle('B'.$linea)->getFont()->setSize(10)->setBold(true);
        $sheet->setCellValue('D'.$linea, 'DOSIDICUS GIGAS (POTA)');
        $sheet->getStyle('D'.$linea)->getFont()->setSize(10)->setBold(false);
        $linea++;$linea++;$linea++;
        $sheet->setCellValue('B'.$linea, 'ESPECIES (*)');
        $sheet->getStyle('B'.$linea)->getFont()->setBold(true);
        $sheet->setCellValue('C'.$linea, 'DESTINO DEL RECURSO (**)');
        $sheet->getStyle('C'.$linea)->getFont()->setBold(true);
        $linea++;
        $sheet->setCellValue('B'.$linea, '01 Anchoveta');
        $sheet->setCellValue('C'.$linea, '01 Harina y Aceite');
        $linea++;
        $sheet->setCellValue('B'.$linea, '02 Sardina');
        $sheet->setCellValue('C'.$linea, '02 Enlatado');
        $linea++;
        $sheet->setCellValue('B'.$linea, '03 Jurel');
        $sheet->setCellValue('C'.$linea, '03 Congelado');
        $linea++;
        $sheet->setCellValue('B'.$linea, '04 Caballa');
        $sheet->setCellValue('C'.$linea, '04 Curado');
        $linea++;
        $sheet->setCellValue('B'.$linea, '05 Samasa');
        $sheet->setCellValue('C'.$linea, '05 Otros (especificar en observaciones)');
        $linea++;
        $sheet->setCellValue('B'.$linea, '06 Camotillo');
        $linea++;
        $sheet->setCellValue('B'.$linea, '07 Merluza');
        $linea++;
        $sheet->setCellValue('B'.$linea, '08 Otros (Especificar en observaciones)');
        $linea++;
        $sheet->setCellValue('B'.$linea, '(a) Especificar el Tipo de Instrumento de Pesaje');
        
        // Ancho de Columnas
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getColumnDimension('C')->setWidth(21);
        $sheet->getColumnDimension('D')->setWidth(8);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setWidth(16);
        $sheet->getColumnDimension('G')->setWidth(11);
        $sheet->getColumnDimension('H')->setWidth(14);
        $sheet->getColumnDimension('I')->setWidth(9);
        $sheet->getColumnDimension('J')->setWidth(11);
        $sheet->getColumnDimension('K')->setWidth(10);
        $sheet->getColumnDimension('L')->setWidth(10);

        //Envio de Archivo para Descarga
        $fileName= getMes($request->input('mes')).'-'.$request->input('anio').'-TOLVAS'.".xlsx";
        # Crear un "escritor"
        $writer = new Xlsx($excel);
        # Le pasamos la ruta de guardado
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }
}
