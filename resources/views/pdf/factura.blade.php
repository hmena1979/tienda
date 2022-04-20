<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Tienda</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="routeName" content="{{ Route::currentRouteName() }}">

        <!-- Styles
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
        -->
        <link rel="stylesheet" href="{{ url('/static/css/invoice.css?v='.time()) }}">
	</head>
	<body>
        <table class="header">
            <tr>
                <td width="15%" valign='middle'>
                    <img class="img" src="{{ url('/static/images/logo.jpg') }}" width="100">
                </td>
                <td width="45%" valign='middle' class="text-center">
                    <div class="razsoc">{{ $empresa->razsoc }}</div>
                    <div class="direccion">
                        {{ $sede->urbanizacion . ' ' .
                        $sede->direccion }} <br> 
                        {{ $sede->provincia . ' - ' .
                        $sede->distrito . ' - ' .
                        $sede->departamento}}
                    </div>
                </td>
                <td width="40%" valign='top'>
                    <div class="numero text-center">
                        FACTURA ELECTRÓNICA<br>
                        RUC {{ $empresa->ruc }}<br>
                        N° {{$rventa->serie.'-'.$rventa->numero}}
                    </div>
                </td>
            </tr>
        </table>
        <div class="cuadro">
            <table class="tabla">
                <tr>
                    <td width="10%" class="negrita">CLIENTE</td>
                    <td width="55%">: {{trim($rventa->cliente->razsoc)}}</td>
                    <td width="13%" class="negrita">N° DOCUMENTO</td>
                    <td width="12%">: {{$rventa->cliente->numdoc}}</td>
                </tr>
                <tr>
                    <td class="negrita">DIRECCIÓN</td>
                    <td colspan="3">: {{trim($rventa->direccion)}}</td>
                </tr>
            </table>
        </div>
        <div class="cuadro mtop5">
            <table class="tabla">
                <tr>
                    <td width='25%'>
                        <span class="negrita">FECHA : </span> 
                        {{date('d-m-Y',strtotime($rventa->fecha))}}
                    </td>
                    <td width='25%'>
                        <span class="negrita">VENCIMIENTO : </span> 
                        {{date('d-m-Y',strtotime($rventa->vencimiento))}}
                    </td>
                    <td width='25%'><span class="negrita">FORMA PAGO : </span> {{$rventa->fpago==1?'CONTADO':'CRÉDITO'}}</td>
                    <td width='25%'><span class="negrita">MONEDA : </span> {{$rventa->moneda == 'PEN' ? 'SOLES' : 'DÓLARES'}}</td>
                </tr>
            </table>
        </div>
        <div class="detalle mtop5">
            <table>
                <thead>
                    <tr>
                        <th width="10%">CANTIDAD</th>
                        <th width="10%">U.M.</th>
                        <th width="50%">DESCRIPCIÓN</th>
                        <th width="10%">VALOR<br>UNITARIO</th>
                        <th class="text-right" width="10%">IMPORTE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rventa->detrventa as $det)
                    <tr>
                        <td>{{ round($det->cantidad,2) }}</td>
                        <td>{{ $det->producto->umedida->nombre }}</td>
                        <td class="text-left">
                            {{ $det->producto->nombre }} <br> 
                            {!! htmlspecialchars_decode(nl2br($det->adicional)) !!}
                        </td>
                        <td>{{ number_format($det->precio, 2) }}</td>
                        <td class="text-right">{{ number_format($det->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="cuadro mtop5">
            <table>
                <tr>
                    <td valign='top' width="70%">
                        <table class="letras">
                            <tr>
                                <td class="borde-inferior" colspan="2">
                                    <span class="negrita">SON: </span> {{ $letra }}
                                </td>
                            </tr>
                            <tr class="borde-inferior">
                                <td valign='middle' width="20%">
                                    <img class="mtop5 mbottom5" src="data:image/png;base64,{!! $qrcode !!}" alt="">
                                </td>
                                <td valign='middle' width="80%" class="text-justify">
                                    Representación impresa de la Factura Electrónica. <br>
                                    Autorizado mediante Resolución de Intendencia Nº 279-2019/SUNAT <br>
                                    Puede ser consultada en: {{$empresa->dominio}}/cpe
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="negrita">OBSERVACIONES: </span> 
                                    @if ($rventa->fpago==1)
                                    MEDIO DE PAGO: {{ $mediopago[$rventa->mediopago].'.' }}
                                    @if ($rventa->mediopago == '008')
                                    PAGA CON {{ $rventa->moneda == 'PEN' ? 'S/ ' : 'US$ ' }} {{ number_format($rventa->pagacon,2) }} 
                                    VUELTO {{ $rventa->moneda == 'PEN' ? 'S/ ' : 'US$ ' }} {{ number_format($rventa->pagacon - $rventa->total,2) }}
                                    @endif
                                    @else
                                    CRÉDITO A {{ $rventa->dias }} días
                                    @endif

                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="30%">
                        <table class="totales">
                            <tr>
                                <td class="negrita">EXPORTACIÓN @if($rventa->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{number_format($rventa->exportacion,2)}}</td>
                            </tr>
                            <tr>
                                <td class="negrita">GRAVADO @if($rventa->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{number_format($rventa->gravado,2)}}</td>
                            </tr>
                            <tr>
                                <td class="negrita">INAFECTO @if($rventa->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{number_format($rventa->inafecto,2)}}</td>
                            </tr>
                            <tr>
                                <td class="negrita">EXONERADO @if($rventa->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{number_format($rventa->exonerado,2)}}</td>
                            </tr>
                            <tr>
                                <td class="negrita">GRATUITO @if($rventa->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{number_format($rventa->gratuito,2)}}</td>
                            </tr>
                            <tr>
                                <td class="negrita">ICBPER @if($rventa->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{number_format($rventa->icbper,2)}}</td>
                            </tr>
                            <tr>
                                <td class="negrita">IGV ({{round($empresa->por_igv,2)}}%) @if($rventa->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{number_format($rventa->igv,2)}}</td>
                            </tr>
                            <tr>
                                <td class="negrita">TOTAL @if($rventa->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{number_format($rventa->total,2)}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        {{-- @if(strlen($factura->observaciones)>0)
        <div class="cuadro mtop5">
            <table class="cliente">
                <tr>
                    <th class="text-left" width="50%">OBSERVACIONES:</th>
                </tr>
                <tr>
                    <td class="text-left" width="50%">
                        {!! htmlspecialchars_decode(nl2br($factura->observaciones)) !!}
                    </th>
                </tr>
            </table>
        </div>
        @endif --}}
	</body>
</html>