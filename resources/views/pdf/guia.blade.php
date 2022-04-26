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
                        GUÍA DE REMISIÓN<br>
                        ELECTRÓNICA - REMITENTE<br>
                        RUC {{ $empresa->ruc }}<br>
                        N° {{$guia->serie.'-'.$guia->numero}}
                    </div>
                </td>
            </tr>
        </table>
        <div class="cuadro">
            <table class="tabla">
                <tr>
                    <th class="text-left" colspan="4">DATOS DEL TRASLADO</th>
                </tr>
                <tr>
                    <td width="20%" class="negrita">FECHA DE EMISIÓN</td>
                    <td width="29%">: {{date('d-m-Y',strtotime($guia->fecha))}}</td>
                    <td width="26%" class="negrita">FECHA INICIO TRASLADO</td>
                    <td width="25%">: {{date('d-m-Y',strtotime($guia->fechatraslado))}}</td>
                </tr>
                <tr>
                    <td class="negrita">MOTIVO DE TRASLADO</td>
                    <td>: {{ $guia->motivotraslado->nombre }}</td>
                    <td class="negrita">MODALIDAD DE TRANSPORTE</td>
                    <td>: {{ $guia->modalidadtraslado->nombre }}</td>
                </tr>
                <tr>
                    <td class="negrita">PESO BRUTO TOTAL:</td>
                    <td colspan="3">: {{ $guia->pesototal }} KGM</td>
                </tr>
            </table>
        </div>
        <div class="cuadro mtop5">
            <table class="tabla">
                <tr>
                    <th class="text-left" colspan="4">DATOS DEL DESTINATARIO</th>
                </tr>
                <tr>
                    <td width="20%" class="negrita">DESTINATARIO</td>
                    <td width="45%">: {{ $guia->cliente->razsoc }}</td>
                    <td width="15%" class="negrita">DOCUMENTO N°</td>
                    <td width="20%">: {{ $guia->cliente->numdoc }}</td>
                </tr>
            </table>
        </div>
        <div class="cuadro mtop5">
            <table class="tabla">
                <tr> 
                    <th class="text-left" colspan="2">DATOS DEL PUNTO DE PARTIDA Y PUNTO DE LLEGADA</th>
                </tr>
                <tr>
                    <td width="25%" class="negrita">DIRECCIÓN PUNTO PARTIDA</td>
                    <td width="75%">: {{ $guia->ubigeo_partida . ' - ' . $guia->punto_partida }}</td>
                </tr>
                <tr>
                    <td class="negrita">DIRECCIÓN PUNTO LLEGADA</td>
                    <td>: {{ $guia->ubigeo_llegada . ' - ' . $guia->punto_llegada }}</td>
                </tr>
            </table>
        </div>
        @if ($guia->modalidadtraslado_id == '01')
        <div class="cuadro mtop5">
            <table class="tabla">
                <tr> 
                    <th class="text-left" colspan="6">DATOS DEL TRANSPORTE</th>
                </tr>
                <tr>
                    <td width="20%" class="negrita">TIPO DOCUMENTO</td>
                    <td width="80%">: {{ !empty($guia->tipodoctransportista_id)?$tipdoc[$guia->tipodoctransportista_id] : '' }}</td>
                </tr>
                <tr>
                    <td class="negrita">NÚMERO DOCUMENTO</td>
                    <td>: {{ $guia->numdoctransportista }}</td>
                </tr>
                <tr>
                    <td class="negrita">RAZÓN SOCIAL</td>
                    <td>: {{ $guia->razsoctransportista }}</td>
                </tr>
            </table>
        </div>
        @else
        <div class="cuadro mtop5">
            <table class="tabla">
                <tr> 
                    <th class="text-left" colspan="4">DATOS DEL TRANSPORTE</th>
                </tr>
                <tr>
                    <td class="text-left negrita" colspan="4">VEHÍCULO:</td>
                </tr>
                <tr>
                    <td class="text-left negrita">PLACA</td>
                    <td colspan="3">{{ $guia->placa }}</td>
                </tr>
                <tr> 
                    <td class="text-left negrita" colspan="4">CONDUCTOR:</td>
                </tr>
                <tr>
                    <td width="20%" class="negrita">TIPO DOCUMENTO</td>
                    <td width="40%">: {{ $tipdoc[$guia->tipodocchofer_id] }}</td>
                    <td width="20%" class="negrita">NÚMERO DOCUMENTO</td>
                    <td width="20%">: {{ $guia->documentochofer }}</td>
                </tr>
            </table>
        </div>
        @endif
        
        <div class="detalle mtop5">
            <table>
                <thead>
                    <tr>
                        <th width="10%">CANTIDAD</th>
                        <th width="10%">U.M.</th>
                        <th width="50%">DESCRIPCIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guia->detguias as $det)
                    <tr>
                        <td>{{ round($det->cantidad,2) }}</td>
                        <td>{{ $det->producto->umedida_id }}</td>
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
                            <tr class="borde-inferior">
                                <td valign='middle' width="20%">
                                    <img class="mtop5 mbottom5" src="data:image/png;base64,{!! $qrcode !!}" alt="">
                                </td>
                                <td valign='middle' width="80%" class="text-justify">
                                    Representación impresa de la Guía de Remisión Electrónica. <br>
                                    Autorizado mediante Resolución de Intendencia Nº 279-2019/SUNAT <br>
                                    Puede ser consultada en: {{$empresa->dominio}}/cpe
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="negrita">OBSERVACIONES: </span> 
                                </td>
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