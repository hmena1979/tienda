{{-- {{ $solcompra->detsolcompras }} --}}
<table id= "grid" class="table table-hover table-sm">
    <thead>
        <tr>
            <th>Producto</th>
            <th width='10%'>Solicitado</th>
            <th>Stock</th>
            <th width='10%'>Cantidad</th>
            <th>Glosa</th>
            <th>Motivo</th>
            <th width="10%">
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
            <td>{{ $det->producto->stock }}</td>
            <td>{{ $det->cantidad }}</td>
            <td>{{ $det->glosa }}</td>
            <td>{{ $det->motivo }}</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    // $('#additem').click(function(){
    //     $('#detalles').hide();
    //     $('#aeitem').show();
    //     $('#producto_id').select2({
    //         placeholder:"Ingrese 4 dígitos del Nombre del Producto",
    //         minimumInputLength: 4,
    //         ajax:{
    //             url: "{{ route('admin.productos.seleccionadot') }}",
    //             dataType:'json',
    //             delay:250,
    //             processResults:function(response){
    //                 return{
    //                     results: response
    //                 };
    //             },
    //             cache: true,
    //         }
    //     });
    // });
</script>