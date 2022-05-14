<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <title>Tienda</title>
        <link rel="stylesheet" href="{{ url('/static/css/report.css?v='.time()) }}">
	</head>
	<body>
        <table class="cuadrosborde">
            <thead>
                <tr>
                    <td width="10%" class="text-left">
                        {{-- <img src="{{ url('/static/images/logo.jpg') }}" alt=""> --}}
                        Logo
                    </td>
                    <td width="30%" class="text-left lchicas negrita">
                        {{ $empresa->razsoc }}
                    </td>
                    <td width="60%" valign='top'>
                        <div class="text-right lchicas">
                            
                        </div>
                    </td>
                </tr>
            </thead>
        </table>
        <br>
        <div class="text-center letra12 negrita">
            INGRESO MATERIA PRIMA <br>
            LOTE: {{ $materiaprima->lote }}
        </div>
        <table class="tabla">
            <tr>
                <th class="text-left">
                    DATOS DEL GENERALES
                </th>
            </tr>
        </table>
        <div class="detalle">
            <table>
                <tbody>
                    <tr>
                        <th width='10%'>FECHA PARTIDA</th>
                        <td width='10%'>{{ date('d-m-Y',strtotime($materiaprima->fpartida)) }}</td>
                        <th width='10%'>FECHA LLEGADA</th>
                        <td width='10%'>{{ date('d-m-Y',strtotime($materiaprima->fllegada)) }} </td>
                        <th width='10%'>INGRESO PLANTA </th>
                        <td width='10%'>{{ date('d-m-Y',strtotime($materiaprima->ingplanta)) }} </td>
                    </tr>
                    <tr>
                        <th width='10%'>HORA INICIO</th>
                        <td width='10%'>{{ $materiaprima->hinicio }}</td>
                        <th width='10%'>HORA FIN</th>
                        <td width='10%'>{{ $materiaprima->hinicio }}</td>
                        <th width='10%'>TURNO</th>
                        <td width='10%'>
                            @if (substr($materiaprima->hinicio, 0, 2) <= 12)
                                MAÑANA
                            @else
                                TARDE
                            @endif
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <table class="tabla">
            <tr>
                <th class="text-left">
                    DATOS DEL GENERALES
                </th>
            </tr>
        </table>
        
        {{-- <table class="header">
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
                            MATERIA PRIMA <br>
                            {{ 
                            str_pad($tesoreria->sede_id, 2, '0', STR_PAD_LEFT) .'-'.
                            str_pad($tesoreria->id, 8, '0', STR_PAD_LEFT)
                            }} <br>
                            {{ $tesoreria->notaegreso ? ' NOTA INGRESO N°: ' . $tesoreria->notaegreso : '' }}
                        @else
                            LOTE <br>
                            {{ $materiaprima->lote }}
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
            </table>
        </div> --}}
        {{-- <div class="cuadro mtop5">
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
        </div> --}}
        {{-- <div class="detalle mtop5">
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
        </div> --}}
	</body>
</html>