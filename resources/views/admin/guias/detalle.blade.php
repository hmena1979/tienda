<table id='antecedente' class='table table-responsive-md table-hover table-bordered table-estrecha-ventas table-sb'>
    <thead>
        <tr class="colorprin negrita">
            <th width='45%'>PRODUCTO | SERVICIO</th>
            <th width='8%' class="text-right">CANTIDAD</th>
            <th width='7%'>
                <button type="button" id='adddetvta' class="btn btn-block btn-addventa" datatoggle="tooltip" data-placement="top" title="Agregar Item">+</button>
                {{-- <button class="btn btn-block btn-addventa" type="button" id="adddetvta" data-toggle="modal" data-target="#adddetalle" onclick="limpia()">+</button> --}}
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($detalle as $det)
        <tr>
            <td class="align-middle">
                {{ $det->producto->nombre }} X {{ $det->producto->umedida->nombre }}
                @if (!empty($det->adicional))
                    <br>{!! htmlspecialchars_decode(nl2br($det->adicional)) !!}
                @endif
            </td>
            <td class="align-middle text-right">{{ number_format($det->cantidad,2)  }}</td>
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
    $('#adddetvta').click(function(){
        $('.add').show();
        $('#adddetvta').hide();
        $('#agregarcliente').hide();
        $('#producto_id').select2({
            placeholder:"Ingrese 4 dígitos del Nombre del Producto",
            minimumInputLength: 4,
            ajax:{
                url: "{{ route('admin.productos.seleccionadoc') }}",
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

    if ($('#fin').val() == 1) {
        $('.finalizar').show();
        $('#finalizar').hide();
        $('#adddetvta').hide();
    }
    
</script>