<table id='antecedente' class='table table-responsive-md table-hover table-bordered table-estrecha-ventas table-sb'>
    <thead>
        <tr class="colorprin negrita">
            <th width='45%'>PRODUCTO | SERVICIO</th>
            <th width='8%'>LOTE</th>
            <th width='8%'>VENCIMIENTO</th>
            <th width='8%' class="text-right">CANTIDAD</th>
            <th width='8%' class="text-right">PRECIO</th>
            <th width='8%' class="text-right">SUBTOTAL</th>
            <th width='7%'>
                <button type="button" id='adddetvta' class="btn btn-block btn-addventa" datatoggle="tooltip" data-placement="top" title="Agregar Item">+</button>
                {{-- <button class="btn btn-block btn-addventa" type="button" id="adddetvta" data-toggle="modal" data-target="#adddetalle" onclick="limpia()">+</button> --}}
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($detalle as $det)
        {{-- {{ dd($ant->area) }} --}}
        <tr>
            <td class="align-middle">
                {{ $det->producto->nombre }} X {{ $det->producto->umedida->nombre }}
                @if (!empty($det->adicional))
                    <br>{!! htmlspecialchars_decode(nl2br($det->adicional)) !!}
                @endif
                {{-- @if ($det->detproducto->marca_id <> 1)
                    {{ ' '.$det->producto->marca->nombre.' ' }}
                @endif
                @if ($det->detproducto->talla_id <> 1)
                    {{ ' TALLA '.$det->detproducto->talla->nombre.' ' }}
                @endif
                @if ($det->detproducto->color_id <> 1)
                    {{ ' COLOR '.$det->detproducto->color->nombre.' ' }}
                @endif
                @if (!empty($det->adicional))
                    <br>{{$det->adicional}}
                @endif --}}
            </td>
            <td class="align-middle">{{ $det->lote }}</td>
            <td class="align-middle">{{ $det->vence }}</td>
            <td class="align-middle text-right">{{ number_format($det->cantidad,2)  }}</td>
            <td class="align-middle text-right">{{ number_format($det->precio,2)  }}</td>
            <td class="align-middle text-right">{{ number_format($det->subtotal,2)  }}</td>
            <td class="text-center align-middle">
                <div class='opts'>
                    {{-- <button type="button" class="btn" id='editdetp' title="Editar" onclick = "editdp('{{ $det->id }}');">
                        <i class='fas fa-edit'></i>
                    </button> --}}
                    <button type="button" class="btn" id='destroyitem' title="Eliminar" onclick="destroyitem('{{ $det->id }}');">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        @if ($gravado > 0)
        <tr>
            <th class="text-right" colspan="5">
                GRAVADO 
                @if ($moneda == 'PEN') S/ @else US$ @endif
            </th>
            <th class="text-center" colspan="2">{{ number_format($gravado,2) }}</th>
        </tr>
        @endif
        @if ($exonerado > 0)
        <tr>
            <th class="text-right" colspan="5">
                EXONERADO 
                @if ($moneda == 'PEN') S/ @else US$ @endif
            </th>
            <th class="text-center" colspan="2">{{ number_format($exonerado,2) }}</th>
        </tr>
        @endif
        @if ($inafecto > 0)
        <tr>
            <th class="text-right" colspan="5">
                INAFECTO 
                @if ($moneda == 'PEN') S/ @else US$ @endif
            </th>
            <th class="text-center" colspan="2">{{ number_format($inafecto,2) }}</th>
        </tr>
        @endif
        @if ($exportacion > 0)
        <tr>
            <th class="text-right" colspan="5">
                EXPORTACIÓN 
                @if ($moneda == 'PEN') S/ @else US$ @endif
            </th>
            <th class="text-center" colspan="2">{{ number_format($exportacion,2) }}</th>
        </tr>
        @endif
        @if ($gratuito > 0)
        <tr>
            <th class="text-right" colspan="5">
                GRATUITO 
                @if ($moneda == 'PEN') S/ @else US$ @endif
            </th>
            <th class="text-center" colspan="2">{{ number_format($gratuito,2) }}</th>
        </tr>
        @endif
        @if ($igv > 0)
        <tr>
            <th class="text-right" colspan="5">
                IGV 
                @if ($moneda == 'PEN') S/ @else US$ @endif
            </th>
            <th class="text-center" colspan="2">{{ number_format($igv,2) }}</th>
        </tr>
        @endif
        @if ($icbper > 0)
        <tr>
            <th class="text-right" colspan="5">
                ICBPER 
                @if ($moneda == 'PEN') S/ @else US$ @endif
            </th>
            <th class="text-center" colspan="2">{{ number_format($icbper,2) }}</th>
        </tr>
        @endif
        <tr>
            <th class="text-right colorprin" colspan="5">
                TOTAL
                @if ($moneda == 'PEN') S/ @else US$ @endif
            </th>
            <th class="text-center txt-convertir" colspan="2">
                <span id="items" class="oculto">{{ $items }}</span>
                <span id="total" class="oculto">{{ $total }}</span>
                <span>{{ number_format($total,2) }}</span>
            </th>
        </tr>
    </tfoot>
</table>
<script>
    $('#adddetvta').click(function(){
        $('.add').show();
        $('#adddetvta').hide();
        $('#grupo').val(1);
        $('#agregarcliente').hide();
        $('#producto_id').select2({
            placeholder:"Ingrese 4 dígitos del Nombre del Producto",
            minimumInputLength: 4,
            ajax:{
                url: "{{ route('admin.productos.seleccionadov') }}"+'/'+$('#moneda').val()+'/'+$('#grupo').val(),
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
        $('#totaldoc').text(NumberFormat($('#total').text(),2));
        $('.finalizar').show();
        $('#finalizar').hide();
        $('#adddetvta').hide();
        if ($('#fpago').val() == 1 && $('#mediopago').val() == '008' && $('#pagacon').val() > 0) {
            $('#vuelto').text(NumberFormat($('#pagacon').val() - $('#total').text(),2));
        }
    }
    
</script>