<table id='detmasivo' class='table table-responsive-md table-hover table-bordered table-estrecha-ventas table-sb'>
    <thead>
        <tr class="colorprin negrita">
            <th width="30%">Proveedor</th>
            <th width="5%">TD</th>
            <th width="10%">Número</th>
            <th class="text-right" width="15%">Monto PEN</th>
            <th class="text-right" width="15%">Monto USD</th>
            <th width="10%">
                <button class="btn btn-block btn-addventa" type="button" id="buslote" data-toggle="modal" data-target="#buscarLote" onclick="pendientes()">+</button>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($masivo->detmasivos as $det)
        <tr>
            <td>{{ $det->rcompra->cliente->razsoc }}</td>
            <td>{{ $det->rcompra->tipocomprobante_codigo }}</td>
            <td>{{ numDoc($det->rcompra->serie,$det->rcompra->numero) }}</td>
            <td>{{ $det->montopen }}</td>
            <td>{{ $det->montousd }}</td>
            <td class="text-center align-middle">
                <div class='opts'>
                    <button type="button" class="btn" id='destroyitem' title="Eliminar" onclick="destroyitem('{{ $det->id }}');">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>


</script>