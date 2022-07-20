{{-- {{ $solcompra->detsolcompras }} --}}
<table id= "grid" class="table table-hover table-sm">
    <thead>
        <tr>
            <th>Producto</th>
            <th width='10%'>Solicitado</th>
            <th>Pedido N°</th>
            <th class="verde">Stock</th>
            <th width='10%'>Cantidad</th>
            <th>Glosa</th>
            <th width="8%">
                @if ($solcompra->estado == 1)
                <button class="btn btn-block btn-addventa" type="button" id="additem">+</button>
                @endif
            </th>
        </tr>
    </thead>
    <tbody> 
        @foreach($solcompra->detsolcompras as $det)
        <tr>
            <td>{{ $det->producto->nombre . ' X ' . $det->producto->umedida->nombre }}</td>
            <td>{{ $det->solicitado }}</td>
            <td>{{ $det->pedidos }}</td>
            <td class="verde">{{ $det->producto->stock }}</td>
            <td>{{ $det->cantidad }}</td>
            <td>{{ $det->glosa }}</td>
            <td>
                <div class="opts">
                    @if ($solcompra->estado == 1)
                    <button type="button" class="btn" title="Editar" onclick="edititem('{{ $det->id }}');">
                        <i class="fas fa-edit"></i>
                    </button>
                    @endif
                    @if ($solcompra->estado == 1)
                    <button type="button" class="btn" title="Eliminar" onclick="destroyitem('{{ $det->id }}');">
                        <i class="fas fa-trash-alt"></i>
                    </button>                        
                    @endif
                    @can('admin.ordcompras.create')
                    <a href="{{ route('admin.ordcompras.busproducto',$det->producto_id) }}"target="_blank" datatoggle="tooltip" data-placement="top" title="Buscar"><i class="fas fa-window-restore"></i></a>
                    @endcan
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $('#additem').click(function(){
        $('#detalles').hide();
        $('#aeitem').show();
        $('#producto_id').select2({
            placeholder:"Ingrese 3 dígitos del Nombre del Producto",
            minimumInputLength: 3,
            ajax:{
                url: "{{ route('admin.productos.seleccionadot') }}",
                dataType:'json',
                delay:250,
                processResults:function(response){
                    return{
                        results: response
                    };
                },
                cache: true,
            }
        });
    });
</script>