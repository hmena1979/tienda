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
                        PEDIDO<br>
                        {{-- RUC {{ $empresa->ruc }}<br> --}}
                        N° {{str_pad($pedido->id, 6, '0', STR_PAD_LEFT)}}
                    </div>
                </td>
            </tr>
        </table>
        <div class="cuadro">
            <table class="tabla">
                <tr>
                    <td class="negrita">SOLICITA</td>
                    <td>: {{ $pedido->user->name }}</td>
                    <td class="negrita">ESTADO</td>
                    <td>: {{ $estados[$pedido->estado] }}</td>
                </tr>
                <tr>
                    <td width="8%" class="negrita">DESTINO</td>
                    <td width="42%">: {{ trim($pedido->detdestino->destino->nombre) }}</td>
                    <td width="8%" class="negrita">DETALLE</td>
                    <td width="42%">: {{ trim($pedido->detdestino->nombre) }}</td>
                </tr>
                <tr>
                    <td class="negrita">FECHA</td>
                    <td>: {{date('d-m-Y',strtotime($pedido->fecha))}}</td>
                    <td class="negrita">LOTE</td>
                    <td>: {{ $pedido->lote }}</td>
                </tr>
            </table>
        </div>
        <div class="detalle mtop5">
            <table>
                <thead>
                    <tr>
                        <th width="10%">CANTIDAD</th>
                        <th width="10%">U.M.</th>
                        <th width="70%">DESCRIPCIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedido->detpedidos as $det)
                    <tr>
                        <td>{{ round($det->cantidad,2) }}</td>
                        <td>{{ $det->producto->umedida->nombre }}</td>
                        <td class="text-left">
                            {{ $det->producto->nombre }} <br> 
                            {!! htmlspecialchars_decode(nl2br($det->glosa)) !!}
                        </td>
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
                                    <span class="negrita">OBSERVACIONES:</span> {{ $pedido->observaciones }}
                                </td>
                            </tr>
                            <tr>
                                <td class="borde-inferior" colspan="2">
                                    <span class="negrita">RESPUESTA LOGÍSTICA:</span> {{ $pedido->obslogistica }}
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
                        <td class="negrita">{{ $pedido->user->name }}</td>
                        <td class="negrita">ALMACÉN / LOGÍSTICA</td>
                    </tr>
                </tbody>
            </table>
        </div>
	</body>
</html>