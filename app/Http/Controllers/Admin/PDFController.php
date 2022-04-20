<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Empresa;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Luecano\NumeroALetras\NumeroALetras;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Rventa;
use App\Models\Rcompra;
use App\Models\Sede;
use App\Models\Tesoreria;

class PDFController extends Controller
{
    public function facturacion(Rventa $rventa)
    {
        $moneda = ['PEN' => 'SOLES', 'USD' => 'DOLARES'];
        $mediopago = Categoria::where('modulo', 5)->pluck('nombre','codigo');
        //$comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        //$doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        //$afectacion = Afectacion::pluck('nombre','codigo');
        $empresa = Empresa::findOrFail(session('empresa'));
        $sede = Sede::findOrFail(session('sede'));
        $qtext = $empresa->ruc.'|'
            .$rventa->tipocomprobante_codigo.'|'
            .$rventa->serie.'|'
            .$rventa->numero.'|'
            .$rventa->igv.'|'
            .$rventa->total.'|'
            .$rventa->fecha.'|'
            .$rventa->cliente->tipdoc_id.'|'
            .$rventa->cliente->numdoc;

        $qrcode = base64_encode(QrCode::format('svg')->size(90)->errorCorrection('H')->generate($qtext));
        $formatter = new NumeroALetras();
        if($rventa->moneda=='PEN'){
            $letra = $formatter->toInvoice($rventa->total, 2, 'soles');
        }else{
            $letra = $formatter->toInvoice($rventa->total, 2, 'dólares americanos');
        }
        $data = [
            'rventa' => $rventa,
            'moneda' => $moneda,
            'empresa' => $empresa,
            'sede' => $sede,
            'mediopago' => $mediopago,
            'qrcode' => $qrcode,
            'letra' => $letra
        ];
        switch ($rventa->tipocomprobante_codigo) {
            case '01':
                $pdf = PDF::loadView('pdf.factura', $data)->setPaper('A4', 'portrait');
                break;
            case '03':
                $pdf = PDF::loadView('pdf.boleta', $data)->setPaper('A4', 'portrait');
                break;
            case '00':
                $pdf = PDF::loadView('pdf.consumo', $data)->setPaper('A4', 'portrait');
                break;
        }
        // if($rventa->tipocomprobante_codigo=='01'){
        //     $pdf = PDF::loadView('pdf.factura', $data)->setPaper('A4', 'portrait');
        // }else{
        //     $pdf = PDF::loadView('pdf.boleta', $data)->setPaper('A4', 'portrait');
        // }
        return $pdf->stream($rventa->cliente->numdoc.'-'.$rventa->tipocomprobante_codigo.'-'.$rventa->serie.'-'.$rventa->numero.'.pdf', array('Attachment'=>false));
        
        //$pdf->stream($parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.$factura->numero.'.pdf', array('Attachment'=>false));
        //return redirect('/admin/factura/'.$factura->id.'/edit')->with('message', 'Factura generada')->with('typealert', 'success');
        
        // return view('pdf.boleta', $data);
    }
    
    public function ingresos(Rcompra $rcompra)
    {
        $moneda = ['PEN' => 'SOLES', 'USD' => 'DOLARES'];
        $empresa = Empresa::findOrFail(session('empresa'));
        $sede = Sede::findOrFail(session('sede'));

        $data = [
            'rcompra' => $rcompra,
            'moneda' => $moneda,
            'empresa' => $empresa,
            'sede' => $sede,
        ];
        $pdf = PDF::loadView('pdf.ingresos', $data)->setPaper('A4', 'portrait');
        return $pdf->stream($rcompra->cliente->numdoc.'-'.$rcompra->tipocomprobante_codigo.'-'.$rcompra->serie.'-'.$rcompra->numero.'.pdf', array('Attachment'=>false));
        
        //$pdf->stream($parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.$factura->numero.'.pdf', array('Attachment'=>false));
        //return redirect('/admin/factura/'.$factura->id.'/edit')->with('message', 'Factura generada')->with('typealert', 'success');
        
        // return view('pdf.boleta', $data);
    }

    public function tesoreria(Tesoreria $tesoreria)
    {
        $moneda = ['PEN' => 'SOLES', 'USD' => 'DOLARES'];
        $empresa = Empresa::findOrFail(session('empresa'));
        $sede = Sede::findOrFail(session('sede'));

        $data = [
            'tesoreria' => $tesoreria,
            'moneda' => $moneda,
            'empresa' => $empresa,
            'sede' => $sede,
        ];
        $pdf = PDF::loadView('pdf.tesoreria', $data)->setPaper('A4', 'portrait');
        return $pdf->stream(str_pad($tesoreria->sede_id, 2, '0', STR_PAD_LEFT).
            str_pad($tesoreria->id, 8, '0', STR_PAD_LEFT).'.pdf', array('Attachment'=>false));
        
        //$pdf->stream($parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.$factura->numero.'.pdf', array('Attachment'=>false));
        //return redirect('/admin/factura/'.$factura->id.'/edit')->with('message', 'Factura generada')->with('typealert', 'success');
        
        // return view('pdf.boleta', $data);
    }
}
