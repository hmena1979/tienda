<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Alignment;

use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Style\Alignment as StyleAlignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use App\Models\Materiaprima;
use App\Exports\MateriaPrimaExport;
use App\Models\Cliente;
use App\Models\Despiece;
use App\Models\Detdespiece;
use App\Models\Detparte;
use App\Models\Detpartecamara;
use App\Models\Embarcacion;
use App\Models\Empresa;
use App\Models\Mpobtenida;
use App\Models\Parte;
use App\Models\Pproceso;
use App\Models\Productoterminado;
use App\Models\Rcompra;
use App\Models\Residuo;
use App\Models\Trazabilidad;
use App\Models\User;

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
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
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
        $linea++;
        $linea++;
        $sheet->setCellValue('B'.$linea, 'Peso Total');
        $sheet->setCellValue('C'.$linea, number_format($materiasPrimas->sum('pplanta'),2).' KG');
        $sheet->getStyle('B'.$linea.':C'.$linea)->applyFromArray($estiloBorde);
        $sheet->getStyle('B'.$linea.':C'.$linea)->getFont()->setBold(true);
        $linea++;
        $verprecio = User::permission('admin.materiaprimas.precio')->where('id',Auth::user()->id)->count();
        if ($verprecio) {
            $sheet->setCellValue('B'.$linea, 'Precio Promedio');
            $sheet->setCellValue('C'.$linea, 'S/ '.number_format($materiasPrimas->avg('precio'),2));
            $sheet->getStyle('B'.$linea.':C'.$linea)->applyFromArray($estiloBorde);
            $sheet->getStyle('B'.$linea.':C'.$linea)->getFont()->setBold(true);
        }


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

    public function procesoindex()
    {
        $pprocesos = Pproceso::where('empresa_id',session('empresa'))->pluck('nombre','id');
        return view('admin.reportes.procesoindex', compact('pprocesos'));
    }

    public function tolvasview(Request $request)
    {
        $periodo = $request->input('mes').$request->input('anio');
        // $materiasPrimas = Materiaprima::where('periodo',$periodo)->orderBy('ticket_balanza')->get();
        $materiasPrimas = Materiaprima::whereMonth('ingplanta',$request->input('mes'))
            ->whereYear('ingplanta',$request->input('anio'))
            ->orderBy('ticket_balanza')
            ->get();
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

    public function parte(Parte $parte)
    {
        $materiaPrimas = Materiaprima::whereIn('lote',json_decode($parte->lotes))->orderBy('ticket_balanza')->get();
        $mpObtenidas = Mpobtenida::get();
        $empresa = Empresa::findOrFail($parte->empresa_id);
        $enombre = Embarcacion::pluck('nombre','id');
        $ematricula = Embarcacion::pluck('matricula','id');
        $eprotocolo = Embarcacion::pluck('protocolo','id');
        $ecapacidad = Embarcacion::pluck('capacidad','id');
        $totalMateriaPrima = $materiaPrimas->sum('pplanta');
        $salto = "\r\n";
        //Creación de Excel
        $excel = new Spreadsheet();

        //Información del Archivo
        $excel
            ->getProperties()
            ->setCreator("Pesquera HL")
            ->setLastModifiedBy('Proceso')
            ->setTitle('Parte de Producción')
            ->setSubject('Parte de Producción')
            ->setDescription('Reporte de Parte de Producción')
            ->setKeywords('Parte')
            ->setCategory('Categoría Excel');

        //Fuente y Tamaño por defecto
        $excel
            ->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(8);
        
        $estiloBorde = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        //Creación de Hoja y Llenado de Información
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle("Parte de Producción");
        $linea = 1;
        // Logo
        $logo = new Drawing();
        $logo->setName('Logo');
        $logo->setDescription('Logo');
        $logo->setPath('./static/images/logopesquera.jpeg');
        $logo->setCoordinates('A'.$linea);
        $logo->setHeight(60);
        // $logo->setOffsetX(110);
        // $logo->setRotation(25);
        // $logo->getShadow()->setVisible(true);
        // $logo->getShadow()->setDirection(45);
        $logo->setWorksheet($excel->getActiveSheet());
        $sheet->setCellValue('P'.$linea, 'N°');
        $sheet->setCellValue('Q'.$linea, $parte->lote);
        $sheet->mergeCells('Q'.$linea .':R'.$linea);
        $sheet->getStyle('P'.$linea.':R'.$linea)->applyFromArray($estiloBorde);
        $sheet->getStyle('P'.$linea.':R'.$linea)->getFont()->setSize(10)->setBold(true);
        $linea++;
        $sheet->setCellValue('P'.$linea, 'TURNO');
        $sheet->setCellValue('Q'.$linea, $parte->turno==1?'DIA':'NOCHE');
        $sheet->mergeCells('Q'.$linea .':R'.$linea);
        $sheet->getStyle('P'.$linea.':R'.$linea)->applyFromArray($estiloBorde);
        $sheet->getStyle('P'.$linea.':R'.$linea)->getFont()->setSize(10)->setBold(true);
        $linea++;
        $linea++;
        $linea++;
        $sheet->setCellValue('A'.$linea,'PARTE DE PRODUCCIÓN DE CONGELADOS DE POTA');
        $sheet->mergeCells('A'.$linea .':R'.$linea);
        $sheet->getStyle('A'.$linea)->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        // $linea++;
        // $sheet->setCellValue('A'.$linea,'DESDE: '.'uno'.' HASTA '.'dos');
        // $sheet->mergeCells('A'.$linea.':V'.$linea);
        // $sheet->getStyle('A'.$linea)->getFont()->setSize(10)->setBold(true);
        // $sheet->getStyle('A'.$linea)
        // ->getAlignment()
        // ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $linea++;
        $sheet->setCellValue('A'.$linea,'FECHA DE RECEPCIÓN:');
        $sheet->mergeCells('A'.$linea .':C'.$linea);
        $sheet->setCellValue('D'.$linea,$parte->recepcion);
        $sheet->mergeCells('D'.$linea .':F'.$linea);
        $sheet->setCellValue('G'.$linea,'FECHA DE CONGELACIÓN:');
        $sheet->mergeCells('G'.$linea .':I'.$linea);
        $sheet->setCellValue('J'.$linea,$parte->congelacion);
        $sheet->mergeCells('J'.$linea .':L'.$linea);
        $sheet->setCellValue('M'.$linea,'FECHA DE EMPAQUE:');
        $sheet->mergeCells('M'.$linea .':O'.$linea);
        $sheet->setCellValue('P'.$linea,$parte->empaque);
        $sheet->mergeCells('P'.$linea .':R'.$linea);
        $sheet->getStyle('A'.$linea.':R'.$linea)->applyFromArray($estiloBorde);
        $sheet->getStyle('A'.$linea.':R'.$linea)->getFont()->setSize(8)->setBold(true);
        $linea++;
        $sheet->setCellValue('A'.$linea,'USUARIO/CLIENTE:');
        $sheet->mergeCells('A'.$linea .':C'.$linea);
        $sheet->setCellValue('D'.$linea, $empresa->razsoc);
        $sheet->mergeCells('D'.$linea .':F'.$linea);
        $sheet->setCellValue('G'.$linea,'ORDEN DE PRODUCCIÓN:');
        $sheet->mergeCells('G'.$linea .':I'.$linea);
        $sheet->setCellValue('J'.$linea, substr($parte->lote,5));
        $sheet->mergeCells('J'.$linea .':L'.$linea);
        $sheet->setCellValue('M'.$linea,'LOTE DE PRODUCCIÓN:');
        $sheet->mergeCells('M'.$linea .':O'.$linea);
        $sheet->setCellValue('P'.$linea,$parte->lote);
        $sheet->mergeCells('P'.$linea .':R'.$linea);
        $sheet->getStyle('A'.$linea.':R'.$linea)->applyFromArray($estiloBorde);
        $sheet->getStyle('A'.$linea.':R'.$linea)->getFont()->setSize(8)->setBold(true);
        $linea++;
        $sheet->setCellValue('A'.$linea,'TIPO DE PRODUCCCION:');
        $sheet->mergeCells('A'.$linea .':C'.$linea);
        $sheet->setCellValue('D'.$linea, $parte->produccion==1?'PROPIA':'POR ENCARGO');
        $sheet->mergeCells('D'.$linea .':F'.$linea);
        $sheet->setCellValue('G'.$linea,'MANO DE OBRA:');
        $sheet->mergeCells('G'.$linea .':I'.$linea);
        $sheet->setCellValue('J'.$linea, $parte->contrata->nombre);
        $sheet->mergeCells('J'.$linea .':L'.$linea);
        $sheet->setCellValue('M'.$linea,'CODIGO DE TRAZABILIDAD:');
        $sheet->mergeCells('M'.$linea .':O'.$linea);
        $sheet->setCellValue('P'.$linea,$parte->trazabilidad);
        $sheet->mergeCells('P'.$linea .':R'.$linea);
        $sheet->getStyle('A'.$linea.':R'.$linea)->applyFromArray($estiloBorde);
        $sheet->getStyle('A'.$linea.':R'.$linea)->getFont()->setSize(8)->setBold(true);
        $linea++;$linea++;
        $sheet->setCellValue('A'.$linea,'RECEPCION DE MATERIA PRIMA-KGS.');
        $sheet->mergeCells('A'.$linea .':F'.$linea);
        $sheet->getStyle('A'.$linea.':F'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$linea.':F'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF0070C0');
        $sheet->getStyle('A'.$linea.':F'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
        $linea++;$linea++;
        $registro = 0;
        foreach($materiaPrimas as $det) {
            $registro++;
            $sheet->setCellValue('A'.$linea, 'PROVEEDOR '.$registro.':');
            $sheet->mergeCells('A'.$linea .':B'.$linea);
            $sheet->setCellValue('C'.$linea, $det->cliente->razsoc);
            $sheet->mergeCells('C'.$linea .':F'.$linea);
            $sheet->setCellValue('G'.$linea, 'ZONA ACOPIO:');
            $sheet->mergeCells('G'.$linea .':H'.$linea);
            $sheet->setCellValue('I'.$linea, $det->lugar);
            $sheet->mergeCells('I'.$linea .':J'.$linea);
            $sheet->setCellValue('K'.$linea, 'CÁMARA:');
            $sheet->mergeCells('K'.$linea .':L'.$linea);
            $sheet->setCellValue('M'.$linea, $det->camara->placa);
            $sheet->mergeCells('M'.$linea .':N'.$linea);
            $sheet->setCellValue('O'.$linea, 'GUÍA:');
            $sheet->mergeCells('O'.$linea .':P'.$linea);
            $sheet->setCellValue('Q'.$linea, $det->transportista_guia);
            $sheet->mergeCells('Q'.$linea .':R'.$linea);
            $sheet->getStyle('A'.$linea.':F'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(colorExcel($registro));
            $sheet->getStyle('I'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9D9D9');
            $sheet->getStyle('M'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9D9D9');
            $sheet->getStyle('Q'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9D9D9');
            $sheet->getStyle('A'.$linea.':R'.$linea)->applyFromArray($estiloBorde);
            $linea++;
        }
        $linea++;
        $sheet->setCellValue('A'.$linea, 'EMBARCACION');
        $sheet->mergeCells('A'.$linea .':C'.$linea);
        $sheet->setCellValue('D'.$linea, 'MATRICULA');
        $sheet->mergeCells('D'.$linea .':E'.$linea);
        $sheet->setCellValue('F'.$linea, 'PROTOC. SANIPES');
        $sheet->mergeCells('F'.$linea .':G'.$linea);
        $sheet->setCellValue('H'.$linea, 'CAP.'.$salto.'BODEGA'.$salto.'(T.M.)');
        $sheet->getStyle('H'.$linea)->getAlignment()->setWrapText(true);
        // $sheet->mergeCells('G'.$linea .':'.$linea);
        $sheet->setCellValue('I'.$linea, 'POTA ENTERA');
        $sheet->mergeCells('I'.$linea .':J'.$linea);
        $sheet->setCellValue('K'.$linea, 'TOTAL');
        $sheet->mergeCells('K'.$linea .':L'.$linea);
        $sheet->getStyle('A'.$linea.':L'.$linea)->applyFromArray($estiloBorde);
        $sheet->getStyle('A'.$linea.':L'.$linea)->getFont()->setSize(8)->setBold(true);
        $sheet->getStyle('A'.$linea.':L'.$linea)
                ->getAlignment()
                ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':L'.$linea)
                ->getAlignment()
                ->setVertical(StyleAlignment::VERTICAL_CENTER);
        $registro = 1;
        $cuadroInicio = $linea;
        foreach($materiaPrimas as $materiaPrima) {
            $linea++;
            $cantidad = 0;
            $sheet->setCellValue('I'.$linea, number_format($materiaPrima->pplanta,2));
            $sheet->setCellValue('K'.$linea, number_format($materiaPrima->pplanta,2));
            if (!empty($materiaPrima->embarcacion_id)) {
                $cantidad = count(json_decode($materiaPrima->embarcacion_id));
            }
            if ($cantidad > 0) {
                $lineaInicio = $linea;
                foreach (json_decode($materiaPrima->embarcacion_id) as $embarcacion){
                    $sheet->getStyle('A'.$linea.':L'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(colorExcel($registro));
                    $sheet->setCellValue('A'.$linea, $enombre[$embarcacion]);
                    $sheet->mergeCells('A'.$linea .':C'.$linea);
                    $sheet->setCellValue('D'.$linea, $ematricula[$embarcacion]);
                    $sheet->mergeCells('D'.$linea .':E'.$linea);
                    $sheet->setCellValue('F'.$linea, $eprotocolo[$embarcacion]);
                    $sheet->mergeCells('F'.$linea .':G'.$linea);
                    $sheet->setCellValue('H'.$linea, $ecapacidad[$embarcacion]);
                    $linea++;
                }
                $linea--;
                $sheet->mergeCells('I'.$lineaInicio.':J'.$linea);
                $sheet->getStyle('I'.$lineaInicio.':J'.$linea)
                    ->getAlignment()
                    ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                $sheet->getStyle('I'.$lineaInicio.':J'.$linea)
                    ->getAlignment()
                    ->setVertical(StyleAlignment::VERTICAL_CENTER);
                $sheet->mergeCells('K'.$lineaInicio.':L'.$linea);
                $sheet->getStyle('K'.$lineaInicio.':L'.$linea)
                    ->getAlignment()
                    ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                $sheet->getStyle('K'.$lineaInicio.':L'.$linea)
                    ->getAlignment()
                    ->setVertical(StyleAlignment::VERTICAL_CENTER);
            }

            $registro++;
            if ($registro > 22) {
                $registro = 1;
            }
        }
        $linea++;
        $sheet->setCellValue('A'.$linea, 'TOTAL RECIBIDO POR GUIA');
        $sheet->mergeCells('A'.$linea .':H'.$linea);
        $sheet->setCellValue('I'.$linea, number_format($totalMateriaPrima,2));
        $sheet->mergeCells('I'.$linea .':J'.$linea);
        $sheet->setCellValue('K'.$linea, number_format($totalMateriaPrima,2));
        $sheet->mergeCells('K'.$linea .':L'.$linea);
        $sheet->getStyle('A'.$linea.':L'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);            
        $sheet->getStyle('A'.$linea.':L'.$linea)->getFont()->setBold(true);
        $linea++;
        $sheet->setCellValue('A'.$linea, 'PORCENTAJES');
        $sheet->mergeCells('A'.$linea .':H'.$linea);
        $sheet->setCellValue('I'.$linea, '100.00%');
        $sheet->mergeCells('I'.$linea .':J'.$linea);
        $sheet->setCellValue('K'.$linea, '100.00%');
        $sheet->mergeCells('K'.$linea .':L'.$linea);
        $sheet->getStyle('A'.$linea.':L'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);            
        $sheet->getStyle('A'.$linea.':L'.$linea)->getFont()->setBold(true);
        $sheet->getStyle('A'.$linea.':L'.$linea)->getFont()->getColor()->setARGB(colorExcel('azul'));
        $sheet->getStyle('A'.$cuadroInicio.':L'.$linea)->applyFromArray($estiloBorde);
        $linea++;$linea++;
        $cuadroInicio = $linea;
        $sheet->setCellValue('A'.$linea, 'MATERIAS PRIMAS OBTENIDAS');
        foreach($mpObtenidas as $det) {
            $sheet->setCellValue('F'.$linea, $det->despiece->nombre);
            $sheet->mergeCells('F'.$linea .':H'.$linea);
            $sheet->getStyle('F'.$linea.':H'.$linea)->getFont()->setSize(9)->setBold(true);
            $sheet->setCellValue('I'.$linea, number_format($totalMateriaPrima * ($det->porcentaje/100),2));
            $sheet->mergeCells('I'.$linea .':J'.$linea);
            $sheet->setCellValue('K'.$linea, number_format($totalMateriaPrima * ($det->porcentaje/100),2));
            $sheet->mergeCells('K'.$linea .':L'.$linea);
            $sheet->setCellValue('M'.$linea, $det->porcentaje.'%');
            $linea++;
        }
        $linea--;
        $sheet->mergeCells('A'.$cuadroInicio .':E'.$linea);
        $sheet->getStyle('A'.$cuadroInicio.':E'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$cuadroInicio.':E'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF0070C0');
        $sheet->getStyle('A'.$cuadroInicio.':E'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A'.$cuadroInicio.':E'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$cuadroInicio.':E'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER);
        $sheet->getStyle('I'.$cuadroInicio.':M'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $linea++;
        $sheet->setCellValue('A'.$linea, 'TOTALES EN KILOS');
        $sheet->mergeCells('A'.$linea .':H'.$linea);
        $sheet->setCellValue('I'.$linea, number_format($totalMateriaPrima,2));
        $sheet->mergeCells('I'.$linea .':J'.$linea);
        $sheet->setCellValue('K'.$linea, number_format($totalMateriaPrima,2));
        $sheet->mergeCells('K'.$linea .':L'.$linea);
        $sheet->setCellValue('M'.$linea, '100.00%');
        $sheet->getStyle('A'.$linea.':M'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$linea.':M'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$cuadroInicio.':M'.$linea)->applyFromArray($estiloBorde);

        $linea++;$linea++;
        $sheet->setCellValue('A'.$linea, 'DISTRIBUCION DE MATERIA PRIMA');
        $sheet->mergeCells('A'.$linea .':D'.$linea);
        $sheet->mergeCells('A'.($linea+1) .':D'.($linea+1));
        $sheet->getStyle('A'.$linea.':D'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$linea.':D'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF0070C0');
        $sheet->getStyle('A'.$linea.':D'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A'.$linea.':D'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':D'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER);
        $columna = 4;
        foreach($mpObtenidas as $det) {
            $pieza = $totalMateriaPrima * ($det->porcentaje/100);
            $despiece = Detdespiece::Where('despiece_id',$det->despiece_id)->get();
            foreach($despiece as $det2){
                $columna++;
                $sheet->getStyleByColumnAndRow($columna,$linea)->getAlignment()->setWrapText(true);
                $sheet->setCellValueByColumnAndRow($columna,$linea,$det2->nombre);
                $sheet->setCellValueByColumnAndRow($columna,$linea + 1, round($pieza*($det2->porcentaje/100),2));
            }
        }
        $columna++;
        $sheet->getStyleByColumnAndRow($columna,$linea)->getAlignment()->setWrapText(true);
        $sheet->setCellValueByColumnAndRow($columna,$linea,'KILOS');
        $sheet->setCellValueByColumnAndRow($columna,$linea+1,$totalMateriaPrima);
        $sheet->getStyleByColumnAndRow(4,$linea,$columna,$linea)->getFont()->setSize(8)->setBold(true);
        $sheet->getStyleByColumnAndRow(1,$linea,$columna,$linea+1)->applyFromArray($estiloBorde);

        $linea++;$linea++;$linea++;
        $cuadroInicio = $linea;
        $sheet->setCellValue('A'.$linea, 'BALANCE DE MATERIAS - KGS.');
        $sheet->mergeCells('A'.$linea .':D'.$linea);
        // $sheet->mergeCells('A'.($linea+1) .':D'.($linea+1));
        
        $sheet->getStyle('A'.$linea.':D'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF0070C0');
        $sheet->getStyle('A'.$linea.':D'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
        
        $sheet->setCellValue('E'.$linea, 'TRABAJADO Kgs.');
        $sheet->setCellValue('F'.$linea, 'ENVASADO KGS.');
        $sheet->setCellValue('G'.$linea, 'SOBRE PESO  kgs.');
        $sheet->setCellValue('H'.$linea, 'RESIDUOS SOLIDOS');
        $sheet->setCellValue('I'.$linea, 'DESCARTE FRESCO');
        $sheet->setCellValue('J'.$linea, 'MERMAS Kgs.');
        $sheet->setCellValue('K'.$linea, 'OBSERVACIONES');
        $sheet->mergeCells('K'.$linea .':O'.$linea);
        $sheet->getStyle('A'.$linea.':O'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('E'.$linea.':O'.$linea)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.$linea.':O'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':O'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER);
        $linea++;
        $sheet->setCellValue('A'.$linea, 'TOTALES - (KGS)');
        $sheet->mergeCells('A'.$linea .':D'.$linea);
        $sheet->getStyle('A'.$linea.':D'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->setCellValue('E'.$linea, $parte->materiaprima);
        $sheet->setCellValue('F'.$linea, $parte->envasado);
        $sheet->setCellValue('G'.$linea, $parte->sobrepeso);
        $sheet->setCellValue('H'.$linea, $parte->residuos);
        $sheet->setCellValue('I'.$linea, $parte->descarte);
        $sheet->setCellValue('J'.$linea, $parte->merma);
        $sheet->setCellValue('K'.$linea, $parte->observaciones);
        $sheet->mergeCells('K'.$linea .':O'.($linea+1));
        $sheet->getStyle('K'.$linea.':O'.$linea.($linea+1))->getAlignment()->setWrapText(true);
        // $sheet->getStyle('A'.$linea.':O'.$linea)->getFont()->setSize(9)->setBold(true);
        // $sheet->getStyle('E'.$linea.':O'.$linea)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.$linea.':O'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':O'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER);
        $linea++;
        $sheet->setCellValue('A'.$linea, 'PORCENTAJES');
        $sheet->mergeCells('A'.$linea .':D'.$linea);
        $sheet->getStyle('A'.$linea.':D'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->setCellValue('E'.$linea, '100%');
        $sheet->setCellValue('F'.$linea, number_format(($parte->envasado/$parte->materiaprima)*100,2).'%');
        $sheet->setCellValue('G'.$linea, number_format(($parte->sobrepeso/$parte->materiaprima)*100,2).'%');
        $sheet->setCellValue('H'.$linea, number_format(($parte->residuos/$parte->materiaprima)*100,2).'%');
        $sheet->setCellValue('I'.$linea, number_format(($parte->descarte/$parte->materiaprima)*100,2).'%');
        $sheet->setCellValue('J'.$linea, number_format(($parte->merma/$parte->materiaprima)*100,2).'%');
        $sheet->getStyle('A'.$linea.':J'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':J'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$cuadroInicio.':O'.$linea)->applyFromArray($estiloBorde);

        // Productos Envasados ------------------------------------------------------------------------

        $linea++;$linea++;
        $cuadroInicio = $linea;
        $sheet->setCellValue('A'.$linea, 'PRODUCTOS ENVASADOS');
        $sheet->mergeCells('A'.$linea .':E'.$linea);
        $sheet->getStyle('A'.$linea.':E'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF0070C0');
        $sheet->getStyle('A'.$linea.':E'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->setCellValue('F'.$linea, 'DETALLES');
        $sheet->mergeCells('F'.$linea .':H'.$linea);
        $sheet->setCellValue('I'.$linea, 'PRESENTACIÓN');
        $sheet->mergeCells('I'.$linea .':K'.$linea);
        $sheet->setCellValue('L'.$linea, 'PRODUCCIÓN');
        $sheet->mergeCells('L'.$linea .':O'.$linea);
        $sheet->setCellValue('P'.$linea, 'RENDIMIENTOS');
        $sheet->mergeCells('P'.$linea .':R'.$linea);
        $sheet->getStyle('A'.$linea.':R'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$linea.':R'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':R'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER);

        $linea++;
        $sheet->setCellValue('A'.$linea, 'Código Trazabilidad');
        $sheet->mergeCells('A'.$linea .':B'.$linea);
        $sheet->setCellValue('C'.$linea, 'Descripción del Producto');
        $sheet->mergeCells('C'.$linea .':E'.$linea);
        $sheet->setCellValue('F'.$linea, 'Mat. Prima y/o Destinos');
        $sheet->setCellValue('G'.$linea, 'Calidad');
        $sheet->setCellValue('H'.$linea, 'Sobre peso');
        $sheet->setCellValue('I'.$linea, 'Envase');
        $sheet->setCellValue('J'.$linea, 'Códigos');
        $sheet->setCellValue('K'.$linea, 'Peso unit.');
        $sheet->setCellValue('L'.$linea, 'Sacos');
        $sheet->setCellValue('M'.$linea, 'Blocks');
        $sheet->setCellValue('N'.$linea, 'O/Weight');
        $sheet->setCellValue('O'.$linea, 'Kilos');
        $sheet->setCellValue('P'.$linea, 'Parcial');
        $sheet->setCellValue('Q'.$linea, 'Total');
        $sheet->mergeCells('Q'.$linea .':R'.$linea);
        $sheet->getStyle('A'.$linea.':R'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$linea.':R'.$linea)
        ->getAlignment()
        ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':R'.$linea)
        ->getAlignment()
        ->setVertical(StyleAlignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$linea.':R'.$linea)->getAlignment()->setWrapText(true);

        $pProceso = Detparte::with('trazabilidad')
            ->join('trazabilidads','detpartes.trazabilidad_id','trazabilidads.id')
            ->where('detpartes.parte_id',$parte->id)
            ->groupBy('trazabilidads.pproceso_id')
            ->selectRaw('trazabilidads.pproceso_id, count(trazabilidads.pproceso_id) as cantidad, sum(detpartes.parcial) as total')
            ->orderBy('trazabilidads.pproceso_id')
            ->get();

        foreach ($pProceso as $pp) {
            $linea++;
            $inicioPP = $linea;
            $pProcesoNombre = Pproceso::where('id',$pp->pproceso_id)->value('nombre');
            $sheet->setCellValue('C'.$linea, $pProcesoNombre);
            $sheet->setCellValue('Q'.$linea, $pp->total);
            $productos = Detparte::whereRelation('trazabilidad','pproceso_id','=',$pp->pproceso_id)
                ->where('parte_id', $parte->id)
                ->groupBy('trazabilidad_id')
                ->selectRaw('trazabilidad_id, count(trazabilidad_id) as cantidad,sum(parcial) as total')
                ->orderBy('trazabilidad_id')
                ->get();
            $linea--;
            foreach($productos as $det) {
                $trazabilidad = Trazabilidad::find($det->trazabilidad_id);
                $linea++;
                $sheet->setCellValue('A'.$linea, $trazabilidad->nombre);
                $lineaInicio = $linea;
                $codigos = Detparte::with(['dettrazabilidad'])
                    ->where('parte_id', $parte->id)
                    ->where('trazabilidad_id',$trazabilidad->id)
                    ->get();
                foreach($codigos as $codigo){
                    $sheet->setCellValue('F'.$linea, $codigo->dettrazabilidad->mpd->nombre);
                    $sheet->setCellValue('G'.$linea, $codigo->dettrazabilidad->calidad == 1?'Export':'M.N.');
                    $sheet->setCellValue('H'.$linea, $codigo->dettrazabilidad->sobrepeso.'%');
                    $sheet->setCellValue('I'.$linea, $codigo->dettrazabilidad->envase == 1?'Sacos':'Blocks');
                    $sheet->setCellValue('J'.$linea, $codigo->dettrazabilidad->codigo);
                    $sheet->setCellValue('K'.$linea, $codigo->dettrazabilidad->peso);
                    $sheet->setCellValue('L'.$linea, $codigo->sacos);
                    $sheet->setCellValue('M'.$linea, $codigo->blocks);
                    $sheet->setCellValue('N'.$linea, $codigo->sobrepeso);
                    $sheet->setCellValue('O'.$linea, $codigo->total);
                    $sheet->setCellValue('P'.$linea, $codigo->parcial);
                    $sheet->getStyle('F'.$lineaInicio.':P'.$linea)
                        ->getAlignment()
                        ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('F'.$lineaInicio.':P'.$linea)
                        ->getAlignment()
                        ->setVertical(StyleAlignment::VERTICAL_CENTER);
                    $linea++;
                }
                $linea--;
                $sheet->mergeCells('A'.$lineaInicio.':B'.$linea);
                $sheet->getStyle('A'.$lineaInicio.':B'.$linea)
                    ->getAlignment()
                    ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A'.$lineaInicio.':B'.$linea)
                    ->getAlignment()
                    ->setVertical(StyleAlignment::VERTICAL_CENTER);
            }
            $sheet->mergeCells('C'.$inicioPP.':E'.$linea);
            $sheet->getStyle('C'.$inicioPP.':E'.$linea)
                ->getAlignment()
                ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C'.$inicioPP.':E'.$linea)
                ->getAlignment()
                ->setVertical(StyleAlignment::VERTICAL_CENTER);
            
            $sheet->mergeCells('Q'.$inicioPP.':R'.$linea);
            $sheet->getStyle('Q'.$inicioPP.':R'.$linea)
                ->getAlignment()
                ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
            $sheet->getStyle('Q'.$inicioPP.':R'.$linea)
                ->getAlignment()
                ->setVertical(StyleAlignment::VERTICAL_CENTER);
        }
        $linea++;
        $sheet->setCellValue('A'.$linea, 'TOTAL PRODUCCION (KGS.)');
        $sheet->mergeCells('A'.$linea .':K'.$linea);
        $sheet->setCellValue('L'.$linea, $parte->sacos);
        $sheet->setCellValue('M'.$linea, $parte->blocks);
        $sheet->setCellValue('N'.$linea, $parte->sobrepeso);
        $sheet->setCellValue('O'.$linea, $parte->envasado);
        $sheet->setCellValue('P'.$linea, $parte->detpartes->sum('parcial').'%');
        $sheet->mergeCells('P'.$linea .':R'.$linea);
        $sheet->getStyle('A'.$lineaInicio.':R'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$lineaInicio.':R'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$linea.':R'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.($cuadroInicio+2).':R'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD9E1F2');
        $sheet->getStyle('A'.$cuadroInicio.':R'.$linea)->applyFromArray($estiloBorde);

        // Productos Terminados ------------------------------------------------------------------------
        $linea++;$linea++;
        $cuadroInicio = $linea;
        $sheet->setCellValue('A'.$linea, 'PRODUCTOS TERMINADOS');
        $sheet->mergeCells('A'.$linea .':E'.$linea);
        $sheet->getStyle('A'.$linea.':E'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF0070C0');
        $sheet->getStyle('A'.$linea.':E'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->setCellValue('F'.$linea, 'DETALLES');
        $sheet->mergeCells('F'.$linea .':H'.$linea);
        $sheet->setCellValue('I'.$linea, 'PRESENTACIÓN');
        $sheet->mergeCells('I'.$linea .':K'.$linea);
        $sheet->setCellValue('L'.$linea, 'PRODUCCIÓN');
        $sheet->mergeCells('L'.$linea .':O'.$linea);
        $sheet->setCellValue('P'.$linea, 'RENDIMIENTOS');
        $sheet->mergeCells('P'.$linea .':R'.$linea);
        $sheet->setCellValue('S'.$linea, 'OBSERVACIONES');
        $sheet->getStyle('A'.$linea.':U'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$linea.':U'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':U'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER);

        $linea++;
        $sheet->setCellValue('A'.$linea, 'Código Trazabilidad');
        $sheet->mergeCells('A'.$linea .':B'.$linea);
        $sheet->setCellValue('C'.$linea, 'Descripción del Producto');
        $sheet->mergeCells('C'.$linea .':E'.$linea);
        $sheet->setCellValue('F'.$linea, 'Mat. Prima y/o Destinos');
        $sheet->setCellValue('G'.$linea, 'Calidad');
        $sheet->setCellValue('H'.$linea, 'Sobre peso');
        $sheet->setCellValue('I'.$linea, 'Envase');
        $sheet->setCellValue('J'.$linea, 'Códigos');
        $sheet->setCellValue('K'.$linea, 'Peso unit.');
        $sheet->setCellValue('L'.$linea, 'Sacos');
        $sheet->setCellValue('M'.$linea, 'Blocks');
        $sheet->setCellValue('N'.$linea, 'O/Weight');
        $sheet->setCellValue('O'.$linea, 'Kilos');
        $sheet->setCellValue('P'.$linea, 'Parcial');
        $sheet->setCellValue('Q'.$linea, 'Total');
        $sheet->mergeCells('Q'.$linea .':R'.$linea);
        $sheet->mergeCells('S'.($linea-1) .':U'.$linea);
        $sheet->getStyle('A'.$linea.':U'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$linea.':U'.$linea)
        ->getAlignment()
        ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':U'.$linea)
        ->getAlignment()
        ->setVertical(StyleAlignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$linea.':U'.$linea)->getAlignment()->setWrapText(true);

        $pProceso = Detpartecamara::with('trazabilidad')
            ->join('trazabilidads','detpartecamaras.trazabilidad_id','trazabilidads.id')
            ->where('detpartecamaras.parte_id',$parte->id)
            ->groupBy('trazabilidads.pproceso_id')
            ->selectRaw('trazabilidads.pproceso_id, count(trazabilidads.pproceso_id) as cantidad, sum(detpartecamaras.parcial) as total')
            ->orderBy('trazabilidads.pproceso_id')
            ->get();

        foreach ($pProceso as $pp) {
            $linea++;
            $inicioPP = $linea;
            $pProcesoNombre = Pproceso::where('id',$pp->pproceso_id)->value('nombre');
            $sheet->setCellValue('C'.$linea, $pProcesoNombre);
            $sheet->setCellValue('Q'.$linea, $pp->total);
            $productos = Detpartecamara::whereRelation('trazabilidad','pproceso_id','=',$pp->pproceso_id)
                ->where('parte_id', $parte->id)
                ->groupBy('trazabilidad_id')
                ->selectRaw('trazabilidad_id, count(trazabilidad_id) as cantidad,sum(parcial) as total')
                ->orderBy('trazabilidad_id')
                ->get();
            $linea--;
            foreach($productos as $det) {
                $trazabilidad = Trazabilidad::find($det->trazabilidad_id);
                $linea++;
                $sheet->setCellValue('A'.$linea, $trazabilidad->nombre);
                $lineaInicio = $linea;
                $codigos = Detpartecamara::with(['dettrazabilidad'])
                    ->where('parte_id', $parte->id)
                    ->where('trazabilidad_id',$trazabilidad->id)
                    ->get();
                foreach($codigos as $codigo){
                    $sheet->setCellValue('F'.$linea, $codigo->dettrazabilidad->mpd->nombre);
                    $sheet->setCellValue('G'.$linea, $codigo->dettrazabilidad->calidad == 1?'Export':'M.N.');
                    $sheet->setCellValue('H'.$linea, $codigo->dettrazabilidad->sobrepeso.'%');
                    $sheet->setCellValue('I'.$linea, $codigo->dettrazabilidad->envase == 1?'Sacos':'Blocks');
                    $sheet->setCellValue('J'.$linea, $codigo->dettrazabilidad->codigo);
                    $sheet->setCellValue('K'.$linea, $codigo->dettrazabilidad->peso);
                    $sheet->setCellValue('L'.$linea, $codigo->sacos);
                    $sheet->setCellValue('M'.$linea, $codigo->blocks);
                    $sheet->setCellValue('N'.$linea, $codigo->sobrepeso);
                    $sheet->setCellValue('O'.$linea, $codigo->total);
                    $sheet->setCellValue('P'.$linea, $codigo->parcial);
                    $sheet->setCellValue('S'.$linea, $codigo->observaciones);
                    $sheet->mergeCells('S'.$linea .':U'.$linea);
                    $sheet->getStyle('F'.$lineaInicio.':U'.$linea)
                        ->getAlignment()
                        ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('F'.$lineaInicio.':U'.$linea)
                        ->getAlignment()
                        ->setVertical(StyleAlignment::VERTICAL_CENTER);
                    $linea++;
                }
                $linea--;
                $sheet->mergeCells('A'.$lineaInicio.':B'.$linea);
                $sheet->getStyle('A'.$lineaInicio.':B'.$linea)
                    ->getAlignment()
                    ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A'.$lineaInicio.':B'.$linea)
                    ->getAlignment()
                    ->setVertical(StyleAlignment::VERTICAL_CENTER);
            }
            $sheet->mergeCells('C'.$inicioPP.':E'.$linea);
            $sheet->getStyle('C'.$inicioPP.':E'.$linea)
                ->getAlignment()
                ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C'.$inicioPP.':E'.$linea)
                ->getAlignment()
                ->setVertical(StyleAlignment::VERTICAL_CENTER);
            
            $sheet->mergeCells('Q'.$inicioPP.':R'.$linea);
            $sheet->getStyle('Q'.$inicioPP.':R'.$linea)
                ->getAlignment()
                ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
            $sheet->getStyle('Q'.$inicioPP.':R'.$linea)
                ->getAlignment()
                ->setVertical(StyleAlignment::VERTICAL_CENTER);
        }
        $linea++;
        $sheet->setCellValue('A'.$linea, 'TOTAL PRODUCCION (KGS.)');
        $sheet->mergeCells('A'.$linea .':K'.$linea);
        $sheet->setCellValue('L'.$linea, $parte->detpartecamaras->sum('sacos'));
        $sheet->setCellValue('M'.$linea, $parte->detpartecamaras->sum('blocks'));
        $sheet->setCellValue('N'.$linea, $parte->detpartecamaras->sum('sobrepeso'));
        $sheet->setCellValue('O'.$linea, $parte->detpartecamaras->sum('total'));
        $sheet->setCellValue('P'.$linea, $parte->detpartecamaras->sum('parcial').'%');
        // $sheet->setCellValue('P'.$linea, $parte->detpartecamaras->sum('parcial').'%');
        $sheet->mergeCells('P'.$linea .':R'.$linea);
        $sheet->mergeCells('S'.$linea .':U'.$linea);
        $sheet->getStyle('A'.$lineaInicio.':U'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$lineaInicio.':U'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$linea.':U'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$cuadroInicio.':U'.$linea)->applyFromArray($estiloBorde);

        // CONSUMOS ALMACEM ------------------------------------------------------------------------
        $linea++;$linea++;
        $cuadroInicio = $linea;
        $sheet->setCellValue('A'.$linea, 'MATERIALES E INSUMOS');
        $sheet->mergeCells('A'.$linea .':E'.$linea);
        $sheet->getStyle('A'.$linea.':E'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF0070C0');
        $sheet->getStyle('A'.$linea.':E'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->setCellValue('F'.$linea, 'UNIDAD MEDIDA');
        $sheet->mergeCells('F'.$linea .':G'.$linea);
        $sheet->setCellValue('H'.$linea, 'SOLICITADO');
        $sheet->setCellValue('I'.$linea, 'DEVUELTO');
        $sheet->setCellValue('J'.$linea, 'ENTREGADO');
        $sheet->getStyle('A'.$linea.':J'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$linea.':J'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':J'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER);
        foreach ($parte->detparteproductos as $det) {
            $linea++;
            $sheet->setCellValue('A'.$linea, $det->producto->nombre);
            $sheet->mergeCells('A'.$linea .':E'.$linea);
            $sheet->setCellValue('F'.$linea, $det->producto->umedida->nombre);
            $sheet->mergeCells('F'.$linea .':G'.$linea);
            $sheet->setCellValue('H'.$linea, $det->solicitado);
            $sheet->setCellValue('I'.$linea, $det->devuelto );
            $sheet->setCellValue('J'.$linea, $det->entregado );
        }
        $sheet->getStyle('A'.$cuadroInicio.':J'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$cuadroInicio.':J'.$linea)->applyFromArray($estiloBorde);

        // GUÍAS------------------------------------------------------------------------
        $linea++;$linea++;
        $cuadroInicio = $linea;
        $sheet->setCellValue('A'.$linea, 'PLANILLAS DE ENVASADO');
        $sheet->mergeCells('A'.$linea .':D'.$linea);
        $sheet->setCellValue('E'.$linea, $parte->guias_envasado);
        $sheet->mergeCells('E'.$linea .':J'.$linea);
        $linea++;
        $sheet->setCellValue('A'.$linea, 'PLANILLAS DE ENVASADO CRUDO');
        $sheet->mergeCells('A'.$linea .':D'.$linea);
        $sheet->setCellValue('E'.$linea, $parte->guias_envasado_crudo);
        $sheet->mergeCells('E'.$linea .':J'.$linea);
        $linea++;
        $sheet->setCellValue('A'.$linea, 'GUÍAS DE INGRESO A CÁMARAS');
        $sheet->mergeCells('A'.$linea .':D'.$linea);
        $sheet->setCellValue('E'.$linea, $parte->guias_camara);
        $sheet->mergeCells('E'.$linea .':J'.$linea);
        $linea++;
        $sheet->setCellValue('A'.$linea, 'CONSUMOS ALMACÉN');
        $sheet->mergeCells('A'.$linea .':D'.$linea);
        $sheet->setCellValue('E'.$linea, $parte->guias_almacen);
        $sheet->mergeCells('E'.$linea .':J'.$linea);
        $linea++;
        $sheet->setCellValue('A'.$linea, 'GUÍAS DE RESIDUOS SÓLIDOS');
        $sheet->mergeCells('A'.$linea .':D'.$linea);
        $sheet->setCellValue('E'.$linea, $parte->guias_residuos);
        $sheet->mergeCells('E'.$linea .':J'.$linea);
        $sheet->getStyle('A'.$cuadroInicio.':J'.$linea)->applyFromArray($estiloBorde);
        $sheet->getStyle('A'.$cuadroInicio.':A'.$linea)->getFont()->setSize(9)->setBold(true);

        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(14);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(12);
        $sheet->getColumnDimension('K')->setWidth(12);
        $sheet->getColumnDimension('L')->setWidth(12);
        $sheet->getColumnDimension('M')->setWidth(12);
        $sheet->getColumnDimension('N')->setWidth(12);
        $sheet->getColumnDimension('O')->setWidth(12);
        $sheet->getColumnDimension('P')->setWidth(12);
        $sheet->getColumnDimension('Q')->setWidth(12);
        //Envio de Archivo para Descarga
        $fileName="Parte".$parte->lote.".xlsx";
        # Crear un "escritor"
        $writer = new Xlsx($excel);
        # Le pasamos la ruta de guardado
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
        
    }

    public function partecontrata(Parte $parte)
    {
        $materiaPrimas = Materiaprima::whereIn('lote',json_decode($parte->lotes))->orderBy('ticket_balanza')->get();
        $mpObtenidas = Mpobtenida::get();
        $empresa = Empresa::findOrFail($parte->empresa_id);
        $enombre = Embarcacion::pluck('nombre','id');
        $ematricula = Embarcacion::pluck('matricula','id');
        $eprotocolo = Embarcacion::pluck('protocolo','id');
        $ecapacidad = Embarcacion::pluck('capacidad','id');
        $totalMateriaPrima = $materiaPrimas->sum('pplanta');
        $salto = "\r\n";
        //Creación de Excel
        $excel = new Spreadsheet();

        //Información del Archivo
        $excel
            ->getProperties()
            ->setCreator("Pesquera HL")
            ->setLastModifiedBy('Proceso')
            ->setTitle('Parte de Producción')
            ->setSubject('Parte de Producción')
            ->setDescription('Reporte de Parte de Producción')
            ->setKeywords('Parte')
            ->setCategory('Categoría Excel');

        //Fuente y Tamaño por defecto
        $excel
            ->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(8);
        
        $estiloBorde = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        //Creación de Hoja y Llenado de Información
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle("Parte de Producción");
        $linea = 1;
        // Logo
        $logo = new Drawing();
        $logo->setName('Logo');
        $logo->setDescription('Logo');
        $logo->setPath('./static/images/logopesquera.jpeg');
        $logo->setCoordinates('A'.$linea);
        $logo->setHeight(60);
        // $logo->setOffsetX(110);
        // $logo->setRotation(25);
        // $logo->getShadow()->setVisible(true);
        // $logo->getShadow()->setDirection(45);
        $logo->setWorksheet($excel->getActiveSheet());
        $sheet->setCellValue('P'.$linea, 'N°');
        $sheet->setCellValue('Q'.$linea, $parte->lote);
        $sheet->mergeCells('Q'.$linea .':R'.$linea);
        $sheet->getStyle('P'.$linea.':R'.$linea)->applyFromArray($estiloBorde);
        $sheet->getStyle('P'.$linea.':R'.$linea)->getFont()->setSize(10)->setBold(true);
        $linea++;
        $sheet->setCellValue('P'.$linea, 'TURNO');
        $sheet->setCellValue('Q'.$linea, $parte->turno==1?'DIA':'NOCHE');
        $sheet->mergeCells('Q'.$linea .':R'.$linea);
        $sheet->getStyle('P'.$linea.':R'.$linea)->applyFromArray($estiloBorde);
        $sheet->getStyle('P'.$linea.':R'.$linea)->getFont()->setSize(10)->setBold(true);
        $linea++;
        $linea++;
        $linea++;
        $sheet->setCellValue('A'.$linea,'PARTE DE PRODUCCIÓN DE CONGELADOS DE POTA');
        $sheet->mergeCells('A'.$linea .':R'.$linea);
        $sheet->getStyle('A'.$linea)->getFont()->setSize(16)->setBold(true);
        $sheet->getStyle('A'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
 
        // $sheet->getStyle('I')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        $sheet->getStyle('K:O')->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('P:S')->getNumberFormat()->setFormatCode('#,##0.00');
        
        // Productos Terminados ------------------------------------------------------------------------
        $linea++;$linea++;
        $cuadroInicio = $linea;
        $sheet->setCellValue('A'.$linea, 'PRODUCTOS TERMINADOS');
        $sheet->mergeCells('A'.$linea .':E'.$linea);
        $sheet->getStyle('A'.$linea.':E'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF0070C0');
        $sheet->getStyle('A'.$linea.':E'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->setCellValue('F'.$linea, 'DETALLES');
        $sheet->mergeCells('F'.$linea .':H'.$linea);
        $sheet->setCellValue('I'.$linea, 'PRESENTACIÓN');
        $sheet->mergeCells('I'.$linea .':K'.$linea);
        $sheet->setCellValue('L'.$linea, 'PRODUCCIÓN');
        $sheet->mergeCells('L'.$linea .':O'.$linea);
        $sheet->setCellValue('P'.$linea, 'CONTRATA');
        $sheet->mergeCells('P'.$linea .':S'.$linea);
        $sheet->getStyle('A'.$linea.':S'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$linea.':S'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':S'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER);

        $linea++;
        $sheet->setCellValue('A'.$linea, 'Código Trazabilidad');
        $sheet->mergeCells('A'.$linea .':B'.$linea);
        $sheet->setCellValue('C'.$linea, 'Descripción del Producto');
        $sheet->mergeCells('C'.$linea .':E'.$linea);
        $sheet->setCellValue('F'.$linea, 'Mat. Prima y/o Destinos');
        $sheet->setCellValue('G'.$linea, 'Calidad');
        $sheet->setCellValue('H'.$linea, 'Sobre peso');
        $sheet->setCellValue('I'.$linea, 'Envase');
        $sheet->setCellValue('J'.$linea, 'Códigos');
        $sheet->setCellValue('K'.$linea, 'Peso unit.');
        $sheet->setCellValue('L'.$linea, 'Sacos');
        $sheet->setCellValue('M'.$linea, 'Blocks');
        $sheet->setCellValue('N'.$linea, 'O/Weight');
        $sheet->setCellValue('O'.$linea, 'Kilos');
        $sheet->setCellValue('P'.$linea, 'Precio US$');
        $sheet->setCellValue('Q'.$linea, 'Monto US$');
        $sheet->setCellValue('R'.$linea, 'Precio S/');
        $sheet->setCellValue('S'.$linea, 'Monto S/');
        // $sheet->mergeCells('Q'.$linea .':R'.$linea);
        // $sheet->mergeCells('S'.($linea-1) .':U'.$linea);
        $sheet->getStyle('A'.$linea.':S'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$linea.':S'.$linea)
        ->getAlignment()
        ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':S'.$linea)
        ->getAlignment()
        ->setVertical(StyleAlignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$linea.':S'.$linea)->getAlignment()->setWrapText(true);

        $pProceso = Detpartecamara::with('trazabilidad')
            ->join('trazabilidads','detpartecamaras.trazabilidad_id','trazabilidads.id')
            ->where('detpartecamaras.parte_id',$parte->id)
            ->groupBy('trazabilidads.pproceso_id')
            ->selectRaw('trazabilidads.pproceso_id, count(trazabilidads.pproceso_id) as cantidad, sum(detpartecamaras.parcial) as total')
            ->orderBy('trazabilidads.pproceso_id')
            ->get();

        foreach ($pProceso as $pp) {
            $linea++;
            $inicioPP = $linea;
            $pProcesoNombre = Pproceso::where('id',$pp->pproceso_id)->value('nombre');
            $sheet->setCellValue('C'.$linea, $pProcesoNombre);
            // $sheet->setCellValue('Q'.$linea, $pp->total);
            $productos = Detpartecamara::whereRelation('trazabilidad','pproceso_id','=',$pp->pproceso_id)
                ->where('parte_id', $parte->id)
                ->groupBy('trazabilidad_id')
                ->selectRaw('trazabilidad_id, count(trazabilidad_id) as cantidad,sum(parcial) as total')
                ->orderBy('trazabilidad_id')
                ->get();
            $linea--;
            foreach($productos as $det) {
                $trazabilidad = Trazabilidad::find($det->trazabilidad_id);
                $linea++;
                $sheet->setCellValue('A'.$linea, $trazabilidad->nombre);
                $lineaInicio = $linea;
                $codigos = Detpartecamara::with(['dettrazabilidad'])
                    ->where('parte_id', $parte->id)
                    ->where('trazabilidad_id',$trazabilidad->id)
                    ->get();
                foreach($codigos as $codigo){
                    $sheet->setCellValue('F'.$linea, $codigo->dettrazabilidad->mpd->nombre);
                    $sheet->setCellValue('G'.$linea, $codigo->dettrazabilidad->calidad == 1?'Export':'M.N.');
                    $sheet->setCellValue('H'.$linea, $codigo->dettrazabilidad->sobrepeso.'%');
                    $sheet->setCellValue('I'.$linea, $codigo->dettrazabilidad->envase == 1?'Sacos':'Blocks');
                    $sheet->setCellValue('J'.$linea, $codigo->dettrazabilidad->codigo);
                    $sheet->setCellValue('K'.$linea, $codigo->dettrazabilidad->peso);
                    $sheet->setCellValue('L'.$linea, $codigo->sacos);
                    $sheet->setCellValue('M'.$linea, $codigo->blocks);
                    $sheet->setCellValue('N'.$linea, $codigo->sobrepeso);
                    $sheet->setCellValue('O'.$linea, $codigo->total);
                    $sheet->setCellValue('P'.$linea, $codigo->dettrazabilidad->precio);
                    $sheet->setCellValue('Q'.$linea, round($codigo->dettrazabilidad->precio*$codigo->total,2));
                    $sheet->setCellValue('R'.$linea, round($codigo->dettrazabilidad->precio*$parte->tc,2));
                    $sheet->setCellValue('S'.$linea, round(($codigo->dettrazabilidad->precio*$codigo->total)*$parte->tc,2));
                    // $sheet->setCellValue('S'.$linea, $codigo->observaciones);
                    // $sheet->mergeCells('S'.$linea .':U'.$linea);
                    $sheet->getStyle('F'.$lineaInicio.':S'.$linea)
                        ->getAlignment()
                        ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('F'.$lineaInicio.':S'.$linea)
                        ->getAlignment()
                        ->setVertical(StyleAlignment::VERTICAL_CENTER);
                    $linea++;
                }
                $linea--;
                $sheet->mergeCells('A'.$lineaInicio.':B'.$linea);
                $sheet->getStyle('A'.$lineaInicio.':B'.$linea)
                    ->getAlignment()
                    ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A'.$lineaInicio.':B'.$linea)
                    ->getAlignment()
                    ->setVertical(StyleAlignment::VERTICAL_CENTER);
            }
            $sheet->mergeCells('C'.$inicioPP.':E'.$linea);
            $sheet->getStyle('C'.$inicioPP.':E'.$linea)
                ->getAlignment()
                ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C'.$inicioPP.':E'.$linea)
                ->getAlignment()
                ->setVertical(StyleAlignment::VERTICAL_CENTER);
            
            // $sheet->mergeCells('Q'.$inicioPP.':R'.$linea);
            // $sheet->getStyle('Q'.$inicioPP.':R'.$linea)
            //     ->getAlignment()
            //     ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
            // $sheet->getStyle('Q'.$inicioPP.':R'.$linea)
            //     ->getAlignment()
            //     ->setVertical(StyleAlignment::VERTICAL_CENTER);
        }
        $linea++;
        $sheet->setCellValue('A'.$linea, 'TOTAL PRODUCCION (KGS.)');
        $sheet->mergeCells('A'.$linea .':K'.$linea);
        $sheet->setCellValue('L'.$linea, $parte->detpartecamaras->sum('sacos'));
        $sheet->setCellValue('M'.$linea, $parte->detpartecamaras->sum('blocks'));
        $sheet->setCellValue('N'.$linea, $parte->detpartecamaras->sum('sobrepeso'));
        $sheet->setCellValue('O'.$linea, $parte->detpartecamaras->sum('total'));
        $sheet->setCellValue('Q'.$linea, round($parte->manoobra/$parte->tc,2));
        $sheet->setCellValue('S'.$linea, $parte->manoobra);
        // $sheet->setCellValue('P'.$linea, $parte->detpartecamaras->sum('parcial').'%');
        // $sheet->mergeCells('P'.$linea .':R'.$linea);
        // $sheet->mergeCells('S'.$linea .':U'.$linea);
        $sheet->getStyle('A'.$lineaInicio.':S'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$lineaInicio.':S'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER);
        $sheet->getStyle('A'.$linea.':S'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$cuadroInicio.':S'.$linea)->applyFromArray($estiloBorde);

        
        // GUÍAS------------------------------------------------------------------------
        $linea++;$linea++;
        $cuadroInicio = $linea;
        $sheet->setCellValue('A'.$linea, 'GUÍAS DE INGRESO A CÁMARAS');
        $sheet->mergeCells('A'.$linea .':D'.$linea);
        $sheet->setCellValue('E'.$linea, $parte->guias_camara);
        $sheet->mergeCells('E'.$linea .':J'.$linea);

        $sheet->getStyle('A'.$cuadroInicio.':J'.$linea)->applyFromArray($estiloBorde);
        $sheet->getStyle('A'.$cuadroInicio.':A'.$linea)->getFont()->setSize(9)->setBold(true);

        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(14);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(12);
        $sheet->getColumnDimension('K')->setWidth(12);
        $sheet->getColumnDimension('L')->setWidth(12);
        $sheet->getColumnDimension('M')->setWidth(12);
        $sheet->getColumnDimension('N')->setWidth(12);
        $sheet->getColumnDimension('O')->setWidth(12);
        $sheet->getColumnDimension('P')->setWidth(12);
        $sheet->getColumnDimension('Q')->setWidth(12);
        $sheet->getColumnDimension('R')->setWidth(12);
        $sheet->getColumnDimension('S')->setWidth(12);
        //Envio de Archivo para Descarga
        $fileName="Contrata-Lote".$parte->lote.".xlsx";
        # Crear un "escritor"
        $writer = new Xlsx($excel);
        # Le pasamos la ruta de guardado
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
        
    }
    
    public function residuos(Request $request)
    {
        $residuos = Residuo::whereMonth('emision',$request->input('mes'))
            ->whereYear('emision',$request->input('anio'))
            ->get();
        $empresa = Empresa::findOrFail(session('empresa'));
        //Creación de Excel
        $excel = new Spreadsheet();

        //Información del Archivo
        $excel
            ->getProperties()
            ->setCreator($empresa->razsoc)
            ->setLastModifiedBy('Proceso')
            ->setTitle('Control Residuos Sólidos')
            ->setSubject('Residios Solidos por Mes')
            ->setDescription('Residios Solidos por Mes')
            ->setKeywords('RSolidos')
            ->setCategory('Categoría Excel');

        //Fuente y Tamaño por defecto
        $excel
            ->getDefaultStyle()
            ->getFont()
            ->setName('Calibri')
            ->setSize(9);

        //Creación de Hoja y Llenado de Información
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle("RESIDUOS SÓLIDOS ".getMes($request->input('mes')).' - '.$request->input('anio'));
        $linea = 1;
        // Logo
        $logo = new Drawing();
        $logo->setName('Logo');
        $logo->setDescription('Logo');
        $logo->setPath('./static/images/logopesquera.jpeg');
        $logo->setCoordinates('A'.$linea);
        $logo->setHeight(60);
        $logo->setWorksheet($excel->getActiveSheet());

        $linea++;$linea++;
        $salto = "\r\n";

        $sheet->setCellValue('A'.$linea,'CONTROL DE RESIDUOS SÓLIDOS '.getMes($request->input('mes')).' - '.$request->input('anio'));
        $sheet->getStyle('A'.$linea)->getFont()->getColor()->setARGB('FF000080');
        $sheet->mergeCells('A'.$linea.':N'.$linea);
        $sheet->getStyle('A'.$linea)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $linea++;$linea++;
        // $sheet->getStyle('I')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        $sheet->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.0000');
        $sheet->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00');

        $sheet->setCellValue('A'.$linea,'N°');
        $sheet->setCellValue('B'.$linea,'FECHA'.$salto.'RECEPCIÓN');
        $sheet->setCellValue('C'.$linea,'LOTE');
        $sheet->setCellValue('D'.$linea,'ESPECIE');
        $sheet->setCellValue('E'.$linea,'TM');
        $sheet->setCellValue('F'.$linea,'EMPRESA');
        $sheet->setCellValue('G'.$linea,'EMPRESA RESIDUOS');
        $sheet->setCellValue('H'.$linea,'REPORTE DE'.$salto.'PESAJE N°');
        $sheet->setCellValue('I'.$linea,'FECHA'.$salto.'EMISIÓN');
        $sheet->setCellValue('J'.$linea,'N° GUÍA'.$salto.'MPS');
        $sheet->setCellValue('K'.$linea,'N° GUÍA'.$salto.'HL');
        $sheet->setCellValue('L'.$linea,'N° GUÍA'.$salto.'TRANSPORTISTA');
        $sheet->setCellValue('M'.$linea,'TOTAL KGS');
        $sheet->setCellValue('N'.$linea,'N° DE'.$salto.'PLACA');
        $sheet->getStyle('A'.$linea.':N'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER)
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':N'.$linea)->getFont()->setBold(true);
        $sheet->getStyle('A'.$linea.':N'.$linea)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.$linea.':N'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A'.$linea.':N'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF000080');


        //Detalles
        $color = 1;
        $pesoMateriaPrima = 0;
        $pesoAcumulado = 0;
        $cuadroInicio = $linea + 1;
        foreach($residuos as $residuo) {
            $linea++;
            $parte = Parte::where('lote',$residuo->lote)->first();
            $pesoMateriaPrima += $parte?$parte->materiaprima:0;
            $pesoAcumulado += $residuo->peso;
            $sheet->setCellValue('A'.$linea,$color);
            $sheet->setCellValue('B'.$linea,$parte?$parte->recepcion:'');
            $sheet->setCellValue('C'.$linea,$parte?$parte->lote:'');
            $sheet->setCellValue('D'.$linea,$residuo->especie);
            $sheet->setCellValue('E'.$linea,$parte?$parte->materiaprima/1000:'');
            $sheet->setCellValue('F'.$linea,$empresa->razsoc);
            $sheet->setCellValue('G'.$linea,$residuo->cliente->razsoc);
            $sheet->setCellValue('H'.$linea,$residuo->ticket_balanza);
            $sheet->setCellValue('I'.$linea,$residuo->emision);
            $sheet->setCellValue('J'.$linea,$residuo->guiamps);
            $sheet->setCellValue('K'.$linea,$residuo->guiahl);
            $sheet->setCellValue('L'.$linea,$residuo->guiatrasporte);
            $sheet->setCellValue('M'.$linea,$residuo->peso);
            $sheet->setCellValue('N'.$linea,$residuo->placa);
            $color++;
        }
        $linea++;
        $sheet->mergeCells('A'.$linea.':D'.$linea);
        $sheet->setCellValue('E'.$linea, $pesoMateriaPrima/1000);
        $sheet->setCellValue('F'.$linea, 'TOTAL');
        $sheet->mergeCells('F'.$linea.':L'.$linea);
        $sheet->setCellValue('M'.$linea, $pesoAcumulado);
        $sheet->getStyle('A'.$linea.':N'.$linea)
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FFEDE739');
        $sheet->getStyle('F'.$linea.':L'.$linea)
                ->getAlignment()
                ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':N'.$linea)->getFont()->setBold(true);
        
        $estiloBorde = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A'.$cuadroInicio.':N'.$linea)->applyFromArray($estiloBorde);
          
        // Ancho de Columnas
        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(11);
        $sheet->getColumnDimension('C')->setWidth(13);
        $sheet->getColumnDimension('D')->setWidth(8);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(24);
        $sheet->getColumnDimension('H')->setWidth(10);
        $sheet->getColumnDimension('I')->setWidth(11);
        $sheet->getColumnDimension('J')->setWidth(11);
        $sheet->getColumnDimension('K')->setWidth(11);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(10);
        $sheet->getColumnDimension('N')->setWidth(10);

        //Envio de Archivo para Descarga
        $fileName= 'RESIDUOS-'.getMes($request->input('mes')).'-'.$request->input('anio').".xlsx";
        # Crear un "escritor"
        $writer = new Xlsx($excel);
        # Le pasamos la ruta de guardado
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }
    
    public function resumentrazabilidad()
    {
        // $productoterminado = Productoterminado::with(['pproceso:id,nombre'])
        //     ->groupBy('pproceso_id')
        //     ->selectRaw('pproceso_id,sum(saldo) as sacos')
        //     ->get();
        $envase = [1=>'SACO',2=>'BLOCK',3=>'CAJAS'];
        $productoterminado = Productoterminado::with(['pproceso:id,nombre','dettrazabilidad'])
            ->join('dettrazabilidads','productoterminados.dettrazabilidad_id','dettrazabilidads.id')
            ->groupBy(['productoterminados.pproceso_id'])
            ->selectRaw('productoterminados.pproceso_id,sum(productoterminados.saldo) as saldo,sum(productoterminados.saldo*dettrazabilidads.peso) as kilos')
            ->get();

        $empresa = Empresa::findOrFail(session('empresa'));
        //Creación de Excel
        $excel = new Spreadsheet();

        //Información del Archivo
        $excel
            ->getProperties()
            ->setCreator($empresa->razsoc)
            ->setLastModifiedBy('Proceso')
            ->setTitle('Resumen Trazabilidad')
            ->setSubject('Resumen Trazabilidad')
            ->setDescription('Resumen Trazabilidad')
            ->setKeywords('Trazabilidad')
            ->setCategory('Categoría Excel');

        //Fuente y Tamaño por defecto
        $excel
            ->getDefaultStyle()
            ->getFont()
            ->setName('Calibri')
            ->setSize(9);

        //Creación de Hoja y Llenado de Información
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle("RESUMEN TRAZABILIDAD");
        $linea = 1;
        // Logo
        $logo = new Drawing();
        $logo->setName('Logo');
        $logo->setDescription('Logo');
        $logo->setPath('./static/images/logopesquera.jpeg');
        $logo->setCoordinates('A'.$linea);
        $logo->setHeight(60);
        $logo->setWorksheet($excel->getActiveSheet());

        $linea++;$linea++;
        $linea++;$linea++;
        $salto = "\r\n";

        $sheet->setCellValue('A'.$linea,'RESUMEN TRAZABILIDAD');
        $sheet->getStyle('A'.$linea)->getFont()->getColor()->setARGB('FF000080');
        $sheet->mergeCells('A'.$linea.':E'.$linea);
        $sheet->getStyle('A'.$linea)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $linea++;$linea++;
        // $sheet->getStyle('I')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        // $sheet->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.0000');
        $sheet->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00');

        $sheet->setCellValue('A'.$linea,'PRODUCTO');
        $sheet->setCellValue('B'.$linea,'TRAZABILIDAD');
        $sheet->setCellValue('C'.$linea,'ENVASE');
        $sheet->setCellValue('D'.$linea,'CANTIDAD');
        $sheet->setCellValue('E'.$linea,'KILOS');
        $sheet->getStyle('A'.$linea.':E'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER)
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':E'.$linea)->getFont()->setBold(true);
        $sheet->getStyle('A'.$linea.':E'.$linea)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.$linea.':E'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A'.$linea.':E'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF000080');

        $cuadroInicio = $linea + 1;
        foreach ($productoterminado as $producto) {
            $linea++;
            $sheet->setCellValue('A'.$linea,$producto->pproceso->nombre);
            // $trazabilidad = Productoterminado::with('trazabilidad')
            //     ->where('pproceso_id',$producto->pproceso_id)
            //     ->groupBy('trazabilidad_id')
            //     ->selectRaw('trazabilidad_id, sum(saldo) as sacos')
            //     ->orderBy('trazabilidad_id')
            //     ->get();
            $trazabilidad = Productoterminado::with(['trazabilidad','dettrazabilidad'])
                ->join('dettrazabilidads','productoterminados.dettrazabilidad_id','dettrazabilidads.id')
                ->where('pproceso_id',$producto->pproceso_id)
                ->groupBy(['productoterminados.trazabilidad_id','dettrazabilidads.envase','dettrazabilidads.peso'])
                ->selectRaw('productoterminados.trazabilidad_id,dettrazabilidads.envase,dettrazabilidads.peso,sum(productoterminados.saldo) as saldo,sum(productoterminados.saldo*dettrazabilidads.peso) as kilos')
                ->get();
            //Detalles
            $conteo = 0;
            $lineaInicio = $linea;
            foreach($trazabilidad as $det) {
                $sheet->setCellValue('B'.$linea,$det->trazabilidad->nombre);
                $sheet->setCellValue('C'.$linea,$envase[$det->envase]);
                $sheet->setCellValue('D'.$linea,$det->saldo);
                $sheet->setCellValue('E'.$linea,$det->kilos);
                $linea++;
                $conteo++;
            }
            if ($conteo > 1) {
                $sheet->mergeCells('A'.$lineaInicio.':A'.($lineaInicio+$conteo-1));
                $sheet->getStyle('A'.$lineaInicio.':A'.($lineaInicio+$conteo-1))
                    ->getAlignment()
                    ->setVertical(StyleAlignment::VERTICAL_CENTER);
            }
            $linea--;
        }
        
        $linea++;
        $sheet->setCellValue('B'.$linea, 'TOTAL');
        $sheet->setCellValue('D'.$linea, $productoterminado->sum('saldo'));
        $sheet->setCellValue('E'.$linea, $productoterminado->sum('kilos'));
        $sheet->getStyle('A'.$linea.':E'.$linea)
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FFEDE739');
        $sheet->getStyle('A'.$linea.':E'.$linea)->getFont()->setBold(true);
        
        $estiloBorde = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A'.$cuadroInicio.':E'.$linea)->applyFromArray($estiloBorde);
          
        // Ancho de Columnas
        $sheet->getColumnDimension('A')->setWidth(36);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(10);

        //Envio de Archivo para Descarga
        $fileName= 'Resumen-Trazabilidad'.".xlsx";
        # Crear un "escritor"
        $writer = new Xlsx($excel);
        # Le pasamos la ruta de guardado
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }

    public function resumencodigo()
    {
        $envase = [1=>'SACO',2=>'BLOCK',3=>'CAJAS'];
        // $productoterminado = Productoterminado::with(['pproceso:id,nombre'])
        //     ->groupBy('pproceso_id')
        //     ->selectRaw('pproceso_id,sum(saldo) as sacos')
        //     ->get();

        $productoterminado = Productoterminado::with(['pproceso:id,nombre','dettrazabilidad'])
            ->join('dettrazabilidads','productoterminados.dettrazabilidad_id','dettrazabilidads.id')
            ->groupBy(['productoterminados.pproceso_id'])
            ->selectRaw('productoterminados.pproceso_id,sum(productoterminados.saldo) as saldo,sum(productoterminados.saldo*dettrazabilidads.peso) as kilos')
            ->get();

        $empresa = Empresa::findOrFail(session('empresa'));
        //Creación de Excel
        $excel = new Spreadsheet();

        //Información del Archivo
        $excel
            ->getProperties()
            ->setCreator($empresa->razsoc)
            ->setLastModifiedBy('Proceso')
            ->setTitle('Resumen Trazabilidad')
            ->setSubject('Resumen Trazabilidad')
            ->setDescription('Resumen Trazabilidad')
            ->setKeywords('Trazabilidad')
            ->setCategory('Categoría Excel');

        //Fuente y Tamaño por defecto
        $excel
            ->getDefaultStyle()
            ->getFont()
            ->setName('Calibri')
            ->setSize(9);

        //Creación de Hoja y Llenado de Información
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle("RESUMEN X CODIGO");
        $linea = 1;
        // Logo
        $logo = new Drawing();
        $logo->setName('Logo');
        $logo->setDescription('Logo');
        $logo->setPath('./static/images/logopesquera.jpeg');
        $logo->setCoordinates('A'.$linea);
        $logo->setHeight(60);
        $logo->setWorksheet($excel->getActiveSheet());

        $linea++;$linea++;
        $linea++;$linea++;
        $salto = "\r\n";

        $sheet->setCellValue('A'.$linea,'RESUMEN X CÓDIGO');
        $sheet->getStyle('A'.$linea)->getFont()->getColor()->setARGB('FF000080');
        $sheet->mergeCells('A'.$linea.':F'.$linea);
        $sheet->getStyle('A'.$linea)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $linea++;$linea++;
        // $sheet->getStyle('I')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        // $sheet->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.0000');
        $sheet->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00');

        $sheet->setCellValue('A'.$linea,'PRODUCTO');
        $sheet->setCellValue('B'.$linea,'TRAZABILIDAD');
        $sheet->setCellValue('C'.$linea,'CÓDIGO');
        $sheet->setCellValue('D'.$linea,'ENVASE');
        $sheet->setCellValue('E'.$linea,'CANTIDAD');
        $sheet->setCellValue('F'.$linea,'KILOS');
        $sheet->getStyle('A'.$linea.':F'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER)
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':F'.$linea)->getFont()->setBold(true);
        $sheet->getStyle('A'.$linea.':F'.$linea)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.$linea.':F'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A'.$linea.':F'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF000080');

        $cuadroInicio = $linea + 1;
        foreach ($productoterminado as $producto) {
            $linea++;
            $sheet->setCellValue('A'.$linea,$producto->pproceso->nombre);
            $trazabilidad = Productoterminado::with('trazabilidad')
                ->where('pproceso_id',$producto->pproceso_id)
                ->groupBy('trazabilidad_id')
                ->selectRaw('trazabilidad_id, sum(saldo) as sacos')
                ->orderBy('trazabilidad_id')
                ->get();
            //Detalles
            $conteo = 0;
            $lineaInicio = $linea;
            foreach($trazabilidad as $det) {
                $sheet->setCellValue('B'.$linea,$det->trazabilidad->nombre);
                // $dettrazabilidad = Productoterminado::with('dettrazabilidad')
                //     ->where('trazabilidad_id',$det->trazabilidad_id)
                //     ->groupBy('dettrazabilidad_id')
                //     ->selectRaw('dettrazabilidad_id, sum(saldo) as sacos')
                //     ->orderBy('dettrazabilidad_id')
                //     ->get();
                $dettrazabilidad = Productoterminado::with(['dettrazabilidad'])
                    ->join('dettrazabilidads','productoterminados.dettrazabilidad_id','dettrazabilidads.id')
                    ->where('productoterminados.trazabilidad_id',$det->trazabilidad_id)
                    ->groupBy(['productoterminados.dettrazabilidad_id','dettrazabilidads.envase','dettrazabilidads.peso'])
                    ->selectRaw('productoterminados.dettrazabilidad_id,dettrazabilidads.envase,dettrazabilidads.peso,sum(productoterminados.saldo) as saldo,sum(productoterminados.saldo*dettrazabilidads.peso) as kilos')
                    ->get();
                $conteo2 = 0;
                $lineaInicio2 = $linea;
                foreach ($dettrazabilidad as $detalle) {
                    $sheet->setCellValue('C'.$linea,$detalle->dettrazabilidad->mpd_codigo);
                    $sheet->setCellValue('D'.$linea,$envase[$detalle->envase]);
                    $sheet->setCellValue('E'.$linea,$detalle->saldo);
                    $sheet->setCellValue('F'.$linea,$detalle->kilos);
                    $linea++;
                    $conteo++;
                    $conteo2++;
                }
                if ($conteo2 > 1) {
                    $sheet->mergeCells('B'.$lineaInicio2.':B'.($lineaInicio2+$conteo2-1));
                    $sheet->getStyle('B'.$lineaInicio2.':B'.($lineaInicio2+$conteo2-1))
                        ->getAlignment()
                        ->setVertical(StyleAlignment::VERTICAL_CENTER);
                }
                // $linea++;
                // $conteo++;
            }
            if ($conteo > 1) {
                $sheet->mergeCells('A'.$lineaInicio.':A'.($lineaInicio+$conteo-1));
                $sheet->getStyle('A'.$lineaInicio.':A'.($lineaInicio+$conteo-1))
                    ->getAlignment()
                    ->setVertical(StyleAlignment::VERTICAL_CENTER);
            }
            $linea--;
        }
        
        $linea++;
        $sheet->setCellValue('B'.$linea, 'TOTAL');
        $sheet->setCellValue('E'.$linea, $productoterminado->sum('saldo'));
        $sheet->setCellValue('F'.$linea, $productoterminado->sum('kilos'));
        $sheet->getStyle('A'.$linea.':F'.$linea)
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FFEDE739');
        $sheet->getStyle('A'.$linea.':F'.$linea)->getFont()->setBold(true);
        
        $estiloBorde = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A'.$cuadroInicio.':F'.$linea)->applyFromArray($estiloBorde);
          
        // Ancho de Columnas
        $sheet->getColumnDimension('A')->setWidth(36);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(24);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);

        //Envio de Archivo para Descarga
        $fileName= 'Resumen-Codigo'.".xlsx";
        # Crear un "escritor"
        $writer = new Xlsx($excel);
        # Le pasamos la ruta de guardado
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }

    public function detalladoproductoterminado(Request $request)
    {
        $pproceso_id = $request->input('pproceso_id');
        $trazabilidad_id = $request->input('trazabilidad_id');
        $dettrazabilidad_id = $request->input('dettrazabilidad_id');
        $envase = [1=>'SACO',2=>'BLOCK',3=>'CAJAS'];

        $empresa = Empresa::findOrFail(session('empresa'));
        //Creación de Excel
        $excel = new Spreadsheet();

        //Información del Archivo
        $excel
            ->getProperties()
            ->setCreator($empresa->razsoc)
            ->setLastModifiedBy('Proceso')
            ->setTitle('Producto Terminado - Detallado')
            ->setSubject('Producto Terminado - Detallado')
            ->setDescription('Producto Terminado - Detallado')
            ->setKeywords('RDetallado')
            ->setCategory('Categoría Excel');

        //Fuente y Tamaño por defecto
        $excel
            ->getDefaultStyle()
            ->getFont()
            ->setName('Calibri')
            ->setSize(9);

        //Creación de Hoja y Llenado de Información
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle("REPORTE DETALLADO");
        $linea = 1;
        // Logo
        $logo = new Drawing();
        $logo->setName('Logo');
        $logo->setDescription('Logo');
        $logo->setPath('./static/images/logopesquera.jpeg');
        $logo->setCoordinates('A'.$linea);
        $logo->setHeight(60);
        $logo->setWorksheet($excel->getActiveSheet());

        $linea++;$linea++;$linea++;$linea++;
        $salto = "\r\n";

         $estiloBorde = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->setCellValue('A'.$linea,'PRODUCTO TERMINADO - REPORTE DETALLADO');
        $sheet->getStyle('A'.$linea)->getFont()->getColor()->setARGB('FF000080');
        $sheet->mergeCells('A'.$linea.':J'.$linea);
        $sheet->getStyle('A'.$linea)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $linea++;$linea++;
        // $sheet->getStyle('I')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        // $sheet->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00');

        if ($pproceso_id)
            // $productoTerminados = Productoterminado::with(['pproceso:id,nombre'])
            //     ->groupBy('pproceso_id')
            //     ->selectRaw('pproceso_id,sum(saldo) as sacos')
            //     ->where('pproceso_id',$pproceso_id)
            //     ->get();
            $productoTerminados = Productoterminado::with(['pproceso:id,nombre','dettrazabilidad'])
                ->join('dettrazabilidads','productoterminados.dettrazabilidad_id','dettrazabilidads.id')
                ->where('productoterminados.pproceso_id',$pproceso_id)
                ->groupBy(['productoterminados.pproceso_id'])
                ->selectRaw('productoterminados.pproceso_id,sum(productoterminados.saldo) as saldo,sum(productoterminados.saldo*dettrazabilidads.peso) as kilos')
                ->get();
        else {
            // $productoTerminados = Productoterminado::with(['pproceso:id,nombre'])
            //     ->groupBy('pproceso_id')
            //     ->selectRaw('pproceso_id,sum(saldo) as sacos')
            //     ->get();
            $productoTerminados = Productoterminado::with(['pproceso:id,nombre','dettrazabilidad'])
                ->join('dettrazabilidads','productoterminados.dettrazabilidad_id','dettrazabilidads.id')
                ->groupBy(['productoterminados.pproceso_id'])
                ->selectRaw('productoterminados.pproceso_id,sum(productoterminados.saldo) as saldo,sum(productoterminados.saldo*dettrazabilidads.peso) as kilos')
                ->get();
        }
        foreach ($productoTerminados as $pTerminado) {
            $sheet->setCellValue('A'.$linea,'PRODUCTO: '.$pTerminado->pproceso->nombre);
            $sheet->mergeCells('A'.$linea.':J'.$linea);
            $sheet->getStyle('A'.$linea)->getFont()->setBold(true);
            $sheet->getStyle('A'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
            $sheet->getStyle('A'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF000080');
            $linea++;
            if ($trazabilidad_id)
                // $trazabilidades = Productoterminado::with(['trazabilidad:id,nombre'])
                //     ->groupBy('trazabilidad_id')
                //     ->selectRaw('trazabilidad_id,sum(saldo) as sacos')
                //     ->where('trazabilidad_id',$trazabilidad_id)
                //     ->get();
                $trazabilidades = Productoterminado::with(['dettrazabilidad','trazabilidad:id,nombre'])
                    ->join('dettrazabilidads','productoterminados.dettrazabilidad_id','dettrazabilidads.id')
                    ->where('productoterminados.trazabilidad_id',$trazabilidad_id)
                    ->groupBy(['productoterminados.trazabilidad_id','dettrazabilidads.envase','dettrazabilidads.peso'])
                    ->selectRaw('productoterminados.trazabilidad_id,dettrazabilidads.envase,dettrazabilidads.peso,sum(productoterminados.saldo) as saldo,sum(productoterminados.saldo*dettrazabilidads.peso) as kilos')
                    ->get();
            else {
                // $trazabilidades = Productoterminado::with(['trazabilidad:id,nombre'])
                //     ->groupBy('trazabilidad_id')
                //     ->selectRaw('trazabilidad_id,sum(saldo) as sacos')
                //     ->where('pproceso_id',$pTerminado->pproceso_id)
                //     ->get();
                $trazabilidades = Productoterminado::with(['dettrazabilidad','trazabilidad:id,nombre'])
                    ->join('dettrazabilidads','productoterminados.dettrazabilidad_id','dettrazabilidads.id')
                    ->where('productoterminados.pproceso_id', $pTerminado->pproceso_id)
                    ->groupBy(['productoterminados.trazabilidad_id','dettrazabilidads.envase','dettrazabilidads.peso'])
                    ->selectRaw('productoterminados.trazabilidad_id,dettrazabilidads.envase,dettrazabilidads.peso,sum(productoterminados.saldo) as saldo,sum(productoterminados.saldo*dettrazabilidads.peso) as kilos')
                    ->get();
            }
            foreach ($trazabilidades as $trazabilidad) {
                $sheet->setCellValue('A'.$linea,'TRAZABILIDAD: '.$trazabilidad->trazabilidad->nombre);
                $sheet->mergeCells('A'.$linea.':J'.$linea);
                $sheet->getStyle('A'.$linea)->getFont()->setBold(true);
                $sheet->getStyle('A'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
                $sheet->getStyle('A'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF31869B');
                $linea++;
                if ($dettrazabilidad_id) {
                    // $dettrazabilidades = Productoterminado::with(['dettrazabilidad'])
                    //     ->groupBy('dettrazabilidad_id')
                    //     ->selectRaw('dettrazabilidad_id,sum(saldo) as sacos')
                    //     ->where('dettrazabilidad_id',$dettrazabilidad_id)
                    //     ->get();
                    $dettrazabilidades = Productoterminado::with(['dettrazabilidad'])
                        ->join('dettrazabilidads','productoterminados.dettrazabilidad_id','dettrazabilidads.id')
                        ->where('productoterminados.dettrazabilidad_id',$dettrazabilidad_id)
                        ->groupBy(['productoterminados.dettrazabilidad_id','dettrazabilidads.envase','dettrazabilidads.peso'])
                        ->selectRaw('productoterminados.dettrazabilidad_id,dettrazabilidads.envase,dettrazabilidads.peso,sum(productoterminados.saldo) as saldo,sum(productoterminados.saldo*dettrazabilidads.peso) as kilos')
                        ->get();
                } else {
                    // $dettrazabilidades = Productoterminado::with(['dettrazabilidad'])
                    //     ->groupBy('dettrazabilidad_id')
                    //     ->selectRaw('dettrazabilidad_id,sum(saldo) as sacos')
                    //     ->where('trazabilidad_id',$trazabilidad->trazabilidad_id)
                    //     ->get();
                    $dettrazabilidades = Productoterminado::with(['dettrazabilidad'])
                        ->join('dettrazabilidads','productoterminados.dettrazabilidad_id','dettrazabilidads.id')
                        ->where('productoterminados.trazabilidad_id',$trazabilidad->trazabilidad_id)
                        ->groupBy(['productoterminados.dettrazabilidad_id','dettrazabilidads.envase','dettrazabilidads.peso'])
                        ->selectRaw('productoterminados.dettrazabilidad_id,dettrazabilidads.envase,dettrazabilidads.peso,sum(productoterminados.saldo) as saldo,sum(productoterminados.saldo*dettrazabilidads.peso) as kilos')
                        ->get();
                }
                foreach ($dettrazabilidades as $dettrazabilidad) {
                    $sheet->setCellValue('A'.$linea,'CÓDIGO: '.$dettrazabilidad->dettrazabilidad->mpd_codigo);
                    $sheet->mergeCells('A'.$linea.':J'.$linea);
                    $sheet->getStyle('A'.$linea)->getFont()->setBold(true);
                    $sheet->getStyle('A'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
                    $sheet->getStyle('A'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF0D0D0D');
                    $linea++;
                    $cuadroInicio = $linea;
                    $sheet->setCellValue('A'.$linea,'LOTE');
                    $sheet->setCellValue('B'.$linea,'FECHA'.$salto.'EMPAQUE');
                    $sheet->setCellValue('C'.$linea,'FECHA'.$salto.'VENCIMIENTO');
                    $sheet->setCellValue('D'.$linea,'ENVASE');
                    $sheet->setCellValue('E'.$linea,'ENTRADAS'.$salto.'SACOS');
                    $sheet->setCellValue('F'.$linea,'SALIDAS'.$salto.'SACOS');
                    $sheet->setCellValue('G'.$linea,'SALDO'.$salto.'SACOS');
                    $sheet->setCellValue('H'.$linea,'ENTRADAS'.$salto.'KILOS');
                    $sheet->setCellValue('I'.$linea,'SALIDAS'.$salto.'KILOS');
                    $sheet->setCellValue('J'.$linea,'SALDO'.$salto.'KILOS');
                    $sheet->getStyle('A'.$linea.':J'.$linea)
                        ->getAlignment()
                        ->setVertical(StyleAlignment::VERTICAL_CENTER)
                        ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('A'.$linea.':J'.$linea)->getFont()->setBold(true);
                    $sheet->getStyle('A'.$linea.':J'.$linea)->getAlignment()->setWrapText(true);
                    $linea++;
                    $detalle = Productoterminado::with(['dettrazabilidad'])
                        ->where('dettrazabilidad_id',$dettrazabilidad->dettrazabilidad_id)
                        ->orderBy('lote')
                        ->get();
                    foreach ($detalle as $det) {
                        $sheet->setCellValue('A'.$linea, $det->lote);
                        $sheet->setCellValue('B'.$linea, $det->empaque);
                        $sheet->setCellValue('C'.$linea, $det->vencimiento);
                        $sheet->setCellValue('D'.$linea, $envase[$det->dettrazabilidad->envase]);
                        $sheet->setCellValue('E'.$linea, $det->entradas);
                        $sheet->setCellValue('F'.$linea, $det->salidas);
                        $sheet->setCellValue('G'.$linea, $det->saldo);
                        $sheet->setCellValue('H'.$linea, $det->entradas*$det->dettrazabilidad->peso);
                        $sheet->setCellValue('I'.$linea, $det->salidas*$det->dettrazabilidad->peso);
                        $sheet->setCellValue('J'.$linea, $det->saldo*$det->dettrazabilidad->peso);
                        $linea++;
                    }
                    $sheet->setCellValue('G'.$linea, $dettrazabilidad->saldo);
                    $sheet->setCellValue('J'.$linea, $dettrazabilidad->kilos);
                    $sheet->getStyle('A'.$cuadroInicio.':J'.$linea)->applyFromArray($estiloBorde);
                    $linea++;
                    $linea++;
                }
                $linea++;
            }
            $linea++;
        }

        // Ancho de Columnas
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(13);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(12);

        //Envio de Archivo para Descarga
        $fileName= 'DETALLADO-'.".xlsx";
        # Crear un "escritor"
        $writer = new Xlsx($excel);
        # Le pasamos la ruta de guardado
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }
    
    public function porpagar(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');
        
        // return $proveedores;
        $empresa = Empresa::findOrFail(session('empresa'));
        //Creación de Excel
        $excel = new Spreadsheet();

        //Información del Archivo
        $excel
            ->getProperties()
            ->setCreator($empresa->razsoc)
            ->setLastModifiedBy('Tesorería')
            ->setTitle('Cuentas por Pagar')
            ->setSubject('Cuentas por Pagar')
            ->setDescription('Reporte Cuentas por Pagar')
            ->setKeywords('CtasXPagar')
            ->setCategory('Categoría Excel');

        //Fuente y Tamaño por defecto
        $excel
            ->getDefaultStyle()
            ->getFont()
            ->setName('Calibri')
            ->setSize(9);

        //Creación de Hoja y Llenado de Información
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle("CUENTAS POR PAGAR");
        $linea = 1;
        // Logo
        $logo = new Drawing();
        $logo->setName('Logo');
        $logo->setDescription('Logo');
        $logo->setPath('./static/images/logopesquera.jpeg');
        $logo->setCoordinates('A'.$linea);
        $logo->setHeight(60);
        $logo->setWorksheet($excel->getActiveSheet());

        $salto = "\r\n";
        $estiloBorde = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        
        $linea++;$linea++;
        $sheet->setCellValue('A'.$linea,'CUENTAS POR PAGAR');
        $sheet->getStyle('A'.$linea)->getFont()->getColor()->setARGB('FF000080');
        $sheet->mergeCells('A'.$linea.':N'.$linea);
        $sheet->getStyle('A'.$linea)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $linea++;
        $sheet->setCellValue('A'.$linea,'DEL '.$desde.' AL '.$hasta);
        $sheet->getStyle('A'.$linea)->getFont()->getColor()->setARGB('FF000080');
        $sheet->mergeCells('A'.$linea.':N'.$linea);
        $sheet->getStyle('A'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $linea++;
        // $sheet->getStyle('I')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        $sheet->getStyle('G:N')->getNumberFormat()->setFormatCode('#,##0.00');
        // $sheet->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00');

        $proveedores = Rcompra::with('cliente:id,numdoc,razsoc')
            ->orderBy(Cliente::select('razsoc')->whereColumn('rcompras.cliente_id','clientes.id'))
            ->where('saldo','>',0)
            ->select('cliente_id')
            ->groupBy('cliente_id')
            ->whereBetween('fecha',[$desde,$hasta])
            ->get();
        // return $proveedores;

        foreach ($proveedores as $prov) {
            $linea++;
            $sheet->setCellValue('A'.$linea,$prov->cliente->numdoc_razsoc);
            $sheet->mergeCells('A'.$linea.':N'.$linea);
            // $sheet->getStyle('A'.$linea.':D'.$linea)
            //     ->getAlignment()
            //     ->setVertical(StyleAlignment::VERTICAL_CENTER)
            //     ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A'.$linea.':N'.$linea)->getFont()->setBold(true);
            $sheet->getStyle('A'.$linea.':N'.$linea)->getAlignment()->setWrapText(true);
            $sheet->getStyle('A'.$linea.':N'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
            $sheet->getStyle('A'.$linea.':N'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF000080');
            $cuadroInicio = $linea;
            $rcompras = Rcompra::where('cliente_id',$prov->cliente_id)
                ->where('saldo','>',0)
                ->orderBy('fecha')
                ->select(
                    'fecha','vencimiento','moneda','tc','tipocomprobante_codigo',
                    'serie','numero','total','pagado','saldo','detraccion_monto'
                    )
                ->get();
            // return $rcompras;
            $linea++;
            $sheet->setCellValue('A'.$linea,'FECHA');
            $sheet->setCellValue('B'.$linea,'VENCE');
            $sheet->setCellValue('C'.$linea,'MONEDA');
            $sheet->setCellValue('D'.$linea,'TC');
            $sheet->setCellValue('E'.$linea,'TD');
            $sheet->setCellValue('F'.$linea,'NÚMERO');
            $sheet->setCellValue('G'.$linea,'TOTAL S/');
            $sheet->setCellValue('H'.$linea,'DETRACCIÓN S/');
            $sheet->setCellValue('I'.$linea,'PAGADO S/');
            $sheet->setCellValue('J'.$linea,'SALDO S/');
            $sheet->setCellValue('K'.$linea,'TOTAL US$');
            $sheet->setCellValue('L'.$linea,'DETRACCIÓN US$');
            $sheet->setCellValue('M'.$linea,'PAGADO US$');
            $sheet->setCellValue('N'.$linea,'SALDO US$');
            $sheet->getStyle('A'.$linea.':N'.$linea)
                ->getAlignment()
                ->setVertical(StyleAlignment::VERTICAL_CENTER)
                ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A'.$linea.':N'.$linea)->getFont()->setBold(true);
            $sheet->getStyle('A'.$linea.':N'.$linea)->getAlignment()->setWrapText(true);
            $sheet->getStyle('A'.$linea.':N'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
            $sheet->getStyle('A'.$linea.':N'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF31869B');
            foreach ($rcompras as $rcompra) {
                $v1 = 0;
                $v2 = 0;
                $v3 = 0;
                $v4 = 0;
                $v5 = 0;
                $v6 = 0;
                $v7 = 0;
                $v8 = 0;
                $linea++;
                $sheet->setCellValue('A'.$linea,$rcompra->fecha);
                $sheet->setCellValue('B'.$linea,$rcompra->vencimiento);
                $sheet->setCellValue('C'.$linea,$rcompra->moneda);
                $sheet->setCellValue('D'.$linea,$rcompra->tc);
                $sheet->setCellValue('E'.$linea,$rcompra->tipocomprobante_codigo);
                $sheet->setCellValue('F'.$linea,$rcompra->serie_numero);
                if ($rcompra->moneda == 'PEN') {
                    $sheet->setCellValue('G'.$linea,$rcompra->total);
                    $sheet->setCellValue('H'.$linea,$rcompra->detraccion_monto);
                    $sheet->setCellValue('I'.$linea,$rcompra->pagado);
                    $sheet->setCellValue('J'.$linea,$rcompra->saldo);
                    $sheet->setCellValue('K'.$linea,round($rcompra->total/$rcompra->tc,2));
                    $sheet->setCellValue('L'.$linea,round($rcompra->detraccion_monto/$rcompra->tc,2));
                    $sheet->setCellValue('M'.$linea,round($rcompra->pagado/$rcompra->tc,2));
                    $sheet->setCellValue('N'.$linea,round($rcompra->saldo/$rcompra->tc,2));
                    $v1 += $rcompra->total;
                    $v2 += $rcompra->detraccion_monto;
                    $v3 += $rcompra->pagado;
                    $v4 += $rcompra->saldo;
                    $v5 += round($rcompra->total/$rcompra->tc,2);
                    $v6 += round($rcompra->detraccion_monto/$rcompra->tc,2);
                    $v7 += round($rcompra->pagado/$rcompra->tc,2);
                    $v8 += round($rcompra->saldo/$rcompra->tc,2);
                } else {
                    $sheet->setCellValue('G'.$linea, round($rcompra->total*$rcompra->tc,2));
                    $sheet->setCellValue('H'.$linea, round($rcompra->detraccion_monto*$rcompra->tc,2));
                    $sheet->setCellValue('I'.$linea, round($rcompra->pagado*$rcompra->tc,2));
                    $sheet->setCellValue('J'.$linea, round($rcompra->saldo*$rcompra->tc,2));
                    $sheet->setCellValue('K'.$linea, $rcompra->total);
                    $sheet->setCellValue('L'.$linea, $rcompra->detraccion_monto);
                    $sheet->setCellValue('M'.$linea, $rcompra->pagado);
                    $sheet->setCellValue('N'.$linea, $rcompra->saldo);
                    $v1 += round($rcompra->total*$rcompra->tc,2);
                    $v2 += round($rcompra->detraccion_monto*$rcompra->tc,2);
                    $v3 += round($rcompra->pagado*$rcompra->tc,2);
                    $v4 += round($rcompra->saldo*$rcompra->tc,2);
                    $v5 += $rcompra->total;
                    $v6 += $rcompra->detraccion_monto;
                    $v7 += $rcompra->pagado;
                    $v8 += $rcompra->saldo;
                }
            }
            $linea++;
            $sheet->setCellValue('A'.$linea,'TOTAL');
            $sheet->mergeCells('A'.$linea.':F'.$linea);
            $sheet->setCellValue('G'.$linea, $v1);
            // $sheet->setCellValue('H'.$linea, $v2);
            // $sheet->setCellValue('I'.$linea, $v3);
            $sheet->setCellValue('J'.$linea, $v4);
            $sheet->setCellValue('K'.$linea, $v5);
            // $sheet->setCellValue('L'.$linea, $v6);
            // $sheet->setCellValue('M'.$linea, $v7);
            $sheet->setCellValue('N'.$linea, $v8);
            $sheet->getStyle('A'.$linea.':N'.$linea)
                ->getAlignment()
                ->setVertical(StyleAlignment::VERTICAL_CENTER)
                ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A'.$linea.':N'.$linea)->getFont()->setBold(true);

            $sheet->getStyle('A'.$cuadroInicio.':N'.$linea)->applyFromArray($estiloBorde);
            $linea++;
            $linea++;
        }

        // Ancho de Columnas
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(9);
        $sheet->getColumnDimension('D')->setWidth(6);
        $sheet->getColumnDimension('E')->setWidth(4);
        $sheet->getColumnDimension('F')->setWidth(9);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(14);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(11);
        $sheet->getColumnDimension('K')->setWidth(10);
        $sheet->getColumnDimension('L')->setWidth(16);
        $sheet->getColumnDimension('M')->setWidth(12);
        $sheet->getColumnDimension('N')->setWidth(11);

        //Envio de Archivo para Descarga
        $fileName= 'CTASXPAGAR-'.$desde.'-'.$hasta.".xlsx";
        # Crear un "escritor"
        $writer = new Xlsx($excel);
        # Le pasamos la ruta de guardado
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }
    
    public function proveedor(Request $request)
    {
        $rules = [
            'cliente_id' => 'required',
        ];
        $messages = [
    		'cliente_id.required' => 'Seleccione Proveedor.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
    	if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger')->withinput();
        }
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');
        $moneda = $request->input('moneda');
        $proveedor = Cliente::findOrFail($request->input('cliente_id'));

        $rcompras = Rcompra::where('cliente_id',$proveedor->id)
            ->orderBy('fecha')
            ->select(
                'periodo','almacen','fecha','vencimiento','cancelacion','moneda','tc','tipocomprobante_codigo',
                'serie','numero','total','pagado','saldo','detraccion_monto','detalle'
                )
            ->get();
        if($rcompras->count() == 0){
            return back()->with('message', 'No se encontraron registros')->with('typealert', 'danger')->withinput();
        }
        
        $empresa = Empresa::findOrFail(session('empresa'));
        //Creación de Excel
        $excel = new Spreadsheet();

        //Información del Archivo
        $excel
            ->getProperties()
            ->setCreator($empresa->razsoc)
            ->setLastModifiedBy('Tesorería')
            ->setTitle('Detallado por Proveedor')
            ->setSubject('Detallado por Proveedor')
            ->setDescription('Reporte Detallado de Compras por Proveedor')
            ->setKeywords('Proveedor')
            ->setCategory('Categoría Excel');

        //Fuente y Tamaño por defecto
        $excel
            ->getDefaultStyle()
            ->getFont()
            ->setName('Calibri')
            ->setSize(9);

        //Creación de Hoja y Llenado de Información
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle("DETALLADO POR PROVEEDOR");
        $linea = 1;
        // Logo
        $logo = new Drawing();
        $logo->setName('Logo');
        $logo->setDescription('Logo');
        $logo->setPath('./static/images/logopesquera.jpeg');
        $logo->setCoordinates('A'.$linea);
        $logo->setHeight(60);
        $logo->setWorksheet($excel->getActiveSheet());

        $salto = "\r\n";
        $estiloBorde = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        // return $proveedor;
        $linea++;$linea++;
        $sheet->setCellValue('A'.$linea,'PROVEEDOR: '.$proveedor->numdoc_razsoc);
        $sheet->getStyle('A'.$linea)->getFont()->getColor()->setARGB('FF000080');
        $sheet->mergeCells('A'.$linea.':M'.$linea);
        $sheet->getStyle('A'.$linea)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $linea++;
        $dMoneda = $moneda == 'PEN'?'SOLES':'DOLARES AMERICANOS';
        $sheet->setCellValue('A'.$linea,'MONEDA: '. $dMoneda .' | DEL '.$desde.' AL '.$hasta);
        $sheet->getStyle('A'.$linea)->getFont()->getColor()->setARGB('FF000080');
        $sheet->mergeCells('A'.$linea.':M'.$linea);
        $sheet->getStyle('A'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $linea++;
        // $sheet->getStyle('I')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        $sheet->getStyle('G:M')->getNumberFormat()->setFormatCode('#,##0.00');
        // $sheet->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00');

        $linea++;
        $cuadroInicio = $linea;
        $sheet->setCellValue('A'.$linea,'PERIODO');
        $sheet->setCellValue('B'.$linea,'ALMACEN');
        $sheet->setCellValue('C'.$linea,'FECHA');
        $sheet->setCellValue('D'.$linea,'VENCE');
        $sheet->setCellValue('E'.$linea,'MONEDA');
        $sheet->setCellValue('F'.$linea,'TC');
        $sheet->setCellValue('G'.$linea,'TD');
        $sheet->setCellValue('H'.$linea,'NÚMERO');
        $sheet->setCellValue('I'.$linea,'TOTAL');
        $sheet->setCellValue('J'.$linea,'DETRACCIÓN');
        $sheet->setCellValue('K'.$linea,'PAGADO');
        $sheet->setCellValue('L'.$linea,'SALDO');
        $sheet->setCellValue('M'.$linea,'DETALLE');
        $sheet->getStyle('A'.$linea.':M'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER)
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':M'.$linea)->getFont()->setBold(true);
        $sheet->getStyle('A'.$linea.':M'.$linea)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.$linea.':M'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A'.$linea.':M'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF31869B');
        $v1 = 0;
        $v2 = 0;
        $v3 = 0;
        $v4 = 0;
        foreach ($rcompras as $rcompra) {
            $linea++;
            $sheet->setCellValue('A'.$linea,$rcompra->periodo);
            $sheet->setCellValue('B'.$linea,$rcompra->almacen==1?'SI':'NO');
            $sheet->setCellValue('C'.$linea,$rcompra->fecha);
            $sheet->setCellValue('D'.$linea,$rcompra->vencimiento);
            $sheet->setCellValue('E'.$linea,$rcompra->moneda);
            $sheet->setCellValue('F'.$linea,$rcompra->tc);
            $sheet->setCellValue('G'.$linea,$rcompra->tipocomprobante_codigo);
            $sheet->setCellValue('H'.$linea,$rcompra->serie_numero);
            if ($moneda == 'PEN') {
                if ($rcompra->moneda == 'PEN') {
                    $sheet->setCellValue('I'.$linea,$rcompra->total);
                    $sheet->setCellValue('J'.$linea,$rcompra->detraccion_monto);
                    $sheet->setCellValue('K'.$linea,$rcompra->pagado);
                    $sheet->setCellValue('L'.$linea,$rcompra->saldo);
                    $v1 += $rcompra->total;
                    $v2 += $rcompra->detraccion_monto;
                    $v3 += $rcompra->pagado;
                    $v4 += $rcompra->saldo;
                } else {
                    $sheet->setCellValue('I'.$linea, round($rcompra->total*$rcompra->tc,2));
                    $sheet->setCellValue('J'.$linea, round($rcompra->detraccion_monto*$rcompra->tc,2));
                    $sheet->setCellValue('K'.$linea, round($rcompra->pagado*$rcompra->tc,2));
                    $sheet->setCellValue('L'.$linea, round($rcompra->saldo*$rcompra->tc,2));
                    $v1 += round($rcompra->total*$rcompra->tc,2);
                    $v2 += round($rcompra->detraccion_monto*$rcompra->tc,2);
                    $v3 += round($rcompra->pagado*$rcompra->tc,2);
                    $v4 += round($rcompra->saldo*$rcompra->tc,2);
                }
            } else {
                if ($rcompra->moneda == 'PEN') {
                    $sheet->setCellValue('I'.$linea,round($rcompra->total/$rcompra->tc,2));
                    $sheet->setCellValue('J'.$linea,round($rcompra->detraccion_monto/$rcompra->tc,2));
                    $sheet->setCellValue('K'.$linea,round($rcompra->pagado/$rcompra->tc,2));
                    $sheet->setCellValue('L'.$linea,round($rcompra->saldo/$rcompra->tc,2));
                    $v1 += round($rcompra->total/$rcompra->tc,2);
                    $v2 += round($rcompra->detraccion_monto/$rcompra->tc,2);
                    $v3 += round($rcompra->pagado/$rcompra->tc,2);
                    $v4 += round($rcompra->saldo/$rcompra->tc,2);
                } else {
                    $sheet->setCellValue('I'.$linea, $rcompra->total);
                    $sheet->setCellValue('J'.$linea, $rcompra->detraccion_monto);
                    $sheet->setCellValue('K'.$linea, $rcompra->pagado);
                    $sheet->setCellValue('L'.$linea, $rcompra->saldo);
                    $v1 += $rcompra->total;
                    $v2 += $rcompra->detraccion_monto;
                    $v3 += $rcompra->pagado;
                    $v4 += $rcompra->saldo;
                }
            }
            $sheet->setCellValue('M'.$linea,$rcompra->detalle);
        }
        $linea++;
        $sheet->setCellValue('A'.$linea,'TOTAL');
        $sheet->mergeCells('A'.$linea.':H'.$linea);
        $sheet->setCellValue('I'.$linea, $v1);
        $sheet->setCellValue('J'.$linea, $v2);
        $sheet->setCellValue('K'.$linea, $v3);
        $sheet->setCellValue('L'.$linea, $v4);
        $sheet->getStyle('A'.$linea.':M'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER)
            ->setHorizontal(StyleAlignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A'.$linea.':M'.$linea)->getFont()->setBold(true);

        $sheet->getStyle('A'.$cuadroInicio.':M'.$linea)->applyFromArray($estiloBorde);
    
        // Ancho de Columnas
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(9);
        $sheet->getColumnDimension('C')->setWidth(11);
        $sheet->getColumnDimension('D')->setWidth(11);
        $sheet->getColumnDimension('E')->setWidth(9);
        $sheet->getColumnDimension('F')->setWidth(6);
        $sheet->getColumnDimension('G')->setWidth(4);
        $sheet->getColumnDimension('H')->setWidth(9);
        $sheet->getColumnDimension('I')->setWidth(10);
        $sheet->getColumnDimension('J')->setWidth(12);
        $sheet->getColumnDimension('K')->setWidth(10);
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(80);

        //Envio de Archivo para Descarga
        $fileName= $proveedor->numdoc_razsoc.'-'.$desde.'-'.$hasta.".xlsx";
        # Crear un "escritor"
        $writer = new Xlsx($excel);
        # Le pasamos la ruta de guardado
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }
    
    public function resumenparte(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');
        $moneda = $request->input('moneda');

        $partes = Parte::whereBetween('empaque',[$desde,$hasta])->get();

        if($partes->count() == 0){
            return back()->with('message', 'No se encontraron registros')->with('typealert', 'danger')->withinput();
        }
        
        $empresa = Empresa::findOrFail(session('empresa'));
        //Creación de Excel
        $excel = new Spreadsheet();

        //Información del Archivo
        $excel
            ->getProperties()
            ->setCreator($empresa->razsoc)
            ->setLastModifiedBy('Proceso')
            ->setTitle('Resumen por fechas')
            ->setSubject('Resumen por fechas')
            ->setDescription('Parte de Producción - Reporte Resumen')
            ->setKeywords('PProduccion')
            ->setCategory('Categoría Excel');

        //Fuente y Tamaño por defecto
        $excel
            ->getDefaultStyle()
            ->getFont()
            ->setName('Calibri')
            ->setSize(9);

        //Creación de Hoja y Llenado de Información
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle("RESUMEN");
        $linea = 1;
        // Logo
        $logo = new Drawing();
        $logo->setName('Logo');
        $logo->setDescription('Logo');
        $logo->setPath('./static/images/logopesquera.jpeg');
        $logo->setCoordinates('A'.$linea);
        $logo->setHeight(60);
        $logo->setWorksheet($excel->getActiveSheet());

        $salto = "\r\n";
        $estiloBorde = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        // return $proveedor;
        $linea++;$linea++;
        $sheet->setCellValue('A'.$linea,'PARTE DE PRODUCCIÓN - RESUMEN POR FECHA DE EMPAQUE');
        $sheet->getStyle('A'.$linea)->getFont()->getColor()->setARGB('FF000080');
        $sheet->mergeCells('A'.$linea.':R'.$linea);
        $sheet->getStyle('A'.$linea)->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $linea++;
        $dMoneda = $moneda == 'PEN'?'SOLES':'DOLARES AMERICANOS';
        $sheet->setCellValue('A'.$linea,'MONEDA: '. $dMoneda .' | DEL '.$desde.' AL '.$hasta);
        $sheet->getStyle('A'.$linea)->getFont()->getColor()->setARGB('FF000080');
        $sheet->mergeCells('A'.$linea.':R'.$linea);
        $sheet->getStyle('A'.$linea)->getFont()->setSize(9)->setBold(true);
        $sheet->getStyle('A'.$linea)
            ->getAlignment()
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $linea++;
        // $sheet->getStyle('I')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
        $sheet->getStyle('C:K')->getNumberFormat()->setFormatCode('#,##0.00');
        // $sheet->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00');

        $linea++;
        $cuadroInicio = $linea;
        $sheet->setCellValue('A'.$linea,'LOTE');
        $sheet->setCellValue('B'.$linea,'FECHA EMPAQUE');
        $sheet->setCellValue('C'.$linea,'MATERIA PRIMA KG');
        $sheet->setCellValue('D'.$linea,'SOBRE PESO KG');
        $sheet->setCellValue('E'.$linea,'RESIDUOS KG');
        $sheet->setCellValue('F'.$linea,'DESCARTE KG');
        $sheet->setCellValue('G'.$linea,'MERMA KG');
        $sheet->setCellValue('H'.$linea,'COSTO MATERIA PRIMA');
        $sheet->setCellValue('I'.$linea,'COSTO CONTRATA');
        $sheet->setCellValue('J'.$linea,'COSTO PRODUCTOS');
        $sheet->setCellValue('K'.$linea,'VENTA RESIDUOS');
        $sheet->setCellValue('L'.$linea,'HOMBRES');
        $sheet->setCellValue('M'.$linea,'MUJERES');
        $sheet->setCellValue('N'.$linea,'PLANILLAS DE ENVASADO');
        $sheet->setCellValue('O'.$linea,'PLANILLAS DE ENVASADO CRUDO');
        $sheet->setCellValue('P'.$linea,'GUÍAS DE INGRESO A CÁMARA');
        $sheet->setCellValue('Q'.$linea,'CONSUMO ALMACÉN');
        $sheet->setCellValue('R'.$linea,'GUÍAS DE RESIDUOS SÓLIDOS');
        $sheet->getStyle('A'.$linea.':R'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER)
            ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$linea.':R'.$linea)->getFont()->setBold(true);
        $sheet->getStyle('A'.$linea.':R'.$linea)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A'.$linea.':R'.$linea)->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A'.$linea.':R'.$linea)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF31869B');
        $v1 = 0;
        $v2 = 0;
        $v3 = 0;
        $v4 = 0;
        foreach ($partes as $parte) {
            $linea++;
            $sheet->setCellValue('A'.$linea, $parte->lote);
            $sheet->setCellValue('B'.$linea, $parte->empaque);
            $sheet->setCellValue('C'.$linea, $parte->materiaprima);
            $sheet->setCellValue('D'.$linea, $parte->sobrepeso);
            $sheet->setCellValue('E'.$linea, $parte->residuos);
            $sheet->setCellValue('F'.$linea, $parte->descarte);
            $sheet->setCellValue('G'.$linea, $parte->merma);
            if ($moneda == 'PEN') {
                $sheet->setCellValue('H'.$linea, $parte->costomateriaprima);
                $sheet->setCellValue('I'.$linea, $parte->manoobra);
                $sheet->setCellValue('J'.$linea, $parte->costoproductos);
                $sheet->setCellValue('K'.$linea, $parte->costoresiduos);
                $v1 += $parte->costomateriaprima;
                $v2 += $parte->manoobra;
                $v3 += $parte->costoproductos;
                $v4 += $parte->costoresiduos;
            } else {
                $sheet->setCellValue('H'.$linea, round($parte->costomateriaprima/$parte->tc,2));
                $sheet->setCellValue('I'.$linea, round($parte->manoobra/$parte->tc,2));
                $sheet->setCellValue('J'.$linea, round($parte->costoproductos/$parte->tc,2));
                $sheet->setCellValue('K'.$linea, round($parte->costoresiduos/$parte->tc,2));
                $v1 += round($parte->costomateriaprima/$parte->tc,2);
                $v2 += round($parte->manoobra/$parte->tc,2);
                $v3 += round($parte->costoproductos/$parte->tc,2);
                $v4 += round($parte->costoresiduos/$parte->tc,2);
            }
            $sheet->setCellValue('L'.$linea, $parte->hombres);
            $sheet->setCellValue('M'.$linea, $parte->mujeres);
            $sheet->setCellValue('N'.$linea, $parte->guias_envasado);
            $sheet->setCellValue('O'.$linea, $parte->guias_envasado_crudo);
            $sheet->setCellValue('P'.$linea, $parte->guias_camara);
            $sheet->setCellValue('Q'.$linea, $parte->guias_almacen);
            $sheet->setCellValue('R'.$linea, $parte->guias_residuos);
        }
        $linea++;
        // $sheet->setCellValue('A'.$linea,'TOTAL');
        // $sheet->mergeCells('A'.$linea.':G'.$linea);
        $sheet->setCellValue('C'.$linea, $partes->sum('materiaprima'));
        $sheet->setCellValue('D'.$linea, $partes->sum('sobrepeso'));
        $sheet->setCellValue('E'.$linea, $partes->sum('residuos'));
        $sheet->setCellValue('F'.$linea, $partes->sum('descarte'));
        $sheet->setCellValue('G'.$linea, $partes->sum('merma'));
        $sheet->setCellValue('H'.$linea, $v1);
        $sheet->setCellValue('I'.$linea, $v2);
        $sheet->setCellValue('J'.$linea, $v3);
        $sheet->setCellValue('K'.$linea, $v4);
        $sheet->getStyle('A'.$linea.':R'.$linea)
            ->getAlignment()
            ->setVertical(StyleAlignment::VERTICAL_CENTER)
            ->setHorizontal(StyleAlignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A'.$linea.':R'.$linea)->getFont()->setBold(true);

        $sheet->getStyle('A'.$cuadroInicio.':R'.$linea)->applyFromArray($estiloBorde);
    
        // Ancho de Columnas
        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(11);
        $sheet->getColumnDimension('I')->setWidth(11);
        $sheet->getColumnDimension('J')->setWidth(12);
        $sheet->getColumnDimension('K')->setWidth(11);
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(10);
        $sheet->getColumnDimension('N')->setWidth(40);
        $sheet->getColumnDimension('O')->setWidth(40);
        $sheet->getColumnDimension('P')->setWidth(40);
        $sheet->getColumnDimension('Q')->setWidth(50);
        $sheet->getColumnDimension('R')->setWidth(20);

        //Envio de Archivo para Descarga
        $fileName= 'Resumen'.'-'.$desde.'-'.$hasta.".xlsx";
        # Crear un "escritor"
        $writer = new Xlsx($excel);
        # Le pasamos la ruta de guardado
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }
}
