<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8">
        <title>Tienda</title>
        <link rel="stylesheet" href="{{ url('/static/css/report.css?v='.time()) }}">
	</head>
	<body>
        {{-- <div class="footer letra9">
            {{ $sede->direccion}}&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;{{ $empresa->dominio }}&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;<br>
            Telef. {{ $sede->telefono}}&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;Cel: {{ $sede->celular}}
        </div> --}}
        <table class="cuadrosborde">
            <thead>
                <tr>
                    <td width="7%" class="text-left">
                        <img class="logo" src="{{ url('/static/images/logo.jpg') }}" alt="">
                        {{-- Logo --}}
                    </td>
                    <td width="33%" class="text-left letra8 negrita">
                        {{ $empresa->razsoc }}
                    </td>
                    <td width="40%"></td>
                    <td width="20%" valign='top'  class="text-right letra8">
                        <span class="negrita">Fecha:</span>  {{ Carbon\Carbon::now()->format('Y-m-d') }}
                    </td>
                </tr>
            </thead>
        </table>
        <div class="text-center letra12 negrita">
            INGRESO MATERIA PRIMA <br>
            LOTE: {{ $materiaprima->lote }}
        </div>
        <br>
        <div class="letra9 negrita">DATOS DEL GENERALES</div>
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
        <div class="letra6">{!! htmlspecialchars_decode("&nbsp;") !!}</div>
        <div class="letra9 negrita">DATOS DEL PROVEEDOR</div>
        <div class="detalle">
            <table>
                <tbody>
                    <tr> {{ $materiaprima->cliente_id }}
                        <td class="text-left negrita">RUC:</td>
                        <td class="text-left">
                            {{ empty($materiaprima->cliente_id)?'PENDIENTE':$materiaprima->cliente->numdoc }}
                        </td>
                        <td class="text-left negrita">Razón Social:</td>
                        <td class="text-left" width='45%' colspan="3">
                            {{ empty($materiaprima->cliente_id)?'PENDIENTE':$materiaprima->cliente->razsoc }}
                        </td>
                    </tr>
                        <td class="text-left negrita" width='17%'>Tipo Comprobante:</td>
                        <td class="text-left" width='25%'>
                            @if ($materiaprima->rcompra_id)
                            {{ $materiaprima->rcompra->tipocomprobante_codigo.'-'.$tipocomprobante[$materiaprima->rcompra->tipocomprobante_codigo] }}
                            @endif
                        </td>
                        <td class="text-left negrita" width='13%'>Número:</td>
                        <td class="text-left">
                            @if ($materiaprima->rcompra_id)
                            {{ $materiaprima->rcompra->serie_numero }}
                            @endif
                        </td>
                        <td class="text-left negrita" >N° Certif. Procedencia:</td>
                        <td>{{ $materiaprima->certprocedencia }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="letra6">{!! htmlspecialchars_decode("&nbsp;") !!}</div>
        <div class="letra9 negrita">DATOS DEL TRANSPORTE</div>
        <div class="detalle">
            <table>
                <tbody>
                    <tr>
                        <td class="text-left negrita" width='17%'>RUC:</td>
                        <td class="text-left" width='13%'>
                            {{ empty($materiaprima->transportista_id)?'PENDIENTE':$materiaprima->transportista->ruc }}
                        </td>
                        <td class="text-left negrita" width='17%'>Razón Social:</td>
                        <td class="text-left" width='53%'>
                            {{ empty($materiaprima->transportista_id)?'PENDIENTE':$materiaprima->transportista->nombre }}
                        </td>
                    </tr>
                    <tr> {{ $materiaprima->transportista_guia }}
                        <td class="text-left negrita" width='17%'>Guía Remitente:</td>
                        <td class="text-left" width='13%'>{{ $materiaprima->remitente_guia }}</td>
                        <td class="text-left negrita" width='15%'>Guía Tranportista:</td>
                        <td class="text-left" width='55%'>{{ $materiaprima->transportista_guia }} </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody>
                    <tr>
                        <td colspan="3" class="text-center negrita">CÁMARA</td>
                        <td colspan="2" class="text-center negrita">CHOFER</td>
                    </tr>
                    <tr>
                        <td class="negrita">Marca Placa</td>
                        <td class="negrita">Protocolo</td>
                        <td class="negrita">Capacidad</td>
                        <td class="negrita">Licencia</td>
                        <td class="negrita">Nombre</td>
                    </tr>
                    <tr>
                        <td class="text-left">
                            {{ empty($materiaprima->camara_id)?'PENDIENTE':$materiaprima->camara->marca_placa }}
                        </td>
                        <td class="text-left">
                            {{ empty($materiaprima->camara_id)?'PENDIENTE':$materiaprima->camara->protocolo }}
                        </td>
                        <td class="text-left">
                            {{ empty($materiaprima->camara_id)?'PENDIENTE':$materiaprima->camara->capacidad }}
                        </td>
                        <td class="text-left">
                            {{ empty($materiaprima->camara_id)?'PENDIENTE':$materiaprima->chofer->licencia }}
                        </td>
                        <td class="text-left">
                            {{ empty($materiaprima->camara_id)?'PENDIENTE':$materiaprima->chofer->nombre }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="letra6">{!! htmlspecialchars_decode("&nbsp;") !!}</div>
        <div class="letra9 negrita">DATOS DEL MUELLE O DESEMBARCADERO DE DESCARGA</div>
        <div class="detalle">
            <table>
                <tbody>
                    <tr>
                        <td width="17%" class="text-left negrita">Nombre:</td>
                        <td width="48%" class="text-left">
                            {{ empty($materiaprima->muelle_id)?'PENDIENTE':$materiaprima->muelle->nombre }}
                        </td>
                        <td width="10%" class="text-left negrita">Protocolo:</td>
                        <td width="25%" class="text-left">
                            {{ empty($materiaprima->muelle_id)?'PENDIENTE':$materiaprima->muelle->protocolo }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="letra6">{!! htmlspecialchars_decode("&nbsp;") !!}</div>
        <div class="letra9 negrita">DATOS DE LA EMBARCACIÓN</div>
        <div class="detalle">
            <table>
                <tbody>
                    <tr>
                        <td width='48%' class="negrita">Nombre</td>
                        <td width='15%' class="negrita">Matrícula</td>
                        <td width='25%' class="negrita">Protocolo</td>
                        <td width='12%' class="negrita">Capacidad</td>
                    </tr>
                    @if ($embarcaciones)
                    @foreach ($embarcaciones as $embarcacion)
                    <tr>
                        <td>{{ $enombre[$embarcacion] }}</td>
                        <td>{{ $ematricula[$embarcacion] }}</td>
                        <td>{{ $eprotocolo[$embarcacion] }}</td>
                        <td>{{ $ecapacidad[$embarcacion] }}</td>
                    </tr>
                    @endforeach                        
                    @endif()
                </tbody>
            </table>
        </div>
        <div class="letra6">{!! htmlspecialchars_decode("&nbsp;") !!}</div>
        {{-- <table class="tabla">
            <tr>
                <th class="text-left letra9">
                    INFORMACIÓN PLANTA
                </th>
            </tr>
        </table> --}}
        <div class="letra9 negrita">INFORMACIÓN DE PLANTA</div>
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
                        <td class="text-left negrita" width='10%'>N° Cajas: </td>
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
            <table>
                <tbody>
                    <tr>
                        <td width='48%'>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="negrita">Pesada</td>
                                        <td class="negrita">P.Bruto</td>
                                        <td class="negrita">Tara</td>
                                        <td class="negrita">P.Neto</td>
                                        <td class="negrita">Acumulado</td>
                                    </tr>
                                    @php
                                        $acumulado = 0;
                                    @endphp
                                    @foreach ($tabla1 as $t1)
                                    @php
                                        $acumulado += $t1->pesoneto;
                                    @endphp
                                    <tr>
                                        <td>{{ $t1->pesada }}</td>
                                        <td>{{ $t1->pesobruto }}</td>
                                        <td>{{ $t1->tara }}</td>
                                        <td>{{ $t1->pesoneto }}</td>
                                        <td>{{ number_format($acumulado,2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                        {{-- <td width='2%'></td> --}}
                        <td width='48%' valign='top'>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="negrita">Pesada</td>
                                        <td class="negrita">P.Bruto</td>
                                        <td class="negrita">Tara</td>
                                        <td class="negrita">P.Neto</td>
                                        <td class="negrita">Acumulado</td>
                                    </tr>
                        
                                    @foreach ($tabla2 as $t1)
                                    @php
                                        $acumulado += $t1->pesoneto;
                                    @endphp
                                    <tr>
                                        <td>{{ $t1->pesada }}</td>
                                        <td>{{ $t1->pesobruto }}</td>
                                        <td>{{ $t1->tara }}</td>
                                        <td>{{ $t1->pesoneto }}</td>
                                        <td>{{ number_format($acumulado,2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @if ($materiaprima->rcompra_id)
        <div class="letra6">{!! htmlspecialchars_decode("&nbsp;") !!}</div>
        <div class="letra9 negrita">DIFERENCIA PRECIO PLANTA | COMPROBANTE DE PAGO</div>
        <div class="detalle">
            <table>
                <tbody>
                    <tr>
                        <td class="negrita text-center">Peso Planta</td>
                        <td class="negrita text-center">Precio</td>
                        <td class="negrita text-center">Total Planta</td>
                        <td class="negrita text-center">Total Comprobante</td>
                        <td class="negrita text-center">Diferencia</td>
                    </tr>
                    <tr>
                        <td class="text-center">{{ number_format($materiaprima->pplanta,2) }}</td>
                        <td class="text-center">{{ number_format($materiaprima->precio,2) }}</td>
                        <td class="text-center">{{ number_format($materiaprima->pplanta * $materiaprima->precio,2) }}</td>
                        <td class="text-center">{{ number_format($materiaprima->rcompra->total,2) }}</td>
                        <td class="text-center">{{ number_format(($materiaprima->pplanta * $materiaprima->precio) - $materiaprima->rcompra->total,2) }}</td>
                    </tr>

                </tbody>
            </table>
        </div>
        @endif



        
        
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