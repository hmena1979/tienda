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
                        GUÍA DE SALIDA A CÁMARAS<br>
                        N° {{str_pad($salcamara->numero, 6, '0', STR_PAD_LEFT)}}
                    </div>
                </td>
            </tr>
        </table>
        <div class="cuadro">
            <table class="tabla">
                <tr>
                    <td width="10%" class="negrita">FECHA</td>
                    <td width="25%">: {{ date('d-m-Y',strtotime($salcamara->fecha)) }}</td>
                    <td width="8%" class="negrita">MOTIVO</td>
                    <td width="15%">: {{ $salcamara->motivo==1?'EXPORTACIÓN':'MUESTREO' }}</td>
                    <td width="15%" class="negrita">SUPERVISOR</td>
                    <td width="25%">: {{ $salcamara->supervisor->nombre }}</td>
                </tr>
                <tr>
                    <td class="negrita">TRANSPORTISTA</td>
                    <td>: {{ $salcamara->transportista->nombre }}</td>
                    <td class="negrita">PLACAS</td>
                    <td>: {{ $salcamara->placas }}</td>
                    <td class="negrita">GUIA TRANSP</td>
                    <td>: {{ $salcamara->grt }}</td>
                </tr>
                <tr>
                    <td class="negrita">PRECINTOS</td>
                    <td>: {{ $salcamara->precinto }}</td>
                    <td class="negrita">CONTENEDOR</td>
                    <td>: {{ $salcamara->contenedor }}</td>
                    <td class="negrita">GUIA REMITENTE</td>
                    <td>: {{ $salcamara->gr }}</td>
                </tr>
                {{-- <tr>
                    <td class="negrita">SUPERVISOR</td>
                    <td colspan="3">: {{ $salcamara->supervisor->nombre }}</td>
                    <td class="negrita"></td>
                    <td></td>
                </tr> --}}
            </table>
        </div>
        <div class="detalle mtop5">
            <table>
                <thead>
                    <tr>
                        <th class="text-left" width="22%">Producto</th>
                        <th class="text-left" width="22%">Lotes</th>
                        <th class="text-left" width="18%">Código</th>
                        <th width="10%">Cantidad</th>
                        <th width="10%">Peso</th>
                        <th width="10%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salcamara->detsalcamaras as $det)
                    <tr>
                        <td class="text-left">{{ $det->dettrazabilidad->trazabilidad->nombre }}</td>
                        <td class="text-left">{{ $det->lotes }}</td>
                        <td class="text-left">{{ $det->dettrazabilidad->mpd_codigo }}</td>
                        <td>{{ $det->cantidad }}</td>
                        <td>{{ $det->peso }}</td>
                        <td>{{ $det->total }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"></td>
                        <th>{{ number_format($salcamara->sacos) }}</th>
                        <td></td>
                        <th>{{ number_format($salcamara->pesoneto) }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="cuadro mtop5">
            <table>
                <tr>
                    <td>
                        <span class="negrita">OBSERVACIONES: </span> <br>
                        {!! htmlspecialchars_decode(nl2br($salcamara->observaciones)) !!}
                    </td>
                </tr>
            </table>
        </div>
        <div class="detalle mtop5">
            <table>
                <tbody>
                    <tr>
                        <td class="negrita">SUPERVISOR ENVASADO:</td>
                        <td class="negrita">JEFE PRODUCCIÓN:</td>
                    </tr>
                    <tr>
                        <td width='33%' class="altura70"></td>
                        <td width='33%' class="altura70"></td>
                    </tr>
                    <tr>
                        <td class="negrita">
                            @if ($salcamara->supervisor_id)
                            {{ $salcamara->supervisor->nombre }}
                            @endif
                        </td>
                        <td class="negrita">
                            @if ($salcamara->user_id)
                            {{ $users[$salcamara->user_id] }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
	</body>
</html>