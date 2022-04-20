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
                        CONSUMO<br>
                        RUC {{ $empresa->ruc }}<br>
                        N° {{$rventa->serie.'-'.$rventa->numero}}
                    </div>
                </td>
            </tr>
        </table>
        <div class="cuadro">
            <table class="tabla">
                <tr>
                    <td width="8%" class="negrita">DESTINO</td>
                    <td width="42%">: {{ trim($rventa->detdestino->destino->nombre) }}</td>
                    <td width="8%" class="negrita">DETALLE</td>
                    <td width="42%">: {{ trim($rventa->detdestino->nombre) }}</td>
                </tr>
                <tr>
                    <td class="negrita">C.COSTO</td>
                    <td>: {{ $rventa->ccosto->nombre }}</td>
                    <td class="negrita">FECHA</td>
                    <td>: {{date('d-m-Y',strtotime($rventa->fecha))}}</td>
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
                    @foreach($rventa->detrventa as $det)
                    <tr>
                        <td>{{ round($det->cantidad,2) }}</td>
                        <td>{{ $det->producto->umedida->nombre }}</td>
                        <td class="text-left">
                            {{ $det->producto->nombre }} <br> 
                            {!! htmlspecialchars_decode(nl2br($det->adicional)) !!}
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
                                    <span class="negrita">ENTREGADO POR:</span> {{ $rventa->detalle }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
	</body>
</html>