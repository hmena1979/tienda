<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Catproducto;
use App\Models\Detcliente;
use App\Models\Embarcacion;
use App\Models\Empresa;
use App\Models\Guia;
use App\Models\Masivo;
use App\Models\Materiaprima;
use App\Models\Ordcompra;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Luecano\NumeroALetras\NumeroALetras;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Rventa;
use App\Models\Rcompra;
use App\Models\Sede;
use App\Models\Tesoreria;
use App\Models\TipoComprobante;
use App\Models\User;

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

    public function guia(Guia $guia)
    {
        // $moneda = ['PEN' => 'SOLES', 'USD' => 'DOLARES'];
        // $mediopago = Categoria::where('modulo', 5)->pluck('nombre','codigo');
        //$comprobante = Comprobante::where('activo',1)->pluck('nombre','codigo');
        //$doctor = Doctor::orderBy('nombre','asc')->pluck('nombre','id');
        //$afectacion = Afectacion::pluck('nombre','codigo');
        $tipdoc = Categoria::where('modulo', 1)->orderBy('codigo')->pluck('nombre','codigo');
        $empresa = Empresa::findOrFail(session('empresa'));
        $sede = Sede::findOrFail(session('sede'));
        $qtext = $empresa->ruc.'|'
            .$guia->tipocomprobante_codigo.'|'
            .$guia->serie.'|'
            .$guia->numero.'|'
            .$guia->igv.'|'
            .$guia->total.'|'
            .$guia->fecha.'|'
            .$guia->cliente->tipdoc_id.'|'
            .$guia->cliente->numdoc;

        $qrcode = base64_encode(QrCode::format('svg')->size(90)->errorCorrection('H')->generate($qtext));
        $data = [
            'guia' => $guia,
            'empresa' => $empresa,
            'sede' => $sede,
            'qrcode' => $qrcode,
            'tipdoc' => $tipdoc
        ];
        $pdf = PDF::loadView('pdf.guia', $data)->setPaper('A4', 'portrait');
        // if($rventa->tipocomprobante_codigo=='01'){
        //     $pdf = PDF::loadView('pdf.factura', $data)->setPaper('A4', 'portrait');
        // }else{
        //     $pdf = PDF::loadView('pdf.boleta', $data)->setPaper('A4', 'portrait');
        // }
        return $pdf->stream($guia->cliente->numdoc.'-'.$guia->tipocomprobante_codigo.'-'.$guia->serie.'-'.$guia->numero.'.pdf', array('Attachment'=>false));
        
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

    public function masivos(Masivo $masivo)
    {
        $moneda = ['PEN' => 'SOLES', 'USD' => 'DOLARES'];
        $empresa = Empresa::findOrFail(session('empresa'));
        $sede = Sede::findOrFail(session('sede'));

        $data = [
            'masivo' => $masivo,
            'moneda' => $moneda,
            'empresa' => $empresa,
            'sede' => $sede,
        ];
        $pdf = PDF::loadView('pdf.masivos', $data)->setPaper('A4', 'portrait');
        return $pdf->stream(str_pad($masivo->sede_id, 2, '0', STR_PAD_LEFT).
            str_pad($masivo->id, 8, '0', STR_PAD_LEFT).'.pdf', array('Attachment'=>false));
        
        //$pdf->stream($parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.$factura->numero.'.pdf', array('Attachment'=>false));
        //return redirect('/admin/factura/'.$factura->id.'/edit')->with('message', 'Factura generada')->with('typealert', 'success');
        
        // return view('pdf.boleta', $data);
    }

    public function materiaprima(Materiaprima $materiaprima)
    {
        $moneda = ['PEN' => 'SOLES', 'USD' => 'DOLARES'];
        $empresa = Empresa::findOrFail(session('empresa'));
        $sede = Sede::findOrFail(session('sede'));
        $tipocomprobante = TipoComprobante::pluck('nombre','codigo');
        if ($materiaprima->embarcacion_id) {
            $embarcaciones = json_decode($materiaprima->embarcacion_id);
        } else {
            $embarcaciones = [];
        }
        $enombre = Embarcacion::pluck('nombre','id');
        $ematricula = Embarcacion::pluck('matricula','id');
        $eprotocolo = Embarcacion::pluck('protocolo','id');
        $ecapacidad = Embarcacion::pluck('capacidad','id');
        $tot = $materiaprima->detmateriaprimas->count();
        if ($tot%2 == 0) {
            $primeros = $tot / 2;
            $ultimos = $tot / 2;
        } else {
            $primeros = round($tot / 2);
            $ultimos = $tot - $primeros;
        }
        $tabla1 = $materiaprima->detmateriaprimas->take($primeros);
        $tabla2 = $materiaprima->detmateriaprimas->skip($primeros)->take($ultimos);


        $data = [
            'materiaprima' => $materiaprima,
            'moneda' => $moneda,
            'empresa' => $empresa,
            'sede' => $sede,
            'tipocomprobante' => $tipocomprobante,
            'embarcaciones' => $embarcaciones,
            'enombre' => $enombre,
            'ematricula' => $ematricula,
            'eprotocolo' => $eprotocolo,
            'ecapacidad' => $ecapacidad,
            'tabla1' => $tabla1,
            'tabla2' => $tabla2,
        ];
        $pdf = PDF::loadView('pdf.materiaprima', $data)->setPaper('A4', 'portrait');
        return $pdf->stream(str_pad($materiaprima->sede_id, 2, '0', STR_PAD_LEFT).
            str_pad($materiaprima->id, 8, '0', STR_PAD_LEFT).'.pdf', array('Attachment'=>false));
        
          // return view('pdf.materiaprima', $data);
    }

    public function ordcompra(Ordcompra $ordcompra)
    {
        $moneda = ['PEN' => 'SOLES', 'USD' => 'DOLARES'];
        $empresa = Empresa::findOrFail(session('empresa'));
        $sede = Sede::findOrFail(session('sede'));
        $formatter = new NumeroALetras();
        $monto = round($ordcompra->total+($ordcompra->total*(session('igv')/100)),2);
        $users = User::orderBy('name')->pluck('name','id');
        if ($ordcompra->detcliente_id) {
            $dCliente = Detcliente::findOrFail($ordcompra->detcliente_id);
            $cuenta = $dCliente->banco->nombre .' CUENTA N° '. $dCliente->cuenta;
        } else {
            $cuenta = '';
        }
        if($ordcompra->moneda=='PEN'){
            $letra = $formatter->toInvoice($monto, 2, 'soles');
        }else{
            $letra = $formatter->toInvoice($monto, 2, 'dólares americanos');
        }
        $data = [
            'ordcompra' => $ordcompra,
            'moneda' => $moneda,
            'empresa' => $empresa,
            'sede' => $sede,
            'letra' => $letra,
            'cuenta' => $cuenta,
            'users' => $users,
        ];
        $pdf = PDF::loadView('pdf.ordcompra', $data)->setPaper('A4', 'portrait');
        return $pdf->stream(str_pad($ordcompra->sede_id, 2, '0', STR_PAD_LEFT).
            str_pad($ordcompra->id, 8, '0', STR_PAD_LEFT).'.pdf', array('Attachment'=>false));
        
        //$pdf->stream($parametro->ruc.'-'.$factura->comprobante_id.'-'.$factura->serie.'-'.$factura->numero.'.pdf', array('Attachment'=>false));
        //return redirect('/admin/factura/'.$factura->id.'/edit')->with('message', 'Factura generada')->with('typealert', 'success');
        
        // return view('pdf.boleta', $data);
    }

    public function productos($tipo, $tipoproducto_id)
    {
        $empresa = Empresa::findOrFail(session('empresa'));
        if ($tipo == 1) {
            $tipoproductos = Catproducto::with(['productos'])->whereIn('modulo',['1'])
                ->orderBy('nombre')->get();
        } else {
            $tipoproductos = Catproducto::with(['productos'])->whereIn('modulo',['1'])
                ->where('id',$tipoproducto_id)
                ->get();
        }
        $data = [
            'empresa' => $empresa,
            'tipoproductos' => $tipoproductos,
        ];
        $pdf = PDF::loadView('pdf.productos', $data)->setPaper('A4', 'portrait');
        return $pdf->stream('Productos.pdf', array('Attachment'=>false));
    }
}
