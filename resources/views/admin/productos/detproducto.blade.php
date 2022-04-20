<table id='antecedente' class='table table-responsive-md table-hover table-sm table-bordered'>
    <thead>
        <tr>
            <th width='45%'>Nombre</th>
            <th width='8%'>Stock</th>
            <th width='8%'>Afecto</th>
            <th width='8%'>Precio</th>
            <th width='8%'>P.Mínimo</th>
            <th width='8%'>Vence</th>
            <th width='8%'>S.Mínimo</th>
            <th width='7%'></th>
        </tr>
    </thead>
    <tbody>
        @foreach($detproducto as $det)
        {{-- {{ dd($ant->area) }} --}}
        <tr>
            <td>
                {{ $det->producto->nombre }}
                @if ($det->marca_id <> 1)
                    {{ ' '.$det->marca->nombre.' ' }}
                @endif
                @if ($det->talla_id <> 1)
                    {{ ' TALLA '.$det->talla->nombre.' ' }}
                @endif
                @if ($det->color_id <> 1)
                    {{ ' COLOR '.$det->color->nombre.' ' }}
                @endif
            </td>
            <td>{{ $det->stock }}</td>
            <td>{{ $det->afecto==1 ? 'SI' : 'No' }}</td>
            <td>{{ $det->preventa }}</td>
            <td>{{ $det->preventamin }}</td>
            <td>{{ $det->lotevencimiento==1 ? 'SI' : 'No' }}</td>
            <td>{{ $det->stockmin }}</td>
            <td class="text-center">
                <div class='opts'>
                    {{-- <a href='{{ route('admin.colaboradors.editao',$ant) }}' datatoggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></a> --}}
                    <button type="button" class="btn" id='editdetp' title="Editar" onclick = "editdp('{{ $det->id }}');">
                    {{-- <button type="button" class="btn" title="Editar" id='editdetp'> --}}
                        <i class='fas fa-edit'></i>
                    </button>
                    <button type="button" class="btn" id='destroydetp' title="Eliminar" onclick="destroydp('{{ $det->id }}');">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>