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
                        ORDEN DE COMPRA<br>
                        N° OC-{{str_pad($ordcompra->id, 5, '0', STR_PAD_LEFT)}}
                    </div>
                </td>
            </tr>
        </table>
        <div class="cuadro">
            <table class="tabla">
                <tr>
                    <td width="10%" class="negrita">PROVEEDOR</td>
                    <td width="55%">: {{trim($ordcompra->cliente->razsoc)}}</td>
                    <td width="13%" class="negrita">N° DOCUMENTO</td>
                    <td width="12%">: {{$ordcompra->cliente->numdoc}}</td>
                </tr>
                <tr>
                    <td class="negrita">DIRECCIÓN</td>
                    <td colspan="3">: {{trim($ordcompra->cliente->direccion) }}</td>
                </tr>
                <tr>
                    <td class="negrita">CONTACTO</td>
                    <td>: {{trim($ordcompra->contacto)}}</td>
                    <td class="negrita">N° COTIZACIÓN</td>
                    <td>: {{$ordcompra->cotizacion}}</td>
                </tr>
                <tr>
                    <td class="negrita">DEPÓSITO</td>
                    <td colspan="3">: {{ $cuenta }}</td>
                </tr>
            </table>
        </div>
        <div class="cuadro mtop5">
            <table class="tabla">
                <tr>
                    <td width='20%'>
                        <span class="negrita">FECHA : </span> 
                        {{date('d-m-Y',strtotime($ordcompra->fecha))}}
                    </td>
                    <td width='25%'>
                        <span class="negrita">VENCIMIENTO : </span> 
                        {{date('d-m-Y',strtotime($ordcompra->vencimiento))}}
                    </td>
                    <td width='25%'><span class="negrita">FORMA PAGO : </span> {{$ordcompra->fpago==1?'CONTADO':'CRÉDITO'}}</td>
                    <td width='30%'><span class="negrita">MONEDA : </span> {{$ordcompra->moneda == 'PEN' ? 'SOLES' : 'DÓLARES'}}</td>
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
                    @foreach($ordcompra->detordcompras as $det)
                    <tr>
                        <td>{{ round($det->cantidad,2) }}</td>
                        <td>{{ $det->producto->umedida->nombre }}</td>
                        <td class="text-left">
                            {{ $det->producto->nombre }} <br> 
                            {!! htmlspecialchars_decode(nl2br($det->glosa)) !!}
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
                            <tr>
                                <td colspan="2">
                                    <span class="negrita">OBSERVACIONES: </span> 
                                    @if ($ordcompra->fpago==2)
                                    CRÉDITO A {{ $ordcompra->dias }} DÍAS. <br>
                                    - {!! htmlspecialchars_decode(nl2br($ordcompra->observaciones)) !!}
                                    @endif

                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="30%">
                        <table class="totales">
                            <tr>
                                <td class="negrita">SUBTOTAL @if($ordcompra->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{ number_format($ordcompra->total,2) }}</td>
                            </tr>
                            <tr>
                                <td class="negrita">IGV ({{ intval(session('igv')) }}%) @if($ordcompra->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{ number_format($ordcompra->total*(session('igv')/100),2) }}</td>
                            </tr>
                            <tr>
                                <td class="negrita">TOTAL @if($ordcompra->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{ number_format($ordcompra->total+($ordcompra->total*(session('igv')/100)),2) }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="detalle mtop5">
            <table>
                <tbody>
                    <tr>
                        <td class="negrita">SOLICITADO POR:</td>
                        <td class="negrita">CREADO POR:</td>
                        <td class="negrita">AUTORIZADO POR:</td>
                    </tr>
                    <tr>
                        <td width='33%' class="altura70"></td>
                        <td width='33%' class="altura70"></td>
                        <td width='33%' class="altura70"></td>
                    </tr>
                    <tr>
                        <td class="negrita">
                            @if ($ordcompra->solicitado)
                            {{ $users[$ordcompra->solicitado] }}
                            @endif
                        </td>
                        <td class="negrita">
                            @if ($ordcompra->creado)
                            {{ $users[$ordcompra->creado] }}
                            @endif
                        </td>
                        <td class="negrita">
                            @if ($ordcompra->autorizado)
                            {{ $users[$ordcompra->autorizado] }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
	</body>
</html>