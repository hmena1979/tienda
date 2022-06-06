<table id='detmasivo' class='table table-responsive-md table-hover table-bordered table-estrecha-ventas table-sb'>
    <thead>
        <tr class="colorprin negrita">
            <th width="30%">Proveedor</th>
            <th width="17%">Cuenta</th>
            <th width="3%">Tipo</th>
            <th width="3%">TD</th>
            <th width="7%">Número</th>
            <th class="text-right" width="10%">Monto PEN</th>
            <th class="text-right" width="10%">Monto USD</th>
            <th width="10%">
                @if ($masivo->estado == 1)
                <button class="btn btn-block btn-addventa" type="button" id="buslote" data-toggle="modal" data-target="#buscarLote" onclick="pendientes()">+</button>
                @endif
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($masivo->detmasivos as $det)
        <tr>
            <td>{{ $det->rcompra->cliente->razsoc }}</td>
            <td>{{ $det->cuenta }}</td>
            <td>{{ $det->tipo }}</td>
            <td>{{ $det->rcompra->tipocomprobante_codigo }}</td>
            <td datatoggle="tooltip" data-placement="top" title="{{ $det->rcompra->detalle }}">{{ numDoc($det->rcompra->serie,$det->rcompra->numero) }}</td>
            <td class="text-right">{{ number_format($det->montopen, 2) }}</td>
            <td class="text-right">{{ number_format($det->montousd,2) }}</td>
            <td class="text-center align-middle">
                <div class='opts'>
                    @if ($masivo->estado == 1)
                    <button type="button" class="btn" id='destroyitem' title="Eliminar" onclick="destroyitem('{{ $det->id }}');">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
        <tr class="@if ($masivo->cuenta->maximo < $masivo->detmasivos->sum('montopen'))rojo @endif">
            <td colspan="5" class="negrita text-right">TOTAL</td>
            <td class="@if ($masivo->cuenta->moneda == 'PEN')negrita @endif text-right">
                {{ number_format($masivo->detmasivos->sum('montopen'),2) }}
            </td>
            <td class="@if ($masivo->cuenta->moneda == 'USD')negrita @endif text-right">
                {{ number_format($masivo->detmasivos->sum('montousd'),2) }}
            </td>
            <td></td>
        </tr>
    </tbody>
</table>

<script>


</script>