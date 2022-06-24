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
            RESIDUOS SÓLIDOS <br>
            PESAJE N°: {{ $residuo->ticket_balanza }}
        </div>
        <br>
        <div class="letra9 negrita">INFORMACIÓN DEL LOTE</div>
        <div class="detalle">
            <table>
                <tbody>
                    <tr>
                        <td class="text-left negrita" width='8%'>LOTE:</td>
                        <td class="text-left" width='12%'>{{ $residuo->lote }}</td>
                        <td class="text-left negrita" width='18%'>FECHA RECEPCIÓN:</td>
                        <td class="text-left" width='10%'>{{ $lote->finicial }}</td>
                        <td class="text-left negrita" width='10%'>ESPECIE:</td>
                        <td class="text-left" width='20%'>{{ $residuo->especie }}</td>
                        <td class="text-left negrita" width='5%'>TM:</td>
                        <td class="text-left" width='10%'>{{ $materiaprima/1000 }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="letra6">{!! htmlspecialchars_decode("&nbsp;") !!}</div>
        <div class="letra9 negrita">DATOS GENERALES</div>
        <div class="detalle">
            <table>
                <tbody>
                    <tr>
                        <td class="text-left negrita">CLIENTE:</td>
                        <td class="text-left">
                            {{ $residuo->cliente->numdoc_razsoc }}
                        </td>
                        <td class="text-left negrita">PESAJE N°:</td>
                        <td class="text-left">
                            {{ $residuo->ticket_balanza }}
                        </td>
                        <td class="text-left negrita">FECHA EMISIÓN:</td>
                        <td class="text-left">
                            {{ $residuo->emision }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left negrita">GUÍA MPS:</td>
                        <td>{{ $residuo->guiamps }}</td>
                        <td class="text-left negrita">GUÍA HL:</td>
                        <td>{{ $residuo->guiahl }}</td>
                        <td class="text-left negrita">GUÍA TRANSPORTISTA:</td>
                        <td>{{ $residuo->guiatrasporte }}</td>
                    </tr>
                    <tr>
                        <td class="text-left negrita">TOTAL KG:</td>
                        <td>{{ number_format($residuo->peso,2) }}</td>
                        <td class="text-left negrita">N° PLACA:</td>
                        <td colspan="3">{{ $residuo->placa }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
	</body>
</html>