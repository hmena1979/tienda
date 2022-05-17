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
                    <td width="30%" class="text-left letra8 negrita">
                        {{ $empresa->razsoc }}
                    </td>
                    <td width="60%" valign='top'>
                        <div class="text-right letra8">
                            
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
        <br>
        <table class="tabla">
            <tr>
                <th class="text-left letra9">
                    DATOS DEL GENERALES
                </th>
            </tr>
        </table>
        <div class="detalle">
            <table>
                <tbody>
                    <tr>
                        <td class="text-left negrita" width='10%'>Hora Inicio:</td>
                        <td class="text-left" width='10%'>{{ $materiaprima->hinicio }}</td>
                        <td class="text-left negrita" width='10%'>Hora Fin:</td>
                        <td class="text-left" width='10%'>{{ $materiaprima->hinicio }}</td>
                        <td class="text-left negrita" width='10%'>Turno:</td>
                        <td class="text-left" width='10%'>
                            @if (substr($materiaprima->hinicio, 0, 2) <= 12)
                                MAÑANA
                            @else
                                TARDE
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left negrita">Fecha Partida:</td>
                        <td class="text-left">{{ date('d-m-Y',strtotime($materiaprima->fpartida)) }}</td>
                        <td class="text-left negrita">Fecha Llegada:</td>
                        <td class="text-left">{{ date('d-m-Y',strtotime($materiaprima->fllegada)) }} </td>
                        <td class="text-left negrita">Ingreso Planta: </td>
                        <td class="text-left">{{ date('d-m-Y',strtotime($materiaprima->ingplanta)) }} </td>
                    </tr>
                    <tr>
                        <td class="text-left negrita">Zona Acopio:</td>
                        <td class="text-left">{{ $materiaprima->lugar }}</td>
                        <td class="text-left negrita">Producto:</td>
                        <td class="text-left" colspan="3">{{ $materiaprima->producto->nombre }} </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <br>
        <table class="tabla">
            <tr>
                <th class="text-left letra9">
                    INFORMACIÓN PLANTA
                </th>
            </tr>
        </table>
        <div class="detalle">
            <table>
                <tbody>
                    <tr>
                        <td class="text-left negrita" width='15%'>Ticket Balanza:</td>
                        <td class="text-left" width='10%'>{{ $materiaprima->ticket_balanza }}</td>
                        <td class="text-left negrita" width='15%'>Peso Planta:</td>
                        <td class="text-left" width='10%'>{{ number_format($materiaprima->pplanta,2) }} </td>
                        <td class="text-left negrita" width='10%'>N° Batch: </td>
                        <td class="text-left" width='10%'>{{ $materiaprima->batch }} </td>
                        <td class="text-left negrita" width='10%'>Cajas: </td>
                        <td class="text-left" width='10%'>{{ $materiaprima->cajas }} </td>
                    </tr>
                    <tr>
                        <td class="text-left negrita">Destare KG:</td>
                        <td class="text-left">{{ number_format($materiaprima->destare,2) }}</td>
                        <td class="text-left negrita">Observaciones:</td>
                        <td class="text-left" colspan="5">{{ $materiaprima->observaciones }} </td>
                    </tr>

                </tbody>
            </table>
        </div>


        <br>
        <table class="tabla">
            <tr>
                <th class="text-left letra9">
                    INFORMACIÓN DEL PROVEEDOR
                </th>
            </tr>
        </table>
        <div class="detalle">
            <table>
                <tbody>
                    <tr> {{ $materiaprima->cliente_id }}
                        <td class="text-left negrita" width='17%'>RUC:</td>
                        <td class="text-left" width='10%'>
                            {{ empty($materiaprima->cliente_id)?'PENDIENTE':$materiaprima->cliente->numdoc }}
                        </td>
                        <td class="text-left negrita" width='16%'>Razón Social:</td>
                        <td class="text-left" width='57%'>
                            {{ empty($materiaprima->cliente_id)?'PENDIENTE':$materiaprima->cliente->razsoc }}
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        
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