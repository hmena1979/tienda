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
                        GUÍA DE INGRESO A CÁMARAS<br>
                        N° {{str_pad($ingcamara->numero, 6, '0', STR_PAD_LEFT)}}
                    </div>
                </td>
            </tr>
        </table>
        <div class="cuadro">
            <table class="tabla">
                <tr>
                    <td width="10%" class="negrita">FECHA</td>
                    <td width="20%">: {{ date('d-m-Y',strtotime($ingcamara->fecha)) }}</td>
                    <td width="22%" class="negrita">FECHA DE PRODUCCIÓN</td>
                    <td width="18%">: {{ date('d-m-Y',strtotime($ingcamara->fproduccion)) }}</td>
                    <td width="8%" class="negrita">LOTE</td>
                    <td width="22%">: {{ $ingcamara->lote }}</td>
                </tr>
                <tr>
                    <td class="negrita">SUPERVISOR</td>
                    <td colspan="3">: {{ $ingcamara->supervisor->nombre }}</td>
                    <td class="negrita"></td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div class="detalle mtop5">
            <table>
                <thead>
                    <tr>
                        <th class="text-left" width="22%">Producto</th>
                        <th class="text-left" width="18%">Código</th>
                        <th width="10%">Presentación</th>
                        <th width="10%">Peso</th>
                        <th width="10%">Cantidad</th>
                        <th width="10%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ingcamara->detingcamaras as $det)
                    <tr>
                        <td class="text-left">{{ $det->dettrazabilidad->trazabilidad->nombre }}</td>
                        <td class="text-left">{{ $det->dettrazabilidad->mpd_codigo }}</td>
                        <td>{{ $det->dettrazabilidad->envase==1?'Saco':'Block' }}</td>
                        <td>{{ $det->peso }}</td>
                        <td>{{ $det->cantidad }}</td>
                        <td>{{ $det->total }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4"></td>
                        <th>{{ number_format($ingcamara->detingcamaras->sum('cantidad')) }}</th>
                        <th>{{ number_format($ingcamara->detingcamaras->sum('total')) }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="cuadro mtop5">
            <table>
                <tr>
                    <td>
                        <span class="negrita">OBSERVACIONES: </span> <br>
                        {!! htmlspecialchars_decode(nl2br($ingcamara->observaciones)) !!}
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
                            @if ($ingcamara->supervisor_id)
                            {{ $ingcamara->supervisor->nombre }}
                            @endif
                        </td>
                        <td class="negrita">
                            @if ($ingcamara->user_id)
                            {{ $users[$ingcamara->user_id] }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
	</body>
</html>