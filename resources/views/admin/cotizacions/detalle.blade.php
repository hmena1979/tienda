<table id= "grid" class="table table-hover table-sm">
    <thead>
        <tr>
            <th width='35%'>Producto</th>
            <th width='10%'>Cantidad</th>
            <th width='10%'>Precio</th>
            <th width='25%'>Glosa</th>
            <th class="text-right" width='10%'>SubTotal</th>
            <th width="10%">
                <button class="btn btn-block btn-addventa" type="button" id="additem">+</button>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($cotizacion->detcotizacions as $det)
        <tr>
            <td>{{ $det->producto->nombre . ' X ' . $det->producto->umedida->nombre }}</td>
            <td>{{ $det->cantidad }}</td>
            <td>{{ $det->precio }}</td>
            <td>{{ $det->glosa }}</td>
            <td class="text-right">{{ number_format($det->subtotal,2) }}</td>
            <td>
                <div class="opts">
                    {{-- <button type="button" class="btn" title="Editar" onclick="edititem('{{ $det->id }}');">
                        <i class="fas fa-edit"></i>
                    </button> --}}
                    <button type="button" class="btn" title="Eliminar" onclick="destroyitem('{{ $det->id }}');">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
        <tr>
            <td class="text-right negrita" colspan="4">TOTAL</td>
            <td class="text-right">{{ number_format($total,2) }}</td>
        </tr>
        </tbody>
</table>
<script>
    $('#additem').click(function(){
        $('#detalles').hide();
        $('#aeitem').show();
        $('#producto_id').select2({
            placeholder:"Ingrese 4 dígitos del Nombre del Producto",
            minimumInputLength: 4,
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