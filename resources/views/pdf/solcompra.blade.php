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
                        SOLICITUD DE COMPRA<br>
                        {{-- RUC {{ $empresa->ruc }}<br> --}}
                        N° {{str_pad($solcompra->id, 6, '0', STR_PAD_LEFT)}}
                    </div>
                </td>
            </tr>
        </table>
        <div class="cuadro">
            <table class="tabla">
                <tr>
                    <td width='10%' class="negrita">SOLICITA</td>
                    <td width='40%'>: {{ $solcompra->user->name }}</td>
                    <td width='10%' class="negrita">FECHA</td>
                    <td width='40%'>: {{date('d-m-Y',strtotime($solcompra->fecha))}}</td>
                </tr>
            </table>
        </div>
        <div class="detalle mtop5">
            <table>
                <thead>
                    <tr>
                        <th width="70%">PRODUCTO</th>
                        <th width="10%">U.M.</th>
                        <th width="10%">PEDIDO N°</th>
                        <th width="10%">SOLICITADO</th>
                        <th width="10%">CANTIDAD</th>
                        <th width="10%">STOCK</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($solcompra->detsolcompras as $det)
                    <tr>
                        <td class="text-left">
                            {{ $det->producto->nombre }} <br> 
                            <span class="letra8 negrita">{!! htmlspecialchars_decode(nl2br($det->glosa)) !!}</span>
                        </td>
                        <td>{{ $det->producto->umedida->nombre }}</td>
                        <td>{{ $det->pedidos }}</td>
                        <td>{{ round($det->solicitado,2)==0?'-':round($det->solicitado,2) }}</td>
                        <td>{{ round($det->cantidad,2) }}</td>
                        <td>{{ round($det->producto->stock,2) }}</td>
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
                                    <span class="negrita">OBSERVACIONES:</span> {{ $solcompra->observaciones }}
                                </td>
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
                        <td width='50%' class="altura70"></td>
                        <td width='50%' class="altura70"></td>
                    </tr>
                    <tr>
                        <td class="negrita">{{ $solcompra->user->name }}</td>
                        <td class="negrita">LOGÍSTICA</td>
                    </tr>
                </tbody>
            </table>
        </div>
	</body>
</html>