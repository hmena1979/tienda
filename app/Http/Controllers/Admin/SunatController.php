<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// use Greenter\Model\Sale\Invoice;
// use Greenter\Xml\Builder\InvoiceBuilder;
use Greenter\XMLSecLibs\Sunat\SignedXml;
use Greenter\XMLSecLibs\Certificate\X509Certificate;
use Greenter\XMLSecLibs\Certificate\X509ContentType;
use Luecano\NumeroALetras\NumeroALetras;
use Greenter\Model\Sale\Detraction;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;
use Greenter\Model\Sale\Cuota;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Document;
use Greenter\Xml\Builder\InvoiceBuilder;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Despatch\Transportist;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Despatch;
use DateTime;
use Greenter\Ws\Services\SoapClient;
use Greenter\Ws\Services\BillSender;

use App\Models\Rventa;
use App\Models\Detrventa;
use App\Models\Empresa;
use App\Models\Guia;
use App\Models\Sede;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Round;

class SunatController extends Controller
{
    public function getSunatCertificado()
    {
        $pfx = file_get_contents('certificado.p12');
        $password = 'RESPIRA2020';

        $certificate = new X509Certificate($pfx, $password);
        $pem = $certificate->export(X509ContentType::PEM);
        file_put_contents('certificate.pem', $pem);
    }

    public function getSunatCertificadoCer()
    {
        $pfx = file_get_contents('certificado.p12');
        $password = 'RESPIRA2020';

        $certificate = new X509Certificate($pfx, $password);
        $cer = $certificate->export(X509ContentType::CER);
        file_put_contents('certificate.cer', $cer);
    }

    public function ventas(Rventa $rventa)
    {
        $porcentajeIgv = session('igv');
        
        // Cliente
        if (empty($rventa->direccion)) {
            $direccionCliente = null;
        } else {
            $direccionCliente = (new Address())->setDireccion($rventa->direccion);
        }
        $client = new Client();
        $client->setTipoDoc($rventa->cliente->tipdoc_id)
            ->setNumDoc($rventa->cliente->numdoc)
            ->setRznSocial($rventa->cliente->razsoc)
            ->setAddress($direccionCliente);
        
        // Emisor
        $sede = Sede::find($rventa->sede_id);
        $address = new Address();
        $address->setUbigueo($sede->ubigeo)
            ->setDepartamento($sede->departamento)
            ->setProvincia($sede->provincia)
            ->setDistrito($sede->distrito)
            ->setUrbanizacion($sede->urbanizacion)
            ->setDireccion($sede->direccion);
        
        $company = new Company();
        $empresa = Empresa::find($rventa->empresa_id);
        $domFiscal = Sede::where('id',$rventa->sede_id)->where('principal',1)->value('direccion');
        $company->setRuc($empresa->ruc)
            ->setRazonSocial($empresa->razsoc)
            ->setNombreComercial($empresa->razsoc)
            ->setAddress((new Address())
                ->setDepartamento($sede->departamento)
                ->setProvincia($sede->provincia)
                ->setDistrito($sede->distrito)
                ->setUbigueo($sede->ubigeo)
                ->setUrbanizacion($sede->urbanizacion)
                ->setDireccion($domFiscal)
            );

        // Venta
        $detraccion = null;
        if ($rventa->detraccion == 1) {
            $tipoOperacion = '1001';
            $detraccion = (new Detraction())
                ->setCodBienDetraccion($rventa->detraccion_codigo) // catalog. 54
                ->setCodMedioPago('001') // catalog. 59
                ->setCtaBanco($empresa->cuenta)
                ->setPercent($rventa->detraccion_tasa)
                ->setMount($rventa->detraccion_monto);
        } elseif ($rventa->exportacion > 0) {
            $tipoOperacion = '0200';
        } else {
            $tipoOperacion = '0101';
        }
        if ($rventa->gratuito > 0) {
            $gratuitoTotal = Detrventa::where('rventa_id', $rventa->id)
                ->whereNotIn('afectacion_id',['10','20','30','40'])->sum('subtotal');
            $gratuitoAfecto = Detrventa::where('rventa_id', $rventa->id)
                ->where('afectacion_id','>=','11')
                ->where('afectacion_id','<=','19')
                ->sum('subtotal');
            $gratuitoBase = round($gratuitoAfecto / (1 + ($porcentajeIgv / 100)),2);
            $mtoIGVGratuitas = $gratuitoAfecto - $gratuitoBase;
            $mtoOperGratuitas = $gratuitoTotal - $mtoIGVGratuitas;
        } else {
            $mtoIGVGratuitas = 0;
            $mtoOperGratuitas = 0;
        }
        if ($rventa->fpago == 1) {
            $invoice = (new Invoice())
                ->setUblVersion('2.1')
                ->setFecVencimiento(new DateTime($rventa->fecha))
                ->setTipoOperacion($tipoOperacion) // Catalog. 51
                ->setTipoDoc($rventa->tipocomprobante_codigo)
                ->setSerie($rventa->serie)
                ->setCorrelativo($rventa->numero)
                ->setFechaEmision(new DateTime($rventa->fecha))
                ->setFormaPago(new FormaPagoContado())
                ->setTipoMoneda($rventa->moneda)
                ->setCompany($company)
                ->setClient($client)
                ->setMtoOperGravadas($rventa->gravado)
                ->setMtoOperExoneradas($rventa->exonerado)
                ->setMtoOperInafectas($rventa->inafecto)
                ->setMtoOperGratuitas($mtoOperGratuitas)
                ->setMtoOperExportacion($rventa->exportacion)
                ->setMtoIGV($rventa->igv)
                ->setMtoIGVGratuitas($mtoIGVGratuitas)
                ->setTotalImpuestos($rventa->igv + $rventa->icbper)
                ->setIcbper($rventa->icbper)
                ->setValorVenta($rventa->gravado + $rventa->inafecto + $rventa->exonerado + $rventa->exportacion)
                ->setSubTotal($rventa->total)
                ->setMtoImpVenta($rventa->total)
                ->setDetraccion($detraccion);
        } else {
            $invoice = (new Invoice())
                ->setUblVersion('2.1')
                ->setFecVencimiento(new DateTime($rventa->vencimiento))
                ->setTipoOperacion($tipoOperacion) // Catalog. 51
                ->setTipoDoc($rventa->tipocomprobante_codigo)
                ->setSerie($rventa->serie)
                ->setCorrelativo($rventa->numero)
                ->setFechaEmision(new DateTime($rventa->fecha))
                ->setFormaPago(new FormaPagoCredito($rventa->total))
                ->setCuotas([
                    (new Cuota())
                        ->setMonto($rventa->total)
                        ->setFechaPago(new DateTime($rventa->vencimiento))
                ])
                ->setTipoMoneda($rventa->moneda)
                ->setCompany($company)
                ->setClient($client)
                ->setMtoOperGravadas($rventa->gravado)
                ->setMtoOperExoneradas($rventa->exonerado)
                ->setMtoOperInafectas($rventa->inafecto)
                ->setMtoOperGratuitas($mtoOperGratuitas)
                ->setMtoOperExportacion($rventa->exportacion)
                ->setMtoIGV($rventa->igv)
                ->setMtoIGVGratuitas($mtoIGVGratuitas)
                ->setTotalImpuestos($rventa->igv + $rventa->icbper)
                ->setIcbper($rventa->icbper)
                ->setValorVenta($rventa->gravado + $rventa->inafecto + $rventa->exonerado + $rventa->exportacion)
                ->setSubTotal($rventa->total)
                ->setMtoImpVenta($rventa->total)
                ->setDetraccion($detraccion);
        }
        
        $leyendas = array();
        // Leyenda - Total en letras
        if ($rventa->total == 0) {
            $leyenda = (new Legend())
                ->setCode('1002')
                ->setValue('TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE');
            $leyendas = array_merge($leyendas, $leyenda);

        } else {
            $formatter = new NumeroALetras();
            if($rventa->moneda=='PEN'){
                $letra = $formatter->toInvoice($rventa->total, 2, 'soles');
            }else{
                $letra = $formatter->toInvoice($rventa->total, 2, 'dólares americanos');
            }
            $leyenda = (new Legend())
                ->setCode('1000')
                ->setValue($letra);
            array_push($leyendas, $leyenda);
            if ($rventa->gratuito > 0) {
                $leyenda = (new Legend())
                    ->setCode('1002')
                    ->setValue('TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE');
                array_push($leyendas, $leyenda);
            }
        }
        if ($rventa->detraccion == 1) {
            $leyenda = (new Legend())
                ->setCode('2006')
                ->setValue('Operación sujeta a detracción');
            array_push($leyendas, $leyenda);
        }

        //Detalles de Comprobante de Pago
        $detalle = array();
        foreach ($rventa->detrventa as $det) {
            if ($det->icbper > 0) {
                $mtoValorUnitario = round($det->precio / (1 + ($porcentajeIgv / 100)),2); // Sin Impuestos Unitario
                $mtoPrecioUnitario = $det->precio; // Con Impuestos Unitario
                $mtoValorVenta = round($det->subtotal / (1 + ($porcentajeIgv / 100)),2);
                $mtoBaseIgv = round($det->subtotal / (1 + ($porcentajeIgv / 100)),2);
                $igv = round($mtoBaseIgv * ($porcentajeIgv / 100), 2);
                $icbper = $det->icbper;
                $factorIcbper = session('icbper');

                $item = (new SaleDetail())
                    ->setCodProducto(str_pad($det->producto_id, 5, '0', STR_PAD_LEFT))
                    ->setUnidad($det->producto->umedida_id)
                    ->setCantidad($det->cantidad)
                    ->setDescripcion($det->producto->nombre)
                    ->setMtoValorUnitario($mtoValorUnitario)
                    ->setMtoPrecioUnitario($mtoPrecioUnitario)
                    ->setMtoValorVenta($mtoValorVenta)
                    ->setTipAfeIgv($det->afectacion_id)
                    ->setMtoBaseIgv($mtoBaseIgv)
                    ->setPorcentajeIgv($porcentajeIgv)
                    ->setIgv($igv)
                    ->setIcbper($icbper) // (cantidad)*(factor ICBPER)
                    ->setFactorIcbper($factorIcbper)
                    ->setTotalImpuestos($igv + $factorIcbper);
            } else {
                // Gravado
                if ($det->afectacion_id == '10') {
                    $mtoValorUnitario = round($det->precio / (1 + ($porcentajeIgv / 100)),2); // Sin Impuestos Unitario
                    $mtoPrecioUnitario = $det->precio; // Con Impuestos Unitario
                    $mtoValorVenta = round($det->subtotal / (1 + ($porcentajeIgv / 100)),2);
                    $mtoBaseIgv = round($det->subtotal / (1 + ($porcentajeIgv / 100)),2);
                    $igv = round($mtoBaseIgv * ($porcentajeIgv / 100), 2);
                    $item = (new SaleDetail())
                        ->setCodProducto(str_pad($det->producto_id, 5, '0', STR_PAD_LEFT))
                        ->setUnidad($det->producto->umedida_id) // Unidad - Catalog. 03
                        ->setCantidad($det->cantidad)
                        ->setDescripcion($det->producto->nombre)
                        ->setMtoBaseIgv($mtoBaseIgv)
                        ->setPorcentajeIgv($porcentajeIgv) // 18%
                        ->setIgv($igv)
                        ->setTipAfeIgv($det->afectacion_id) // Gravado Op. Onerosa - Catalog. 07
                        ->setTotalImpuestos($igv)
                        ->setMtoValorVenta($mtoValorVenta)
                        ->setMtoValorUnitario($mtoValorUnitario)
                        ->setMtoPrecioUnitario($mtoPrecioUnitario);
                }
                // Gravado - Gratuito
                if ($det->afectacion_id >= '11' && $det->afectacion_id <= '19') {
                    $mtoValorUnitario = round($det->precio / (1 + ($porcentajeIgv / 100)),2); // Sin Impuestos Unitario
                    $mtoPrecioUnitario = $det->precio; // Con Impuestos Unitario
                    $mtoValorVenta = round($det->subtotal / (1 + ($porcentajeIgv / 100)),2);
                    $mtoBaseIgv = round($det->subtotal / (1 + ($porcentajeIgv / 100)),2);
                    $igv = round($mtoBaseIgv * ($porcentajeIgv / 100), 2);

                    $item = (new SaleDetail())
                        ->setCodProducto(str_pad($det->producto_id, 5, '0', STR_PAD_LEFT))
                        ->setUnidad($det->producto->umedida_id)
                        ->setDescripcion($det->producto->nombre)
                        ->setCantidad($det->cantidad)
                        ->setMtoValorUnitario(0.00)
                        ->setMtoValorGratuito($mtoValorUnitario)
                        ->setMtoValorVenta($mtoValorVenta)
                        ->setMtoBaseIgv($mtoBaseIgv)
                        ->setPorcentajeIgv($porcentajeIgv)
                        ->setIgv($igv)
                        ->setTipAfeIgv($det->afectacion_id)
                        ->setTotalImpuestos(36)
                        ->setMtoPrecioUnitario($igv);
                }
                // Exonerado
                if ($det->afectacion_id == '20') {
                    $mtoValorUnitario = $det->precio; // Sin Impuestos Unitario
                    $mtoPrecioUnitario = $det->precio; // Con Impuestos Unitario
                    $mtoValorVenta = $det->subtotal;
                    $mtoBaseIgv = $det->subtotal;
                    $igv = 0;
                    
                    $item = (new SaleDetail())
                        ->setCodProducto(str_pad($det->producto_id, 5, '0', STR_PAD_LEFT))
                        ->setUnidad($det->producto->umedida_id)
                        ->setDescripcion($det->producto->nombre)
                        ->setCantidad($det->cantidad)
                        ->setMtoValorUnitario($mtoValorUnitario)
                        ->setMtoValorVenta($mtoValorVenta)
                        ->setMtoBaseIgv($mtoBaseIgv)
                        ->setPorcentajeIgv(0)
                        ->setIgv($igv)
                        ->setTipAfeIgv($det->afectacion_id)
                        ->setTotalImpuestos(0)
                        ->setMtoPrecioUnitario($mtoPrecioUnitario);
                }
                // Exonerado - Gratuito
                if ($det->afectacion_id >= '21' && $det->afectacion_id <= '29') {
                    $mtoValorUnitario = 0; // Sin Impuestos Unitario
                    $mtoValorGratuito = $det->precio; // Con Impuestos Unitario
                    $mtoValorVenta = $det->subtotal;
                    $mtoBaseIgv = $mtoValorVenta;
                    $igv = 0;

                    $item = (new SaleDetail())
                        ->setCodProducto(str_pad($det->producto_id, 5, '0', STR_PAD_LEFT))
                        ->setUnidad($det->producto->umedida_id)
                        ->setDescripcion($det->producto->nombre)
                        ->setCantidad($det->cantidad)
                        ->setMtoValorUnitario($mtoValorUnitario)
                        ->setMtoValorGratuito($mtoValorGratuito)
                        ->setMtoValorVenta($mtoValorVenta)
                        ->setMtoBaseIgv($mtoBaseIgv)
                        ->setPorcentajeIgv(0)
                        ->setIgv($igv)
                        ->setTipAfeIgv($det->afectacion_id) // Catalog 07: Inafecto - Retiro,
                        ->setTotalImpuestos(0)
                        ->setMtoPrecioUnitario(0);
                }
                // Inafecto
                if ($det->afectacion_id == '30') {
                    $mtoValorUnitario = $det->precio; // Sin Impuestos Unitario
                    $mtoPrecioUnitario = $det->precio; // Con Impuestos Unitario
                    $mtoValorVenta = $det->subtotal;
                    $mtoBaseIgv = $det->subtotal;
                    $igv = 0;
                    
                    $item = (new SaleDetail())
                        ->setCodProducto(str_pad($det->producto_id, 5, '0', STR_PAD_LEFT))
                        ->setUnidad($det->producto->umedida_id)
                        ->setDescripcion($det->producto->nombre)
                        ->setCantidad($det->cantidad)
                        ->setMtoValorUnitario($mtoValorUnitario)
                        ->setMtoValorVenta($mtoValorVenta)
                        ->setMtoBaseIgv($mtoBaseIgv)
                        ->setPorcentajeIgv(0)
                        ->setIgv($igv)
                        ->setTipAfeIgv($det->afectacion_id) // Catalog 07: Inafecto
                        ->setTotalImpuestos(0)
                        ->setMtoPrecioUnitario($mtoPrecioUnitario);
                }
                // Inafecto - Gratuito
                if ($det->afectacion_id >= '31' && $det->afectacion_id <= '39') {
                    $mtoValorUnitario = 0; // Sin Impuestos Unitario
                    $mtoValorGratuito = $det->precio; // Con Impuestos Unitario
                    $mtoValorVenta = $det->subtotal;
                    $mtoBaseIgv = $mtoValorVenta;
                    $igv = 0;

                    $item = (new SaleDetail())
                        ->setCodProducto(str_pad($det->producto_id, 5, '0', STR_PAD_LEFT))
                        ->setUnidad($det->producto->umedida_id)
                        ->setDescripcion($det->producto->nombre)
                        ->setCantidad($det->cantidad)
                        ->setMtoValorUnitario($mtoValorUnitario)
                        ->setMtoValorGratuito($mtoValorGratuito)
                        ->setMtoValorVenta($mtoValorVenta)
                        ->setMtoBaseIgv($mtoBaseIgv)
                        ->setPorcentajeIgv(0)
                        ->setIgv($igv)
                        ->setTipAfeIgv($det->afectacion_id) // Catalog 07: Inafecto - Retiro,
                        ->setTotalImpuestos(0)
                        ->setMtoPrecioUnitario(0);
                }
                // Exportación
                if ($det->afectacion_id >= '40' && $det->afectacion_id <= '49') {
                    $mtoValorUnitario = $det->precio; // Sin Impuestos Unitario
                    $mtoValorGratuito = $det->precio; // Con Impuestos Unitario
                    $mtoValorVenta = $det->subtotal;
                    $mtoBaseIgv = $mtoValorVenta;
                    $mtoPrecioUnitario = $det->precio;
                    $igv = 0;

                    $item = (new SaleDetail())
                        ->setCodProducto(str_pad($det->producto_id, 5, '0', STR_PAD_LEFT))
                        ->setCodProdSunat($det->producto->codigobarra) // Codigo Producto Sunat, requerido.
                        ->setUnidad($det->producto->umedida_id)
                        ->setDescripcion($det->producto->nombre)
                        ->setCantidad($det->cantidad)
                        ->setMtoValorUnitario($mtoValorUnitario)
                        ->setMtoValorVenta($mtoValorVenta)
                        ->setMtoBaseIgv($mtoBaseIgv)
                        ->setPorcentajeIgv(0)
                        ->setIgv($igv)
                        ->setTipAfeIgv($det->afectacion_id) // Catalog 07: Inafecto - Retiro,
                        ->setTotalImpuestos(0)
                        ->setMtoPrecioUnitario($mtoPrecioUnitario);
                }
            }
            // $detalle = array_merge($detalle, $item);
            // dd($item);
            array_push($detalle, $item);
        }
        // dd($detalle);
        $invoice->setDetails($detalle)->setLegends($leyendas);
        $builder = new InvoiceBuilder();
        $xml = $builder->build($invoice);
        $archivo = $rventa->cliente->numdoc .'/'. 
                $empresa->ruc . '-' . 
                $rventa->tipocomprobante_codigo . '-' . 
                $rventa->serie . '-' .
                $rventa->numero.'.xml';
        $content = $xml;
        Storage::disk('invoice')->makeDirectory($rventa->cliente->numdoc);
        //file_put_contents($archivo, $content);
        Storage::disk('invoice')->put($archivo, $content);
        
        $certPath = 'certificate.pem';

        $signer = new SignedXml();
        $signer->setCertificateFromFile($certPath);
        //$xmlSigned = $signer->signFromFile(url('/').'/invoice/'.$archivo);
        $xmlSigned = $signer->signXml($content);
        //file_put_contents($archivo, $xmlSigned);
        Storage::disk('invoice')->put($archivo, $xmlSigned);
        $user = $empresa->ruc.$empresa->usuario;
        $pass = $empresa->clave;
        $urlService = $empresa->servidor;

        $soap = new SoapClient();
        $soap->setService($urlService);
        $soap->setCredentials($user, $pass);
        $sender = new BillSender();
        $sender->setClient($soap);

        $xml = Storage::disk('invoice')->get($archivo);        
        $envio = $empresa->ruc.'-'.$rventa->tipocomprobante_codigo.'-'.$rventa->serie.'-'.$rventa->numero;
        $result = $sender->send($envio, $xml);
        $mensaje = '';
        $status = 0;
        $gravado = $rventa->gravado;
        $exonerado = $rventa->exonerado;
        $inafecto = $rventa->inafecto;
        $exportacion = $rventa->exportacion;
        $gratuito = $rventa->gratuito;
        $igv = $rventa->igv;
        $descuentos = $rventa->descuentos;
        $icbper = $rventa->icbper;
        $total = $rventa->total;
        $pagado = $rventa->pagado;
        $saldo = $rventa->saldo;
        if (!$result->isSuccess()) {
            // Error en la conexion con el servicio de SUNAT
            $abc1 = $result->getError();
            $abc = (array)$abc1;
            $mensaje = 'ERROR:' . ' ' . $abc["\x00*\x00message"];
            $status = 3;
            $gravado = 0.00;
            $exonerado = 0.00;
            $inafecto = 0.00;
            $exportacion = 0.00;
            $gratuito = 0.00;
            $igv = 0.00;
            $descuentos = 0.00;
            $icbper = 0.00;
            $total = 0.00;
            $pagado = 0.00;
            $saldo = 0.00;

            $rventa->update([
                'cdr' => $mensaje,
                'status' => $status,
                'gravado' => $gravado,
                'exonerado' => $exonerado,
                'inafecto' => $inafecto,
                'exportacion' => $exportacion,
                'gratuito' => $gratuito,
                'igv' => $igv,
                'descuentos' => $descuentos,
                'icbper' => $icbper,
                'total' => $total,
                'pagado' => $pagado,
                'saldo' => $saldo
            ]);
            $rventa->detrventa()->delete();
    
            return true;
            // return 'Error de conexión';
        }

        $cdr = $result->getCdrResponse();
        //file_put_contents('invoice/'.$factura->ruc.'/'.'R-'.$envio.'.zip', $result->getCdrZip());
        $arcresul = $rventa->cliente->numdoc.'/'.'R-'.$envio.'.zip';
        Storage::disk('invoice')->put($arcresul, $result->getCdrZip());

        // Verificar CDR (Factura aceptada o rechazada)
        $code = (int)$cdr->getCode();

        if ($code === 0) {
            $mensaje = 'ESTADO: ACEPTADA. | ';
            $status = 2;
            if (count($cdr->getNotes()) > 0) {
                $mensaje .= ' INCLUYE OBSERVACIONES: ';
                // Mostrar observaciones
                foreach ($cdr->getNotes() as $obs) {
                    $mensaje .= 'OBS: '.$obs.', ';
                }
            }
        
        } else if ($code >= 2000 && $code <= 3999) {
            $mensaje = 'ESTADO: RECHAZADA | CÓDIGO: '. $code;
            $status = 3;
            $gravado = 0.00;
            $exonerado = 0.00;
            $inafecto = 0.00;
            $exportacion = 0.00;
            $gratuito = 0.00;
            $igv = 0.00;
            $descuentos = 0.00;
            $icbper = 0.00;
            $total = 0.00;
            $pagado = 0.00;
            $saldo = 0.00;
            $rventa->detrventa()->delete();
        
        } else {
            /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
            /*code: 0100 a 1999 */
            $mensaje .= 'EXCEPCIÓN | CÓDIGO: '. $code;
            $status = 3;
            $gravado = 0.00;
            $exonerado = 0.00;
            $inafecto = 0.00;
            $exportacion = 0.00;
            $gratuito = 0.00;
            $igv = 0.00;
            $descuentos = 0.00;
            $icbper = 0.00;
            $total = 0.00;
            $pagado = 0.00;
            $saldo = 0.00;
            $rventa->detrventa()->delete();
        }
        
        $mensaje .= $cdr->getDescription();

        $rventa->update([
            'cdr' => $mensaje,
            'status' => $status,
            'gravado' => $gravado,
            'exonerado' => $exonerado,
            'inafecto' => $inafecto,
            'exportacion' => $exportacion,
            'gratuito' => $gratuito,
            'igv' => $igv,
            'descuentos' => $descuentos,
            'icbper' => $icbper,
            'total' => $total,
            'pagado' => $pagado,
            'saldo' => $saldo,
        ]);

        return true;
    }

    public function guias(Guia $guia)
    {
        $porcentajeIgv = session('igv');
        
        // Destinatario
        $destinatario = new Client();
        $destinatario->setTipoDoc($guia->cliente->tipdoc_id)
            ->setNumDoc($guia->cliente->numdoc)
            ->setRznSocial($guia->cliente->razsoc);
        // $tercero = new Client();
        // $tercero->setTipoDoc($guia->cliente->tipdoc_id)
        //     ->setNumDoc($guia->cliente->numdoc)
        //     ->setRznSocial($guia->cliente->razsoc);
        
        // Emisor
        $sede = Sede::find($guia->sede_id);
        $address = new Address();
        $address->setUbigueo($sede->ubigeo)
            ->setDepartamento($sede->departamento)
            ->setProvincia($sede->provincia)
            ->setDistrito($sede->distrito)
            ->setUrbanizacion($sede->urbanizacion)
            ->setDireccion($sede->direccion);
        
        $company = new Company();
        $empresa = Empresa::find($guia->empresa_id);
        $domFiscal = Sede::where('id',$guia->sede_id)->where('principal',1)->value('direccion');
        $company->setRuc($empresa->ruc)
            ->setRazonSocial($empresa->razsoc)
            ->setNombreComercial($empresa->razsoc)
            ->setAddress((new Address())
                ->setDepartamento($sede->departamento)
                ->setProvincia($sede->provincia)
                ->setDistrito($sede->distrito)
                ->setUbigueo($sede->ubigeo)
                ->setUrbanizacion($sede->urbanizacion)
                ->setDireccion($domFiscal)
            );

        $rel = new Document();
        $rel->setTipoDoc($guia->tipdoc_relacionado_id) // Cat. 21 - Numero de Orden de Entrega
            ->setNroDoc($guia->numdoc_relacionado);
        
        $transp = new Transportist();
        $transp->setTipoDoc($guia->tipodoctransportista_id)
            ->setNumDoc($guia->numdoctransportista)
            ->setRznSocial($guia->razsoctransportista)
            ->setPlaca($guia->placa)
            ->setChoferTipoDoc($guia->tipodocchofer_id)
            ->setChoferDoc($guia->documentochofer);
        
        $envio = new Shipment();
        $envio->setCodTraslado($guia->motivotraslado_id) // Cat.20
            ->setDesTraslado($guia->motivotraslado->nombre)
            ->setModTraslado($guia->modalidadtraslado_id)  // Cat.18 
            ->setFecTraslado(new DateTime($guia->fechatraslado))
            ->setCodPuerto($guia->puerto)
            ->setIndTransbordo($guia->transbordo)
            ->setPesoTotal($guia->pesototal)
            ->setUndPesoTotal('KGM')
        //    ->setNumBultos(2) // Solo válido para importaciones
            // ->setNumContenedor('XD-2232')
            ->setLlegada(new Direction($guia->ubigeo_llegada, $guia->punto_llegada))
            ->setPartida(new Direction($guia->ubigeo_partida, $guia->punto_partida))
            ->setTransportista($transp);
        
            $despatch = new Despatch();
            $despatch->setTipoDoc($guia->tipocomprobante_codigo)
                ->setSerie($guia->serie)
                ->setCorrelativo($guia->numero)
                ->setFechaEmision(new DateTime($guia->fecha))
                ->setCompany($company)
                ->setDestinatario($destinatario)
                ->setObservacion('NOTA GUIA')
                ->setRelDoc($rel)
                ->setEnvio($envio);

        //Detalles de Comprobante de Pago
        $detalle = array();
        foreach ($guia->detguias as $det) {
            $item = (new SaleDetail())
                ->setCantidad($det->cantidad)
                ->setUnidad($det->producto->umedida_id)
                ->setDescripcion($det->producto->nombre)
                ->setCodProducto(str_pad($det->producto_id, 5, '0', STR_PAD_LEFT));
            }
            // $detalle = array_merge($detalle, $item);
            // dd($item);
        array_push($detalle, $item);
        
        // dd($detalle);
        $despatch->setDetails($detalle);

        $builder = new InvoiceBuilder();
        $xml = $builder->build($despatch);
        $archivo = $guia->cliente->numdoc .'/'. 
                $empresa->ruc . '-' . 
                $guia->tipocomprobante_codigo . '-' . 
                $guia->serie . '-' .
                $guia->numero.'.xml';
        $content = $xml;
        Storage::disk('invoice')->makeDirectory($guia->cliente->numdoc);
        //file_put_contents($archivo, $content);
        Storage::disk('invoice')->put($archivo, $content);
        
        $certPath = 'certificate.pem';

        $signer = new SignedXml();
        $signer->setCertificateFromFile($certPath);
        //$xmlSigned = $signer->signFromFile(url('/').'/invoice/'.$archivo);
        $xmlSigned = $signer->signXml($content);
        //file_put_contents($archivo, $xmlSigned);
        Storage::disk('invoice')->put($archivo, $xmlSigned);
        $user = $empresa->ruc.$empresa->usuario;
        $pass = $empresa->clave;
        $urlService = $empresa->servidor;

        $soap = new SoapClient();
        $soap->setService($urlService);
        $soap->setCredentials($user, $pass);
        $sender = new BillSender();
        $sender->setClient($soap);

        $xml = Storage::disk('invoice')->get($archivo);        
        $envio = $empresa->ruc.'-'.$guia->tipocomprobante_codigo.'-'.$guia->serie.'-'.$guia->numero;
        $result = $sender->send($envio, $xml);
        $mensaje = '';
        $status = 0;
        if (!$result->isSuccess()) {
            // Error en la conexion con el servicio de SUNAT
            $abc1 = $result->getError();
            $abc = (array)$abc1;
            $mensaje = 'ERROR:' . ' ' . $abc["\x00*\x00message"];
            $status = 3;

            $guia->update([
                'cdr' => $mensaje,
                'status' => $status,
            ]);
            $guia->detrventa()->delete();
    
            return true;
            // return 'Error de conexión';
        }

        $cdr = $result->getCdrResponse();
        //file_put_contents('invoice/'.$factura->ruc.'/'.'R-'.$envio.'.zip', $result->getCdrZip());
        $arcresul = $guia->cliente->numdoc.'/'.'R-'.$envio.'.zip';
        Storage::disk('invoice')->put($arcresul, $result->getCdrZip());

        // Verificar CDR (Factura aceptada o rechazada)
        $code = (int)$cdr->getCode();

        if ($code === 0) {
            $mensaje = 'ESTADO: ACEPTADA. | ';
            $status = 2;
            if (count($cdr->getNotes()) > 0) {
                $mensaje .= ' INCLUYE OBSERVACIONES: ';
                // Mostrar observaciones
                foreach ($cdr->getNotes() as $obs) {
                    $mensaje .= 'OBS: '.$obs.', ';
                }
            }
        
        } else if ($code >= 2000 && $code <= 3999) {
            $mensaje = 'ESTADO: RECHAZADA | CÓDIGO: '. $code;
            $status = 3;
            $guia->detrventa()->delete();
        
        } else {
            /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
            /*code: 0100 a 1999 */
            $mensaje .= 'EXCEPCIÓN | CÓDIGO: '. $code;
            $status = 3;
            $guia->detrventa()->delete();
        }
        
        $mensaje .= $cdr->getDescription();

        $guia->update([
            'cdr' => $mensaje,
            'status' => $status,
        ]);

        return true;
    }
}

