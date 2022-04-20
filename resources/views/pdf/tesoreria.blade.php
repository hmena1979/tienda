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
                        @if ($tesoreria->tipo == 1)
                            TESORERÍA INGRESOS <br>
                            {{ 
                            str_pad($tesoreria->sede_id, 2, '0', STR_PAD_LEFT) .'-'.
                            str_pad($tesoreria->id, 8, '0', STR_PAD_LEFT)
                            }} <br>
                            {{ $tesoreria->notaegreso ? ' NOTA INGRESO N°: ' . $tesoreria->notaegreso : '' }}
                        @else
                            TESORERÍA EGRESOS <br>
                            {{ 
                            str_pad($tesoreria->sede_id, 2, '0', STR_PAD_LEFT) .'-'.
                            str_pad($tesoreria->id, 8, '0', STR_PAD_LEFT)
                            }} <br>
                            {{ $tesoreria->notaegreso ? ' NOTA EGRESO N°: ' . $tesoreria->notaegreso : '' }}
                        @endif
                    </div>
                </td>
            </tr>
        </table>
        <div class="cuadro">
            <table class="tabla">
                <tr>
                    <td width="8%" class="negrita">CUENTA</td>
                    <td width="38%">: {{ trim($tesoreria->cuenta->nombre) }}</td>
                    <td width="16%" class="negrita">MEDIO DE PAGO</td>
                    <td width="38%">: {{ $tesoreria->mediopagos->nombre }}</td>
                </tr>
                {{-- <tr>
                    <td class="negrita">DIRECCIÓN</td>
                    <td colspan="3">: {{trim($rventa->direccion)}}</td>
                </tr> --}}
            </table>
        </div>
        <div class="cuadro mtop5">
            <table class="tabla">
                <tr>
                    <td width="8%" class="negrita">FECHA</td>
                    <td width="12%">: {{ date('d-m-Y',strtotime($tesoreria->fecha)) }} </td>
                    <td width="13%" class="negrita">N° OPERACIÓN</td>
                    <td width="15%">: {{ $tesoreria->numerooperacion }} </td>
                    <td width="10%" class="negrita">GLOSA</td>
                    <td width="40%">: {{ $tesoreria->glosa }} </td>
                </tr>
            </table>
        </div>
        <div class="detalle mtop5">
            <table>
                <thead>
                    <tr>
                        <th class="text-left" width="35%">CLIENTE</th>
                        <th class="text-left" width="35%">DOCUMENTO</th>
                        <th class="text-right" width="10%">SOLES</th>
                        <th class="text-right" width="10%">DOLARES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tesoreria->dettesors as $det)
                    <tr>
                        <td class="text-left">{{ $det->dettesorable->cliente->razsoc }}</td>
                        <td class="text-left">
                            {{ 
                            $det->dettesorable->tipocomprobante_codigo.'-'.
                            numDoc($det->dettesorable->serie,$det->dettesorable->numero) 
                            }}
                        </td>
                        <td class="text-right @if ($tesoreria->cuenta->moneda == 'PEN') negrita @endif">
                            {{ number_format($det->montopen, 2) }}
                        </td>
                        <td class="text-right @if ($tesoreria->cuenta->moneda == 'USD') negrita @endif">
                            {{ number_format($det->montousd, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="detalle mtop5">
            <table>
                <tbody>
                    <tr>
                        <td width="70%" class="text-right negrita"> MONTO TOTAL</td>
                        <td class="text-right @if ($tesoreria->cuenta->moneda == 'PEN') negrita @endif"" width="10%">
                            {{ number_format($tesoreria->dettesors->sum('montopen'), 2) }}
                        </td>
                        <td class="text-right @if ($tesoreria->cuenta->moneda == 'USD') negrita @endif"" width="10%">
                            {{ number_format($tesoreria->dettesors->sum('montousd'), 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="detalle mtop5">
            <table>
                <tbody>
                    <tr>
                        <td width='50%' class="altura70"></td>
                        <td width='50%' class="altura70"></td>
                    </tr>
                    <tr>
                        <td class="negrita">RECIBÍ CONFORME</td>
                        <td class="negrita">ENTREGADO POR</td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- <div class="cuadro mtop5">
            <table>
                <tr>
                    <td valign='top' width="70%">
                        <table class="letras">
                            <tr>
                                <td colspan="2">
                                    <span class="negrita">OBSERVACIONES: </span> 
                                    ENTREGADO POR:  {{ $rcompra->entregadopor }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="30%">
                        <table class="totales">
                            <tr>
                                <td class="negrita">TOTAL @if($rcompra->moneda=='PEN') S/ @else US$ @endif</td>
                                <td class="text-right">{{number_format($rcompra->detingresos->sum('subtotal'),2)}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div> --}}
	</body>
</html>