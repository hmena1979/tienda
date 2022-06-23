<div class="row">
    <div class="col-md-12">
        <table id= "grid" class="table table-hover table-sm">
            <thead>
                <tr>
                    <th width="22%">Producto</th>
                    <th width="18%">Código</th>
                    <th class="text-center" width="10%">Presentación</th>
                    <th class="text-center" width="10%">Peso</th>
                    <th class="text-center" width="10%">Cantidad</th>
                    <th class="text-center" width="10%">Total</th>
                    <th width="10%">
                        @if ($ingcamara->estado == 1)
                        <button type="button" id='additem' class="btn btn-block btn-addventa" datatoggle="tooltip" data-placement="top" title="Agregar Item">
                            +
                        </button>
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody> 
                @foreach($ingcamara->detingcamaras as $det)
                <tr>
                    <td>{{ $det->dettrazabilidad->trazabilidad->nombre }}</td>
                    <td>{{ $det->dettrazabilidad->mpd_codigo }}</td>
                    <td class="text-center">{{ $det->dettrazabilidad->envase==1?'Saco':'Block' }}</td>
                    <td class="text-center">{{ $det->peso }}</td>
                    <td class="text-center">{{ $det->cantidad }}</td>
                    <td class="text-center">{{ $det->total }}</td>
                    <td>
                        @if ($ingcamara->estado == 1)
                        <div class="opts">
                            <button type="button" class="btn" title="Editar" onclick="edititem('{{ $det->id }}');">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn" title="Eliminar" onclick="destroyitem('{{ $det->id }}');">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4"></td>
                    <th class="text-center">{{ number_format($ingcamara->detingcamaras->sum('cantidad'),2) }}</th>
                    <th class="text-center">{{ number_format($ingcamara->detingcamaras->sum('total'),2) }}</th>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    $('#additem').click(function(){
        $('#aeitem').show();
        $('#detalles').hide();
        $('#tipodet').val(1);
        $('#trazabilidad_id').focus();
    });
</script>