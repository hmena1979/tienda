<table id= "grid" class="table table-hover table-sm">
    <thead>
        <tr>
            <th>Producto</th>
            <th width='10%'>Cantidad</th>
            @if ($procesa)
            <th>Stock</th>
            @endif
            <th>Glosa</th>
            @if ($pedido->estado == 3)
            <th>Aprobado</th>
            <th>Motivo</th>
            @endif
            <th width="10%">
                @if ($pedido->estado == 1)
                <button class="btn btn-block btn-addventa" type="button" id="additem">+</button>
                @endif
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($pedido->detpedidos as $det)
        <tr>
            <td>{{ $det->producto->nombre . ' X ' . $det->producto->umedida->nombre }}</td>
            <td>{{ $det->cantidad }}</td>
            @if ($procesa)
            <td>{{ $det->producto->stock }}</td>
            @endif
            <td>{{ $det->glosa }}</td>
            @if ($pedido->estado == 3)
            <td>{{ $det->catendida }}</td>
            <td>{{ $det->motivo }}</td>
            @endif
            <td>
                <div class="opts">
                    @if ($procesa && $pedido->estado == 3)
                    <button type="button" class="btn" title="Editar" onclick="edititem('{{ $det->id }}');">
                        <i class="fas fa-edit"></i>
                    </button>
                    @endif
                    @if ($pedido->estado == 1)
                    <button type="button" class="btn" title="Eliminar" onclick="destroyitem('{{ $det->id }}');">
                        <i class="fas fa-trash-alt"></i>
                    </button>                        
                    @endif
                    @can('admin.ordcompras.create')
                    <a href="{{ route('admin.ordcompras.busproducto',$det->producto_id) }}"datatoggle="tooltip" data-placement="top" title="Buscar"><i class="fas fa-window-restore"></i></a>
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