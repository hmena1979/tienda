<table id='antecedente' class='table table-responsive-md table-hover table-bordered table-estrecha table-sb'>
    <thead>
        <tr class="colorprin negrita">
            <th width='45%'>PRODUCTO | SERVICIO</th>
            <th width='8%'>LOTE</th>
            <th width='8%'>VENCIMIENTO</th>
            <th width='8%'>CANTIDAD</th>
            @if ($rventa->tipo == 1)
            <th width='8%'>PRECIO</th>
            <th width='8%'>SUBTOTAL</th>                
            @endif
            <th width='7%'></th>
        </tr>
    </thead>
    <tbody>
        @foreach($rventa->detrventa as $det)
        {{-- {{ dd($ant->area) }} --}}
        <tr>
            <td>
                {{ $det->producto->nombre }} X {{ $det->producto->umedida->nombre }}
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
            <td class="align-middle">{{ $det->cantidad }}</td>
            @if ($rventa->tipo == 1)
            <td class="align-middle">{{ $det->precio }}</td>
            <td class="align-middle">{{ $det->subtotal }}</td>
            @endif
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
</table>